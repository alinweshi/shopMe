<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Seeder;

class DiscountCategoryTableSeeder extends Seeder
{
    public function run()
    {
        // Attach discount to specific categories
        $discount1 = Discount::find(id: 1); // Assuming this is 'Summer Sale'
        $discount2 = Discount::find(2); // Assuming this is 'New Year Special'

        // Attach 'Summer Sale' discount to categories
        $discount1->categories()->attach([1, 2, 8, 9]); // Assuming category IDs 1 and 2

        // Attach 'New Year Special' discount to a different category
        $discount2->categories()->attach([3, 5, 6]); // Assuming category ID 3
    }
}
