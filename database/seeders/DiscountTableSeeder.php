<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Seeder;

class DiscountTableSeeder extends Seeder
{
    public function run()
    {
        // Create a percentage-based discount
        Discount::create([
            'name' => 'Summer Sale',
            'code' => 'SUMMER15', // Example code
            'type' => 'percentage',
            'value' => 15, // 15% off
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(20),
            'is_active' => true,
        ]);

        // Create a fixed amount discount
        Discount::create([
            'name' => 'New Year Special',
            'code' => 'NEWYEAR25', // Example code
            'type' => 'fixed',
            'value' => 25, // $25 off
            'start_date' => now(),
            'end_date' => now()->addDays(15),
            'is_active' => true,
        ]);

        // Create another percentage-based discount
        Discount::create([
            'name' => 'Flash Sale',
            'code' => 'FLASH10', // Example code
            'type' => 'percentage',
            'value' => 10, // 10% off
            'start_date' => now(),
            'end_date' => now()->addDays(7),
            'is_active' => true,
        ]);
    }
}
