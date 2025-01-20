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
            'image_url' => asset('images/1.png'),
        ]);

        ProductImage::create([
            'product_id' => 2, // Assuming 2 is the ID for 'Men\'s Casual Shirt'
            'image_url' => asset('images/2.png'),
        ]);

        // Images for Men - Trousers
        ProductImage::create([
            'product_id' => 3, // Assuming 3 is the ID for 'Men\'s Formal Trousers'
            'image_url' => asset('images/3.png'),
        ]);

        ProductImage::create([
            'product_id' => 4, // Assuming 4 is the ID for 'Men\'s Casual Trousers'
            'image_url' => asset('images/4.png'),
        ]);

        // Images for Women - Skirts
        ProductImage::create([
            'product_id' => 5, // Assuming 5 is the ID for 'Women\'s A-Line Skirt'
            'image_url' => asset('images/5.png'),
        ]);

        ProductImage::create([
            'product_id' => 6, // Assuming 6 is the ID for 'Women\'s Midi Skirt'
            'image_url' => asset('images/6.png'),
        ]);
        // Images for Women - Dresses
        ProductImage::create([
            'product_id' => 7, // Assuming 7 is the ID for 'Women\'s Maxi Dress'
            'image_url' => asset('images/7.png'),
        ]);

        ProductImage::create([
            'product_id' => 8, // Assuming 8 is the ID for 'Women\'s Midi Dress'
            'image_url' => asset('images/8.png'),
        ]);
        ProductImage::create([
            'product_id' => 9, // Assuming 8 is the ID for 'Women\'s Midi Dress'
            'image_url' => asset('images/9.png'),
        ]);
        ProductImage::create([
            'product_id' => 10, // Assuming 8 is the ID for 'Women\'s Midi Dress'
            'image_url' => asset('images/10.png'),
        ]);
        ProductImage::create([
            'product_id' => 11, // Assuming 8 is the ID for 'Women\'s Midi Dress'
            'image_url' => asset('images/11.png'),
        ]);
        ProductImage::create([
            'product_id' => 12, // Assuming 8 is the ID for 'Women\'s Midi Dress'
            'image_url' => asset('images/12.png'),
        ]);


    }
}
