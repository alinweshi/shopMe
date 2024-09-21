<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::factory()->count(3)->create();
        Vendor::factory()->count(3)->create();
        // // Truncate the tables
        // User::truncate();
        // Address::truncate();
        // Product::truncate();
        // Category::truncate();
        // Favorite::truncate();
        // CartItem::truncate();
        // Order::truncate();
        // ProductImage::truncate();
        // OrderItem::truncate();
        // Attribute::truncate();
        // AttributeValue::truncate();
        // VariantAttribute::truncate();
        // ProductVariant::truncate();
        $this->call([

            UsersTableSeeder::class,
            AddressesTableSeeder::class,
            CategoriesTableSeeder::class,
            ProductsTableSeeder::class,
            FavoritesTableSeeder::class,
            CartItemsTableSeeder::class,
            OrdersTableSeeder::class,
            OrderItemsTableSeeder::class,
            AttributesTableSeeder::class,
            AttributeValuesTableSeeder::class,
            ProductAttributesTableSeeder::class,
            CategoryProductTableSeeder::class,
            DiscountTableSeeder::class,
            DiscountCategoryTableSeeder::class,
            DiscountProductTableSeeder::class,

        ]);
    }
}