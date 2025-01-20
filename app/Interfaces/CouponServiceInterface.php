<?php

namespace App\Interfaces;


use App\Models\Cart;

interface CouponServiceInterface
{
    public function applyCoupon(Cart $cart, string $couponCode): array;
}
