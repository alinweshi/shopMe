<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        // Products for 'Men' Clothing
        $product = Product::create([
            'name' => 'Men\'s Casual Shirt',
            'category_id' => 6, // Assuming 6 is the ID for 'Men' in Clothing
            'slug' => 'mens-casual-shirt',
            'image' => 'mens-casual-shirt.jpg',
            'price' => 29.99,
            'final_price'=>0.0,
            'description' => 'A stylish and comfortable casual shirt for men.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        $product = Product::create([

            'name' => 'Men\'s Jeans',
            'category_id' => 6,
            'slug' => 'mens-jeans',
            'image' => 'mens-jeans.jpg',
            'price' => 49.99,
            'final_price'=>0.0,
            'description' => 'Durable and trendy jeans for men.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        $product = Product::create([

            'name' => 'Men\'s Jacket',
            'category_id' => 6,
            'slug' => 'mens-jacket',
            'image' => 'mens-jacket.jpg',
            'price' => 89.99,
            'final_price'=>0.0,
            'description' => 'Warm and stylish jacket for men.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        // Products for 'Women' Clothing
        $product = Product::create([

            'name' => 'Women\'s Dress',
            'category_id' => 7,
            'slug' => 'womens-dress',
            'image' => 'womens-dress.jpg',
            'price' => 39.99,
            'final_price'=>0.0,
            'description' => 'Elegant and fashionable dress for women.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        $product = Product::create([

            'name' => 'Women\'s Handbag',
            'category_id' => 7,
            'slug' => 'womens-handbag',
            'image' => 'womens-handbag.jpg',
            'price' => 59.99,
            'final_price'=>0.0,
            'description' => 'Stylish handbag for women.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        $product = Product::create([

            'name' => 'Women\'s Shoes',
            'category_id' => 7,
            'slug' => 'womens-shoes',
            'image' => 'womens-shoes.jpg',
            'price' => 79.99,
            'final_price'=>0.0,
            'description' => 'Comfortable and trendy shoes for women.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        // Products for 'Children' Clothing
        $product = Product::create([

            'name' => 'Children\'s T-Shirt',
            'category_id' => 8,
            'slug' => 'childrens-t-shirt',
            'image' => 'childrens-t-shirt.jpg',
            'price' => 19.99,
            'final_price'=>0.0,
            'description' => 'Cute t-shirt for kids.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        $product = Product::create([

            'name' => 'Children\'s Jacket',
            'category_id' => 8,
            'slug' => 'childrens-jacket',
            'image' => 'childrens-jacket.jpg',
            'price' => 49.99,
            'final_price'=>0.0,
            'description' => 'Warm jacket for children.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        // Products for 'Mobile Phones' under Electronics
        $product = Product::create([

            'name' => 'iPhone 13',
            'category_id' => 9,
            'slug' => 'iphone-13',
            'image' => 'iphone-13.jpg',
            'price' => 999.99,
            'final_price'=>0.0,
            'description' => 'Apple iPhone 13 with 128GB storage.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        $product = Product::create([

            'name' => 'Samsung Galaxy S21',
            'category_id' => 9,
            'slug' => 'samsung-galaxy-s21',
            'image' => 'samsung-galaxy-s21.jpg',
            'price' => 799.99,
            'final_price'=>0.0,
            'description' => 'Samsung Galaxy S21 with 256GB storage.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        // Products for 'Laptops' under Electronics
        $product = Product::create([

            'name' => 'Dell XPS 13',
            'category_id' => 10,
            'slug' => 'dell-xps-13',
            'image' => 'dell-xps-13.jpg',
            'price' => 1099.99,
            'final_price'=>0.0,
            'description' => 'Dell XPS 13 with Intel i7 processor and 16GB RAM.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        $product = Product::create([

            'name' => 'MacBook Pro 16',
            'category_id' => 10,
            'slug' => 'macbook-pro-16',
            'image' => 'macbook-pro-16.jpg',
            'price' => 2499.99,
            'final_price'=>0.0,
            'description' => 'Apple MacBook Pro 16-inch with M1 chip.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        // Products for 'Furniture' under Home & Kitchen
        $product = Product::create([

            'name' => 'Wooden Dining Table',
            'category_id' => 13,
            'slug' => 'wooden-dining-table',
            'image' => 'wooden-dining-table.jpg',
            'price' => 499.99,
            'final_price'=>0.0,
            'description' => 'Classic wooden dining table with seating for six.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        $product = Product::create([

            'name' => 'Leather Sofa',
            'category_id' => 13,
            'slug' => 'leather-sofa',
            'image' => 'leather-sofa.jpg',
            'price' => 999.99,
            'final_price'=>0.0,
            'description' => 'Premium leather sofa with a modern design.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        // Products for 'Makeup' under Beauty & Health
        $product = Product::create([

            'name' => 'Foundation',
            'category_id' => 19,
            'slug' => 'foundation',
            'image' => 'foundation.jpg',
            'price' => 19.99,
            'final_price'=>0.0,
            'description' => 'Long-lasting foundation with SPF 15.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        $product = Product::create([

            'name' => 'Lipstick',
            'category_id' => 19,
            'slug' => 'lipstick',
            'image' => 'lipstick.jpg',
            'price' => 14.99,
            'final_price'=>0.0,
            'description' => 'Moisturizing lipstick with vibrant colors.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        // Products for 'Fiction' under Books
        $product = Product::create([

            'name' => 'The Great Gatsby',
            'category_id' => 16, // Fiction in Books
            'slug' => 'the-great-gatsby',
            'image' => 'the-great-gatsby.jpg',
            'price' => 10.99,
            'final_price'=>0.0,
            'description' => 'Classic novel by F. Scott Fitzgerald.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        $product = Product::create([

            'name' => '1984',
            'category_id' => 16,
            'slug' => '1984',
            'image' => '1984.jpg',
            'price' => 9.99,
            'final_price'=>0.0,
            'description' => 'Dystopian novel by George Orwell.',
        ]);
        $product->update(['final_price' => $product->getFinalPriceAttribute()]);

        $product->final_price = $product->getFinalPriceAttribute();
        $product->save();
    }

}