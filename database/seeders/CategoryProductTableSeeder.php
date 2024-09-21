<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProductTableSeeder extends Seeder
{
    public function run()
    {
        // Example associations between products and categories
        DB::table('category_product')->insert([
            // iPhone 14 belongs to "Electronics" and "Smartphones" categories
            [
                'category_id' => 1, // Electronics
                'product_id' => 1, // iPhone 14
            ],
            [
                'category_id' => 2, // Smartphones
                'product_id' => 1, // iPhone 14
            ],

            // Slim Fit Shirt belongs to "Clothing" and "Men's Clothing" categories
            [
                'category_id' => 3, // Clothing
                'product_id' => 3, // Men's Slim Fit Shirt
            ],
            [
                'category_id' => 4, // Men's Clothing
                'product_id' => 3, // Men's Slim Fit Shirt
            ],

            // Coca-Cola belongs to "Beverages" and "Soft Drinks" categories
            [
                'category_id' => 5, // Beverages
                'product_id' => 6, // Coca-Cola
            ],
            [
                'category_id' => 6, // Soft Drinks
                'product_id' => 6, // Coca-Cola
            ],

            // Organic Almonds belong to "Food" and "Organic" categories

        ]);
    }
}
