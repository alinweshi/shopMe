<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;

class OrderService
{
    public function createOrderFromCart(Cart $cart, $request): Order
    {
        $order = new Order([
            'user_id' => $cart->user_id,
            'shipping_method_id' => $request->shipping_method_id,
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address,
            'status' => 'pending',
            'total_price' => $cart->total_price,
        ]);

        // Apply coupon if exists
        if ($cart->coupon_id) {
            $coupon = $cart->coupon;
            $order->fill([
                'coupon_code' => $coupon->code,
                'coupon_type' => $coupon->discount_type,
                'coupon_value' => $coupon->discount_value,
            ]);
        }

        $order->save();

        // Add order items
        foreach ($cart->cartItems as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->final_price ?? $cartItem->original_price,
                'total_price' => $cartItem->quantity * $cartItem->final_price ?? $cartItem->quantity * $cartItem->original_price,
            ]);
        }

        // Clear cart
        $cart->clear();

        return $order;
    }
}
