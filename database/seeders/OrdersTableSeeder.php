<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        Order::create([
            'user_id' => 1,
            'total_price' => 1200,
        ]);

        Order::create([
            'user_id' => 2,
            'total_price' => 999,
        ]);
    }
}
