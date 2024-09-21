<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Seeder;

class DiscountProductTableSeeder extends Seeder
{
    public function run()
    {
        // Attach discount to specific products
        $discount1 = Discount::find(1); // Assuming this is 'Summer Sale'
        $discount2 = Discount::find(id: 3); // Assuming this is 'Flash Sale'

        // Attach 'Summer Sale' discount to products
        $discount1->products()->attach([1, 2, 3, 4, 5, 6, 7]); // Assuming product IDs 1 and 2

        // Attach 'Flash Sale' discount to another product
        $discount2->products()->attach([3, 4, 5, 9, 8, 7]); // Assuming product IDs 3 and 4
    }
}
