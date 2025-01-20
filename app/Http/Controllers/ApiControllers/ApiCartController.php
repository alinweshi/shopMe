<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddToCartRequest;
use App\Interfaces\CartServiceInterface;
use App\Interfaces\CouponServiceInterface;

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

        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
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
            return response()->json(['error' => 'Cart not found.'], 404);
        }

        return new CartResource($cart);
    }

    public function clearCart()
    {
        $userId = Auth::id();
        $cart = $this->cartService->getCartByUserId($userId);

        if (!$cart) {
            return response()->json(['error' => 'Cart not found.'], 404);
        }

        $this->cartService->clearCart($cart);
        return response()->json(['message' => 'Cart cleared successfully.'], 200);
    }
}
