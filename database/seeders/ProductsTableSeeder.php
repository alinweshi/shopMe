<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate the tables
        DB::table('cart_items')->truncate();
        DB::table('products')->truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        // Products for 'Men' Clothing
        Product::create([
            'name' => 'Men\'s Casual Shirt',
            'category_id' => 6,
            'slug' => 'mens-casual-shirt',
            'image' => 'http://localhost:8000/images/1.png',
            'price' => 29.99,
            'discount_type' => 'fixed',
            'discount' => 5.00,
            'final_price' => $this->calculateFinalPrice(29.99, 5.00, 0),
            'description' => 'A stylish and comfortable casual shirt for men.',
            'brand' => 'Brand A',
        ]);

        Product::create([
            'name' => 'Men\'s Jeans',
            'category_id' => 6,
            'slug' => 'mens-jeans',
            'image' => 'http://localhost:8000/images/2.png',
            'price' => 49.99,
            'discount_type' => 'percentage',
            'discount' => 10,
            'final_price' => $this->calculateFinalPrice(49.99, 0, 10),
            'description' => 'Durable and trendy jeans for men.',
            'brand' => 'Brand B',
        ]);

        Product::create([
            'name' => 'Men\'s Jacket',
            'category_id' => 6,
            'slug' => 'mens-jacket',
            'image' => 'http://localhost:8000/images/1.png',
            'price' => 89.99,
            'discount_type' => 'fixed',
            'discount' => 10.00,
            'final_price' => $this->calculateFinalPrice(89.99, 10.00, 0),
            'description' => 'Warm and stylish jacket for men.',
            'brand' => 'Brand C',
        ]);

        // Products for 'Women' Clothing
        Product::create([
            'name' => 'Women\'s Dress',
            'category_id' => 7,
            'slug' => 'womens-dress',
            'image' => 'http://localhost:8000/images/3.png',
            'price' => 39.99,
            'discount_type' => 'fixed',
            'discount' => 8.00,
            'final_price' => $this->calculateFinalPrice(39.99, 8.00, 0),
            'description' => 'Elegant and fashionable dress for women.',
            'brand' => 'Brand D',
        ]);

        Product::create([
            'name' => 'Women\'s Handbag',
            'category_id' => 7,
            'slug' => 'womens-handbag',
            'image' => 'http://localhost:8000/images/4.png',
            'price' => 59.99,
            'discount_type' => 'percentage',
            'discount' => 15,
            'final_price' => $this->calculateFinalPrice(59.99, 0, 15),
            'description' => 'Stylish handbag for women.',
            'brand' => 'Brand E',
        ]);

        Product::create([
            'name' => 'Women\'s Shoes',
            'category_id' => 7,
            'slug' => 'womens-shoes',
            'image' => 'http://localhost:8000/images/5.png',
            'price' => 79.99,
            'discount_type' => 'fixed',
            'discount' => 10.00,
            'final_price' => $this->calculateFinalPrice(79.99, 10.00, 0),
            'description' => 'Comfortable and trendy shoes for women.',
            'brand' => 'Brand F',
        ]);

        // Products for 'Children' Clothing
        Product::create([
            'name' => 'Children\'s T-Shirt',
            'category_id' => 8,
            'slug' => 'childrens-t-shirt',
            'image' => 'http://localhost:8000/images/6.png',
            'price' => 19.99,
            'discount_type' => 'fixed',
            'discount' => 2.00,
            'final_price' => $this->calculateFinalPrice(19.99, 2.00, 0),
            'description' => 'Cute t-shirt for kids.',
            'brand' => 'Brand G',
        ]);

        Product::create([
            'name' => 'Children\'s Jacket',
            'category_id' => 8,
            'slug' => 'childrens-jacket',
            'image' => 'http://localhost:8000/images/7.png',
            'price' => 49.99,
            'discount_type' => 'percentage',
            'discount' => 20,
            'final_price' => $this->calculateFinalPrice(49.99, 0, 20),
            'description' => 'Warm jacket for children.',
            'brand' => 'Brand H',
        ]);

        // Products for 'Mobile Phones' under Electronics
        Product::create([
            'name' => 'iPhone 13',
            'category_id' => 9,
            'slug' => 'iphone-13', 'image' => 'http://localhost:8000/images/8.png',
            'price' => 999.99,
            'discount_type' => 'fixed',
            'discount' => 100.00,
            'final_price' => $this->calculateFinalPrice(999.99, 100.00, 0),
            'description' => 'Apple iPhone 13 with 128GB storage.',
            'brand' => 'Apple',
        ]);

        Product::create([
            'name' => 'Samsung Galaxy S21',
            'category_id' => 9,
            'slug' => 'samsung-galaxy-s21',
            'image' => 'http://localhost:8000/images/9.png',
            'price' => 799.99,
            'discount_type' => 'percentage',
            'discount' => 10,
            'final_price' => $this->calculateFinalPrice(799.99, 0, 10),
            'description' => 'Samsung Galaxy S21 with 256GB storage.',
            'brand' => 'Samsung',
        ]);

        // Products for 'Laptops' under Electronics
        Product::create([
            'name' => 'Dell XPS 13',
            'category_id' => 10,
            'slug' => 'dell-xps-13',
            'image' => 'http://localhost:8000/images/10.png',
            'price' => 1099.99,
            'discount_type' => 'fixed',
            'discount' => 150.00,
            'final_price' => $this->calculateFinalPrice(1099.99, 150.00, 0),
            'description' => 'Dell XPS 13 with Intel i7 processor and 16GB RAM.',
            'brand' => 'Dell',
        ]);

        Product::create([
            'name' => 'MacBook Pro 16',
            'category_id' => 10,
            'slug' => 'macbook-pro-16',
            'image' => 'http://localhost:8000/images/11.png',
            'price' => 2499.99,
            'discount_type' => 'percentage',
            'discount' => 5,
            'final_price' => $this->calculateFinalPrice(2499.99, 0, 5),
            'description' => 'Apple MacBook Pro 16-inch with M1 chip.',
            'brand' => 'Apple',
        ]);

        // Products for 'Furniture' under Home & Kitchen
        Product::create([
            'name' => 'Wooden Dining Table',
            'category_id' => 13,
            'slug' => 'wooden-dining-table',
            'image' => 'http://localhost:8000/images/12.png',
            'price' => 499.99,
            'discount_type' => 'fixed',
            'discount' => 50.00,
            'final_price' => $this->calculateFinalPrice(499.99, 50.00, 0),
            'description' => 'Classic wooden dining table with seating for six.',
            'brand' => 'Furniture Co.',
        ]);

        Product::create([
            'name' => 'Leather Sofa',
            'category_id' => 13,
            'slug' => 'leather-sofa',
            'image' => 'http://localhost:8000/images/13.png',
            'price' => 999.99,
            'discount_type' => 'fixed',
            'discount' => 100.00,
            'final_price' => $this->calculateFinalPrice(999.99, 100.00, 0),
            'description' => 'Premium leather sofa with a modern design.',
            'brand' => 'Home Luxe',
        ]);

        // Products for 'Makeup' under Beauty & Health
        Product::create([
            'name' => 'Foundation',
            'category_id' => 19,
            'slug' => 'foundation',
            'image' => 'http://localhost:8000/images/14.png',
            'price' => 19.99,
            'discount_type' => 'fixed',
            'discount' => 2.00,
            'final_price' => $this->calculateFinalPrice(19.99, 2.00, 0),
            'description' => 'Long-lasting foundation with SPF 15.',
            'brand' => 'Beauty Brand',
        ]);

        Product::create([
            'name' => 'Lipstick',
            'category_id' => 19,
            'slug' => 'lipstick', 'image' => 'http://localhost:8000/images/15.png',
            'price' => 14.99,
            'discount_type' => 'percentage',
            'discount' => 10,
            'final_price' => $this->calculateFinalPrice(14.99, 0, 10),
            'description' => 'Moisturizing lipstick with vibrant colors.',
            'brand' => 'Beauty Brand',
        ]);

        // Products for 'Fiction' under Books
        Product::create([
            'name' => 'The Great Gatsby',
            'category_id' => 16,
            'slug' => 'the-great-gatsby',
            'image' => 'http://localhost:8000/images/16.png',
            'price' => 10.99,
            'discount_type' => 'fixed',
            'discount' => 1.00,
            'final_price' => $this->calculateFinalPrice(10.99, 1.00, 0),
            'description' => 'Classic novel by F. Scott Fitzgerald.',
            'brand' => 'Literature Co.',
        ]);

        Product::create([
            'name' => '1984',
            'category_id' => 16,
            'slug' => '1',
            'image' => 'http://localhost:8000/images/17.png',
            'price' => 9.99,
            'discount_type' => 'percentage',
            'discount' => 5,
            'final_price' => $this->calculateFinalPrice(9.99, 0, 5),
            'description' => 'Dystopian novel by George Orwell.',
            'brand' => 'Literature Co.',
        ]);
    }

    private function calculateFinalPrice($price, $fixedDiscount, $percentageDiscount)
    {
        if ($percentageDiscount > 0) {
            $price -= $price * ($percentageDiscount / 100);
        }
        if ($fixedDiscount > 0) {
            $price -= $fixedDiscount;
        }
        return max(0, $price); // Ensure the final price is not negative
    }
}
