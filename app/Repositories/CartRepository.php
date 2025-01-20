<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class CartRepository implements CartRepositoryInterface
{
    public function getCartByUserId(int $userId): ?Cart
    {
        return Cache::remember("cart_{$userId}", 3600, function () use ($userId) {
            return Cart::with(['cartItems.product'])->where('user_id', $userId)->first();
        });
    }

    public function getOrCreateCartByUserId(int $userId): Cart
    {
        Cache::forget("cart_{$userId}");
        return Cart::firstOrCreate(['user_id' => $userId]);
    }

    public function clearCart(Cart $cart): void
    {
        $cart->cartItems()->delete();
        $cart->delete();
        Cache::forget("cart_{$cart->user_id}");
    }
}
