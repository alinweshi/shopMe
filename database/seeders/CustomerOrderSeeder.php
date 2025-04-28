<?php

namespace Database\Seeders;

use App\Models\CustomerOrder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   DB::table('customer_orders')->truncate();
        CustomerOrder::factory()->count(10000)->create();
    }
}
