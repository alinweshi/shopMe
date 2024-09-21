<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use Illuminate\Database\Seeder;

class ProductAttributesTableSeeder extends Seeder
{
    public function run()
    {
        // iPhone 14 Attributes
        ProductAttribute::create([
            'product_id' => 1, // iPhone 14
            'sku' => 'IPH14-BLK-128GB',
            'price' => 999.99,
            'stock' => 20,
            'attribute_id' => 1, // Color
            'attribute_value_id' => 1, // Black
        ]);

        ProductAttribute::create([
            'product_id' => 1,
            'sku' => 'IPH14-WHT-256GB',
            'price' => 1099.99,
            'stock' => 15,
            'attribute_id' => 1, // Color
            'attribute_value_id' => 2, // White
        ]);

        // Men's Slim Fit Shirt Attributes
        ProductAttribute::create([
            'product_id' => 3, // Slim Fit Shirt
            'sku' => 'M-SHIRT-BLK-SM',
            'price' => 29.99,
            'stock' => 40,
            'attribute_id' => 1, // Color
            'attribute_value_id' => 1, // Black
        ]);

        ProductAttribute::create([
            'product_id' => 3,
            'sku' => 'M-SHIRT-BLK-LG',
            'price' => 29.99,
            'stock' => 35,
            'attribute_id' => 2, // Size
            'attribute_value_id' => 3, // Large
        ]);

        // Coca-Cola 500ml Attribute (no attribute applied)
        ProductAttribute::create([
            'product_id' => 6, // Coca-Cola
            'sku' => 'COKE-500ML',
            'price' => 1.99,
            'stock' => 100,
            'attribute_id' => 2,
            'attribute_value_id' => 3, // No attribute for this product
        ]);
    }
}
