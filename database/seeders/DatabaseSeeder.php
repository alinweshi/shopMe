<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Review;
use App\Models\Vendor;
use App\Models\Address;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Attribute;
use App\Models\OrderItem;
use App\Models\ProductImage;
use App\Models\AttributeValue;
use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\AdminsTableSeeder;
use Database\Seeders\CouponTableSeeder;
use PHPUnit\Framework\Attributes\Ticket;
use Database\Seeders\AddressesTableSeeder;
use Database\Seeders\CartItemsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Truncate the tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        try {
            User::truncate();
            Address::truncate();
            Product::truncate();
            Category::truncate();
            Favorite::truncate();
            CartItem::truncate();
            Order::truncate();
            OrderItem::truncate();
            Attribute::truncate();
            AttributeValue::truncate();
            Admin::truncate();
            Review::truncate();
            Vendor::truncate();
            ShippingMethod::truncate();
            // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            // Seed factories
            User::factory()->count(10)->create();
            Admin::factory()->count(2)->create();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->call([

                UsersTableSeeder::class,
                AddressesTableSeeder::class,
                CategoriesTableSeeder::class,
                ProductsTableSeeder::class,
                FavoritesTableSeeder::class,
                CouponTableSeeder::class,
                CartTableSeeder::class,
                CartItemsTableSeeder::class,
                ShippingMethodTableSeeder::class,
                OrdersTableSeeder::class,
                OrderItemsTableSeeder::class,
                AttributesTableSeeder::class,
                AttributeValuesTableSeeder::class,
                ProductAttributesTableSeeder::class,
                CustomersSeeder::class,
                // DiscountTableSeeder::class,
                FavoritesTableSeeder::class,
                // ProductImagesTableSeeder::class,
                ReviewsTableSeeder::class,
                RoleTableSeeder::class,
                PermissionTableSeeder::class,
                RolePermissionTableSeeder::class,
                VendorsTableSeeder::class,
                AdminsTableSeeder::class,
                ShippingMethodTableSeeder::class,
                TicketsSeeder::class,
                BookingsSeeder::class,




            ]);
        } catch (\Exception $e) {
            // Re-enable foreign key checks on error
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            throw $e;
        }
    }
}
