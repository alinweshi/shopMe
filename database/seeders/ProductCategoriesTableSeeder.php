<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productIds = range(1, 10);
        $categoryIds = range(1, 10);
        $productCategories = [];
        foreach ($productIds as $id) {
            $product = Product::find($id);
            $product->categories()->sync($categoryIds);
        }
    }
}
