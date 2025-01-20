<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use App\Interfaces\CouponServiceInterface;

class CouponService implements CouponServiceInterface
{
    public function applyCoupon(Cart $cart, string $couponCode): array
    {
        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('expires_at', '>=', now())->orWhereNull('expires_at');
            })
            ->first();

        if (!$coupon) {
            throw new \Exception('Invalid or expired coupon.');
        }

        $discount = $coupon->discount_type === 'percentage'
            ? ($coupon->discount_value / 100) * $cart->total_price
            : $coupon->discount_value;

        $cart->coupon_id = $coupon->id;
        $cart->total_price -= $discount;
        $cart->save();

        DB::table('coupon_user')->insert([
            'coupon_id' => $coupon->id,
            'user_id' => $cart->user_id,
            'used_at' => now(),
        ]);

        return [
            'discount' => $discount,
            'total_price_after_discount' => $cart->total_price,
        ];
    }
}
