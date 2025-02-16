<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\CartServiceInterface;

class CartService implements CartServiceInterface
{
    protected CartRepositoryInterface $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getCartByUserId(int $userId): ?Cart
    {
        return $this->cartRepository->getCartByUserId($userId);
    }

    public function getOrCreateCartByUserId(int $userId): Cart
    {
        return $this->cartRepository->getOrCreateCartByUserId($userId);
    }

    public function addToCart(Cart $cart, Product $product, int $quantity): Cart
    {
        return DB::transaction(function () use ($cart, $product, $quantity) {
            $cartItem = $this->updateCartItem($cart, $product, $quantity);
            $cart->total_price = $cart->cartItems->sum('final_price');
            $cart->save();
            return $cart;
        });
    }

    public function updateCartItem(Cart $cart, Product $product, int $quantity): CartItem
    {
        $cartItem = CartItem::withTrashed()->firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        // $cartItem->quantity = ($cartItem->exists ? $cartItem->quantity : 0) + $quantity;
        $cartItem->quantity = $quantity; // Directly set the quantity
        $cartItem->original_price = $product->final_price;
        $cartItem->final_price = $cartItem->quantity * $cartItem->original_price;

        if ($cartItem->trashed()) {
            $cartItem->restore();
        }

        $cartItem->save();
        return $cartItem;
    }

    public function removeCartItem(Cart $cart, int $itemId): void
    {
        $cartItem = CartItem::findOrFail($itemId);
        if ($cartItem->cart_id === $cart->id) {
            $cartItem->delete();
        }
    }

    public function clearCart(Cart $cart): void
    {
        $this->cartRepository->clearCart($cart);
    }

    public function viewCart(Cart $cart): array
    {
        $cart->load('cartItems.product');
        return [
            'cart' => $cart,
            'total' => $cart->cartItems->sum('final_price'),
            'totalItems' => $cart->cartItems->sum('quantity'),
        ];
    }
    public function updateCart($request)
    {
        $userId = Auth::id();
    }
}
