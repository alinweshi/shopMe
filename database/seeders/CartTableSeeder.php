<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CartTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Fetch all users from the database
        $users = User::all();
        // Fetch all available coupons
        $coupons = Coupon::all();

        // Loop through each user and create carts
        foreach ($users as $user) {
            // Create a cart for each user
            Cart::create([
                'user_id' => $user->id,
                'session_id' => Str::random(40),
                'coupon_id' => $coupons->random()->id ?? null, // Randomly assign a coupon if available
                'cart_expiry' => now()->addDays(3), // Set cart expiry date 3 days from now
                'status' => collect(['active', 'abandoned', 'completed'])->random(), // Random cart status
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'ip_address' => '192.168.1.' . rand(1, 255),
            ]);
        }
    }
}
