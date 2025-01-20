<?php

namespace App\Interfaces;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;

interface CartServiceInterface
{
    public function getCartByUserId(int $userId): ?Cart;
    public function getOrCreateCartByUserId(int $userId): Cart;
    public function addToCart(Cart $cart, Product $product, int $quantity): Cart;
    public function updateCartItem(Cart $cart, Product $product, int $quantity): CartItem;
    public function removeCartItem(Cart $cart, int $itemId): void;
    public function clearCart(Cart $cart): void;
    public function viewCart(Cart $cart): array;
}
