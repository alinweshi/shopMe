<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('cart_items')->truncate();
        // Retrieve all existing carts
        $carts = Cart::all();

        // Loop through each cart and assign random products as cart items
        foreach ($carts as $cart) {
            // Fetch random products
            $products = Product::inRandomOrder()->limit(rand(1, 5))->get();

            foreach ($products as $product) {
                // Create cart items for each product
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'product_attribute_id' => null, // Adjust if product attributes are required
                    'quantity' => rand(1, 3),
                    'original_price' => $product->price,
                    'item_discount' => $product->price * rand(1, 3), // Example discount (10%)
                    'final_price' => $product->price * 0.9,
                ]);
            }
        }
    }
}
