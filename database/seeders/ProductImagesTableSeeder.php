<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImagesTableSeeder extends Seeder
{
    public function run()
    {
        // Images for Men - Shirts
        ProductImage::create([
            'product_id' => 1, // Assuming 1 is the ID for 'Men\'s Slim Fit Shirt'
            'image_url' => 'mens_slim_fit_shirt.jpg',
        ]);

        ProductImage::create([
            'product_id' => 2, // Assuming 2 is the ID for 'Men\'s Casual Shirt'
            'image_url' => 'mens_casual_shirt.jpg',
        ]);

        // Images for Men - Trousers
        ProductImage::create([
            'product_id' => 3, // Assuming 3 is the ID for 'Men\'s Formal Trousers'
            'image_url' => 'mens_formal_trousers.jpg',
        ]);

        ProductImage::create([
            'product_id' => 4, // Assuming 4 is the ID for 'Men\'s Casual Trousers'
            'image_url' => 'mens_casual_trousers.jpg',
        ]);

    }
}
