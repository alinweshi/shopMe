<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\ApplyCouponRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // Add product to cart

    public function addToCart(AddToCartRequest $request)
    {
        $userId = Auth::id();
        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        $product = Product::find($request->product_id);

        if (! $product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        $quantity = $request->quantity ?? 1;

        try {
            DB::transaction(function () use ($cart, $product, $quantity) {
                // Update or create cart item
                $cartItems = $this->updateCartItem($cart, $product, $quantity);
                // dd($cartItems);
                // Recalculate cart total
                $cart->total_price = round($cart->cartItems->sum('final_price'), 2);
                $cart->save();
            });

            // Reload the cart with updated items
            $cart->load('cartItems');
            // dd($this->updateCartItem($cart, $product, $quantity)->sum('final_price'), $cart->cartItems->sum('final_price'));
            $totalItems = $cart->cartItems->sum('quantity');

            return response()->json(
                [
                    'message' => 'Added to cart successfully',
                    'cart' => $cart,
                    'totalItems' => $totalItems
                ],
                200
            );
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Failed to add to cart', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'Failed to update the cart.'], 500);
        }
    }

    public function updateCartItem($cart, $product, $quantity)
    {
        // Update or create the cart item
        $cartItem = CartItem::withTrashed()->firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        // Update cart item details
        $cartItem->quantity = ($cartItem->exists ? $cartItem->quantity : 0) + $quantity;
        $cartItem->original_price = $product->final_price;
        $cartItem->final_price = $cartItem->quantity * $cartItem->original_price;

        if ($cartItem->trashed()) {
            $cartItem->restore(); // Restore if soft deleted
        }

        $cartItem->save();

        // Return all cart items after updating
        return $cart->cartItems; // Ensure all items are returned as a collection
    }


    // View the cart
    public function viewCart()
    {
        $cartItems = [];
        $total = 0;
        $totalItems = 0; // Initialize to avoid undefined variable issues

        if (Auth::check()) {
            $user = Auth::user();
            $cart = Cart::where('user_id', $user->id)
                ->where('status', 'active')
                ->with('cartItems.product') // Eager load product relationship
                ->first();
            // dd($cart);

            if ($cart) {
                $cartItems = $cart->cartItems->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name ?? 'Unknown',
                        'product_image' => $item->product->image ?? 'Unknown',
                        'quantity' => $item->quantity,
                        "original_price" => $item->product->original_price,
                        'price' => $item->product->final_price, // Use product price as fallback
                        'final_price' =>
                        $item->product->final_price * $item->quantity,
                    ];
                })->toArray();
                $cart->save();
                // dd($cart);

                $total = $cart->cartItems->sum('final_price');
                // dd($cart->cartItems->sum('final_price'));
                $totalItems = $cart->cartItems->sum('quantity');
            }
        } else {
            $cartItems = session()->get('cart', []);

            $total = array_sum(
                array_map(function ($item) {
                    return $item['quantity'] * $item['price'];
                }, $cartItems)
            );

            $totalItems = array_sum(
                array_column($cartItems, 'quantity')
            );
        }

        return response()->json(
            [
                'cart' => $cart, // Include the cart only for authenticated users
                // 'cartItems' => $cartItems,
                'total' => $total,
                'totalItems' => $totalItems,
            ],
            200
        );
    }

    // Update cart item quantity
    public function updateCart(UpdateCartRequest $request, $id)
    {
        if (Auth::check()) {
            $cartItem = CartItem::findOrFail($id);
            $cartItem->update([
                'quantity' => $request->quantity,
                'final_price' => $cartItem->original_price * $request->quantity,
            ]);
            $totalItems = $cartItem->sum('quantity');
        } else {
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
            }
        }

        return response()->json(
            [
                'success' => 'Cart updated successfully.',
                'totalItems' => $totalItems,
            ],
            200,
        );
    }

    // Remove item from cart
    public function removeCartItem($id)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Find the cart item for the authenticated user by its ID
            $cartItem = CartItem::with(relations: 'cart')->find($id); // Eager load the 'cart' relationship
            // dd($cartItem, $id);
            $cartItem = CartItem::findOrFail($id); // Use findOrFail to ensure the item exists
            // Ensure the item belongs to the authenticated user
            if ($cartItem->cart->user_id === Auth::id()) {
                // Delete the cart item
                $cartItem->delete();

                return response()->json(['success' => 'Item removed from cart.'], 200);
            }

            return response()->json(['error' => 'Unauthorized action.'], 403);
        } else {
            // For guests, retrieve the cart from the session
            $cart = session()->get('cart', []);

            // Check if the item exists in the cart and remove it
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);

                return response()->json(['success' => 'Item removed from cart.'], 200);
            }

            return response()->json(['error' => 'Item not found in cart.'], 404);
        }
    }

    // Clear the entire cart
    public function clearCart()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cart = Cart::where('user_id', $user->id)->first();
            if ($cart) {
                CartItem::where('cart_id', $cart->id)->delete();
                $cart->delete();
            }
        } else {
            session()->forget('cart');
        }

        return response()->json([
            'success' => 'Cart cleared.',
            'cart' => [
                'cart_items' => [],
                'total_price' => 0
            ]
        ], 200);
    }

    // Apply coupon
    public function applyCoupon(ApplyCouponRequest $request)
    {
        $cart = Auth::check() ? Cart::where('user_id', Auth::id())->first() : session()->get('cart');
        // dd($cart);
        // dd(Cart::where('user_id', Auth::id())->first());
        $coupon = Coupon::where('code', $request->code)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('expires_at', '>=', now())->orWhereNull('expires_at');
            })
            ->first();
        // dd($coupon, $cart);
        if ($coupon) {
            if (Auth::check()) {
                $couponUsed = DB::table('coupon_user')->where('coupon_id', $coupon->id)->where('user_id', Auth::id())->exists();

                if ($couponUsed) {
                    return response()->json(['error' => 'Coupon already used'], 400);
                }
                $cart->coupon_id = $coupon->id;
                $discount = $cart->calculateDiscount($cart->total_price);
                $totalAfterDiscount = $cart->total_price - $discount;
                // dd($cart->total_price, $discount, $totalAfterDiscount);
                // Adjust each item price proportionally
                // dd($cart->total_price);
                foreach ($cart->cartItems as $item) {
                    $item->item_discount = round($item->original_price - (($cart->total_price - $discount) / $cart->total_price) * $item->original_price, 2);
                    $item->final_price = round($item->original_price - $item->item_discount, 2);

                    // dd($item->final_price, $item->original_price, $item->item_discount);
                    // dd($item->total_price, $item->discounted_price);
                    $item->save();
                }
                // dd($cart->cartItems);
                $cart->total_price = array_sum(
                    array_map(function ($item) {
                        return $item['quantity'] * $item['final_price'];
                    }, $cart->cartItems->toArray()),
                );
                // dd($cart->total_price);
                $cart->save();
                DB::table('coupon_user')->insert([
                    'coupon_id' => $coupon->id,
                    'user_id' => Auth::id(),
                    'used_at' => now(),
                ]);
            } else {
                if (isset($cart)) {
                    $totalPrice = array_sum(
                        array_map(function ($item) {
                            return $item['quantity'] * $item['price'];
                        }, $cart),
                    );

                    $discount = $coupon->discount_type == 'percentage' ? ($coupon->discount_value / 100) * $totalPrice : $coupon->discount_value;

                    // Adjust session cart items proportionally
                    foreach ($cart as &$item) {
                        $item['discounted_price'] = $item['price'] - (($discount / $totalPrice) * $item['price']);
                    }
                    session()->put('cart', $cart);

                    session()->put('cart_discount', $discount);
                    session()->put('cart_total_with_discount', max(0, $totalPrice - $discount));
                }
            }

            return response()->json(
                [
                    'success' => 'Coupon applied successfully.',
                    'discount' => $discount,
                    'total_price_after_discount' => round($cart->total_price ?? session()->get('cart_total_with_discount'), 2),
                    'coupon_type' => $coupon->discount_type,
                    'cartItems' => $cart->cartItems ?? session()->get('cart'),
                ],
                200,
            );
        } else {
            return response()->json(['error' => 'Invalid or expired coupon'], 400);
        }
    }
}
