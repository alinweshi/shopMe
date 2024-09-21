<?php

namespace Database\Seeders;

use App\Models\CartItem;
use Illuminate\Database\Seeder;

class CartItemsTableSeeder extends Seeder
{
    public function run()
    {
        CartItem::create([
            'session_id' => 1,
            'product_id' => 1,
            'quantity' => 2,
        ]);

        CartItem::create([
            'session_id' => 1,
            'product_id' => 2,
            'quantity' => 1,
        ]);
    }
}
