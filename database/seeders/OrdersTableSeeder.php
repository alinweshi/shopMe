<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        // Create orders with complete details
        Order::create([
            'user_id' => 1,
            'invoice_number' => 1001,
            'shipping_method_id' => 1, // Assuming a shipping method with ID 1 exists
            'total_price' => 1200,
            'tax_amount' => 120, // Example tax amount
            'total_with_tax' => 1320, // Total including tax
            'discount' => 0, // No discount
            'coupon_code' => null, // No coupon used
            'coupon_type' => null,
            'coupon_value' => null,
            'status' => 'pending',
            'payment_method' => 'credit_card', // Example payment method
            'payment_date' => now(),
            'shipped_date' => null,
            'delivered_date' => null,
            'tracking_number' => null,
            'shipping_address' => '123 Main St, City, Country',
            'billing_address' => '456 Elm St, City, Country',
            'order_date' => now(),
        ]);

        Order::create([
            'user_id' => 2,
            'invoice_number' => 1002,
            'shipping_method_id' => 2, // Assuming a shipping method with ID 2 exists
            'total_price' => 999,
            'tax_amount' => 99.90, // Example tax amount
            'total_with_tax' => 1098.90, // Total including tax
            'discount' => 50, // Example discount
            'coupon_code' => 'SAVE50', // Example coupon used
            'coupon_type' => 'fixed',
            'coupon_value' => 50,
            'status' => 'completed',
            'payment_method' => 'paypal', // Example payment method
            'payment_date' => now(),
            'shipped_date' => now(),
            'delivered_date' => now(),
            'tracking_number' => 'TRACK123',
            'shipping_address' => '789 Pine St, City, Country',
            'billing_address' => '101 Maple St, City, Country',
            'order_date' => now(),
        ]);
    }
}
