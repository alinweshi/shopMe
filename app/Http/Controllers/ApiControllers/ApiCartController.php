<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\AddToCartRequest;
use App\Interfaces\CartServiceInterface;
use App\Exceptions\CartNotFoundException;
use App\Interfaces\CouponServiceInterface;
use App\Exceptions\ProductNotFoundException;
use App\Http\Requests\updateCartItemRequest;
use Illuminate\Auth\Access\AuthorizationException;

class ApiCartController extends Controller
{
    public function __construct(
        protected CartServiceInterface $cartService,
        protected CouponServiceInterface $couponService
    ) {}

    public function addToCart(AddToCartRequest $request)
    {
        $userId = Auth::id();
        $cart = $this->cartService->getOrCreateCartByUserId($userId);

        // Authorize the action
        Gate::authorize('addToCart', $cart);

        $product = Product::find($request->product_id);
        if (!$product) {
            throw new ProductNotFoundException();
        }

        try {
            $cart = $this->cartService->addToCart($cart, $product, $request->quantity ?? 1);
            return response()->json([
                'message' => 'Added to cart successfully',
                'cart' => new CartResource($cart),
                'totalItems' => $cart->cartItems->sum('quantity'),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Failed to add to cart', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update the cart.'], 500);
        }
    }

    public function viewCart()
    {
        $userId = Auth::id();
        $cart = $this->cartService->getCartByUserId($userId);

        if (!$cart) {
            throw new CartNotFoundException();
        }

        // Authorize the action
        Gate::authorize('viewCart', $cart);

        return response()->json([
            'cart' => new CartResource($cart),
            'totalItems' => $cart->cartItems->sum('quantity'),
        ], 200);
    }

    public function clearCart()
    {
        $userId = Auth::id();
        $cart = $this->cartService->getCartByUserId($userId);

        if (!$cart) {
            throw new CartNotFoundException();
        }

        // Authorize the action
        Gate::authorize('clearCart', $cart);

        $this->cartService->clearCart($cart);
        return response()->json([
            'message' => 'Cart cleared successfully.',
        ], 200);
    }

    public function updateCartItem(updateCartItemRequest $request, $cartItemId)
    {
        $cartItem = CartItem::withTrashed()->find($cartItemId);
        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        }

        $cart = $cartItem->cart;

        // Authorize the action
        Gate::authorize('updateCartItem', $cart);

        $product = Product::find($request->product_id);
        if (!$product) {
            throw new ProductNotFoundException();
        }

        // Validate the request
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Update the cart item
        $updatedCartItem = $this->cartService->updateCartItem(
            $cart,
            $product,
            $request->quantity
        );

        // Recalculate the cart total
        $cart->total_price = $cart->cartItems->sum('final_price');
        $cart->save();

        return response()->json([
            'message' => 'Cart item updated successfully',
            'cart' => new CartResource($cart),
            'totalItems' => $cart->cartItems->sum('quantity'),
        ], 200);
    }
}
