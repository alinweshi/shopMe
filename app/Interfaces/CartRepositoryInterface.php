<?php

namespace App\Interfaces;

use App\Models\Cart;

interface CartRepositoryInterface
{
    public function getCartByUserId(int $userId): ?Cart;
    public function getOrCreateCartByUserId(int $userId): Cart;
    public function clearCart(Cart $cart): void;
}
