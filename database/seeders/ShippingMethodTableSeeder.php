<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;

class ShippingMethodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shippingMethods = [
            [
                'name' => 'Standard Shipping',
                'cost' => 5.00,
                'delivery_time' => 5,
                'description' => 'Delivery in 5-7 business days.',
                'image' => 'standard_shipping.png',
                'slug' => 'standard-shipping',
                'is_default' => true,
                'is_free' => false,
                'is_pickup' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Express Shipping',
                'cost' => 15.00,
                'delivery_time' => 2,
                'description' => 'Delivery in 1-2 business days.',
                'image' => 'express_shipping.png',
                'slug' => 'express-shipping',
                'is_default' => false,
                'is_free' => false,
                'is_pickup' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Free Shipping',
                'cost' => 0.00,
                'delivery_time' => 7,
                'description' => 'Free shipping on orders over $50.',
                'image' => 'free_shipping.png',
                'slug' => 'free-shipping',
                'is_default' => false,
                'is_free' => true,
                'is_pickup' => false,
                'is_active' => true,
            ],
            [
                'name' => 'In-Store Pickup',
                'cost' => 0.00,
                'delivery_time' => 0,
                'description' => 'Pickup from the nearest store.',
                'image' => 'pickup_shipping.png',
                'slug' => 'in-store-pickup',
                'is_default' => false,
                'is_free' => true,
                'is_pickup' => true,
                'is_active' => true,
            ],
        ];

        foreach ($shippingMethods as $method) {
            ShippingMethod::create($method);
        }
    }
}
