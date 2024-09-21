<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        // Parent Categories
        Category::create(attributes: [
            'name' => 'Clothing',
            'parent_id' => null,
            'slug' => 'clothing',
            'image' => 'clothing.jpg',
            'description' => 'All kinds of clothing.',
        ]);

        Category::create([
            'name' => 'Electronics',
            'parent_id' => null,
            'slug' => 'electronics',
            'image' => 'electronics.jpg',
            'description' => 'Electronic devices and accessories.',
        ]);

        Category::create([
            'name' => 'Home & Kitchen',
            'parent_id' => null,
            'slug' => 'home-kitchen',
            'image' => 'home-kitchen.jpg',
            'description' => 'Home appliances and kitchenware.',
        ]);

        Category::create([
            'name' => 'Books',
            'parent_id' => null,
            'slug' => 'books',
            'image' => 'books.jpg',
            'description' => 'Books, novels, and educational material.',
        ]);

        Category::create(attributes: [
            'name' => 'Beauty & Health',
            'parent_id' => null,
            'slug' => 'beauty-health',
            'image' => 'beauty-health.jpg',
            'description' => 'Beauty and health products.',
        ]);

        // Subcategories under Clothing
        Category::create([
            'name' => 'Men',
            'parent_id' => 1, // Assuming 1 is the ID for 'Clothing'
            'slug' => 'men',
            'image' => 'men-clothing.jpg',
            'description' => 'Clothing for men.',
        ]);

        Category::create([
            'name' => 'Women',
            'parent_id' => 1, // Assuming 1 is the ID for 'Clothing'
            'slug' => 'women',
            'image' => 'women-clothing.jpg',
            'description' => 'Clothing for women.',
        ]);

        Category::create([
            'name' => 'Children',
            'parent_id' => 1, // Assuming 1 is the ID for 'Clothing'
            'slug' => 'children',
            'image' => 'children-clothing.jpg',
            'description' => 'Clothing for children.',
        ]);

        // Subcategories under Electronics
        Category::create([
            'name' => 'Mobile Phones',
            'parent_id' => 2, // Assuming 2 is the ID for 'Electronics'
            'slug' => 'mobile-phones',
            'image' => 'mobile-phones.jpg',
            'description' => 'Smartphones and mobile phones.',
        ]);

        Category::create([
            'name' => 'Laptops',
            'parent_id' => 2, // Assuming 2 is the ID for 'Electronics'
            'slug' => 'laptops',
            'image' => 'laptops.jpg',
            'description' => 'Laptops and notebooks.',
        ]);

        Category::create([
            'name' => 'Television',
            'parent_id' => 2, // Assuming 2 is the ID for 'Electronics'
            'slug' => 'television',
            'image' => 'television.jpg',
            'description' => 'LED, OLED, and Smart TVs.',
        ]);

        Category::create([
            'name' => 'Cameras',
            'parent_id' => 2, // Assuming 2 is the ID for 'Electronics'
            'slug' => 'cameras',
            'image' => 'cameras.jpg',
            'description' => 'Digital cameras and accessories.',
        ]);

        // Subcategories under Home & Kitchen
        Category::create([
            'name' => 'Furniture',
            'parent_id' => 3, // Assuming 3 is the ID for 'Home & Kitchen'
            'slug' => 'furniture',
            'image' => 'furniture.jpg',
            'description' => 'Home and office furniture.',
        ]);

        Category::create([
            'name' => 'Kitchen Appliances',
            'parent_id' => 3, // Assuming 3 is the ID for 'Home & Kitchen'
            'slug' => 'kitchen-appliances',
            'image' => 'kitchen-appliances.jpg',
            'description' => 'Appliances for kitchen use.',
        ]);

        Category::create([
            'name' => 'Home Decor',
            'parent_id' => 3, // Assuming 3 is the ID for 'Home & Kitchen'
            'slug' => 'home-decor',
            'image' => 'home-decor.jpg',
            'description' => 'Decor items for home.',
        ]);

        // Subcategories under Books
        Category::create([
            'name' => 'Fiction',
            'parent_id' => 4, // Assuming 4 is the ID for 'Books'
            'slug' => 'fiction',
            'image' => 'fiction-books.jpg',
            'description' => 'Fictional novels and stories.',
        ]);

        Category::create([
            'name' => 'Non-Fiction',
            'parent_id' => 4, // Assuming 4 is the ID for 'Books'
            'slug' => 'non-fiction',
            'image' => 'non-fiction-books.jpg',
            'description' => 'Non-fictional books.',
        ]);

        Category::create(attributes: [
            'name' => 'Educational',
            'parent_id' => 4, // Assuming 4 is the ID for 'Books'
            'slug' => 'educational',
            'image' => 'educational-books.jpg',
            'description' => 'Educational and academic books.',
        ]);

        // Subcategories under Beauty & Health
        Category::create([
            'name' => 'Makeup',
            'parent_id' => 5, // Assuming 5 is the ID for 'Beauty & Health'
            'slug' => 'makeup',
            'image' => 'makeup.jpg',
            'description' => 'Cosmetics and makeup products.',
        ]);

        Category::create([
            'name' => 'Skincare',
            'parent_id' => 5, // Assuming 5 is the ID for 'Beauty & Health'
            'slug' => 'skincare',
            'image' => 'skincare.jpg',
            'description' => 'Skincare products and treatments.',
        ]);

        Category::create([
            'name' => 'Haircare',
            'parent_id' => 5, // Assuming 5 is the ID for 'Beauty & Health'
            'slug' => 'haircare',
            'image' => 'haircare.jpg',
            'description' => 'Haircare products and treatments.',
        ]);
    }
}
