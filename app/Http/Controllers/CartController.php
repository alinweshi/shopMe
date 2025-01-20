<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Add product to cart
    public function addToCart(Request $request)
    {
        $user = auth()->user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Retrieve the product
        $product = Product::find($request->product_id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // Check if the product already exists in the cart
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $request->product_id)
                            ->first();

        if ($cartItem) {
            // If the product already exists, update the quantity and total price
            $cartItem->quantity += 1; // or $request->quantity if provided
            $cartItem->total_price = $cartItem->quantity * $cartItem->original_price;
            $cartItem->save();
        } else {
            // If the product doesn't exist, create a new entry
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1, // or $request->quantity if provided
                'original_price' => $product->price,
                'total_price' => $product->price, // Initial total price (quantity * original_price)
            ]);
        }

        return redirect()->route('cart.view')->with('success', 'Product added to cart.');
    }



    // View the cart
    public function viewCart()
    {
        if (Auth::check()) {
            // Authenticated User
            $user = Auth::user();
            $cart = Cart::where('user_id', $user->id)->first();

            if (!$cart) {
                return view('front.cart.empty');
            }

            $cartItems = CartItem::where('cart_id', operator: $cart->id)->get();

            // Calculate total
            $total = $cartItems->sum('total_price');
        } else {
            // Guest user (retrieve cart from session)
            $cartItems = session()->get('cart', []);

            // Calculate total for guest user
            $total = array_sum(array_map(function ($item) {
                return $item['quantity'] * $item['price'];
            }, $cartItems));
        }

        return view('front.cart.view', compact('cartItems', 'total'));
    }
    // Update cart item quantity (applies to both guests and authenticated users)
    public function updateCart(Request $request, $id)
    {
        if (Auth::check()) {
            $cartItem = CartItem::findOrFail($id);
            $cartItem->update([
                'quantity' => $request->quantity,
                'total_price' => $cartItem->price * $request->quantity,
            ]);
        } else {
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $request->quantity;
                session()->put('cart', $cart);
            }
        }

        return redirect()->route('cart.view');
    }

    // Remove item from cart (for both guests and authenticated users)
    public function removeCartItem($id)
    {
        if (Auth::check()) {
            $cartItem = CartItem::findOrFail($id);
            $cartItem->delete();
        } else {
            $cart = session()->get('cart');
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }

        return redirect()->route('cart.view');
    }

    // Clear the entire cart (for both guests and authenticated users)
    public function clearCart()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cart = Cart::where('user_id', $user->id)->first();
            if ($cart) {
                CartItem::where('cart_id', $cart->id)->delete();
                Cart::where('user_id', $user->id)->delete();
            }
        } else {
            session()->forget('cart');
        }

        return redirect()->route('cart.view');
    }
    public function applyCoupon(Request $request)
    {
        if (Auth::check()) {
            // For Authenticated User
            $cart = Cart::where('id', $request->cart_id)->first();
        } else {
            // For Guest User (retrieve cart from session)
            $cart = session()->get('cart');
        }

        // Find the coupon
        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('expires_at', '>=', now())->orWhereNull('expires_at');
            })
            ->first();

        if ($coupon) {
            if (Auth::check()) {
                // Authenticated User: Update cart with coupon ID and apply discount
                $cart->coupon_id = $coupon->id;
                $cart->save();

                // Calculate discount based on coupon type
                if ($coupon->discount_type == 'percentage') {
                    $discount = ($coupon->discount_value / 100) * $cart->total_price;
                } else {
                    $discount = $coupon->discount_value;
                }

                // Apply discount to total price and save
                $cart->total_price = max(0, $cart->total_price - $discount);
                $cart->save();
            } else {
                // Guest User: Apply discount to cart stored in session
                if (isset($cart)) {
                    // Calculate discount based on coupon type
                    $totalPrice = array_sum(array_map(function ($item) {
                        return $item['quantity'] * $item['price'];
                    }, $cart));

                    if ($coupon->discount_type == 'percentage') {
                        $discount = ($coupon->discount_value / 100) * $totalPrice;
                    } else {
                        $discount = $coupon->discount_value;
                    }

                    // Store the updated total price with discount in session
                    session()->put('cart_discount', $discount);
                    session()->put('cart_total_with_discount', max(0, $totalPrice - $discount));
                }
            }

            return response()->json(['message' => 'Coupon applied successfully!', 'cart' => $cart]);
        } else {
            return response()->json(['error' => 'Invalid or expired coupon'], 400);
        }
    }

}
