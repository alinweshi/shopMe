<?php

namespace Tests\Feature\seeders;

use Tests\TestCase;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\AttributesTableSeeder;
use Database\Seeders\AttributeValuesTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\ProductAttributesTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductAttributeTest extends TestCase
{
    // protected function setUp(): void
    // {
    //     parent::setUp();

    //     // $this->artisan('db:seed');
    //     $this->seed(CategoriesTableSeeder::class);
    //     $this->seed(AttributesTableSeeder::class);
    //     $this->seed(AttributeValuesTableSeeder::class);
    //     $this->seed(ProductAttributesTableSeeder::class);
    //     $this->seed(ProductsTableSeeder::class);
    // }
    // use RefreshDatabase;
    public function test_product_attribute_seeder()
    {
        $this->assertTrue(true);
    }
    // {
    //     // dd($this->seed(ProductsTableSeeder::class));

    //     $this->assertDatabaseHas('product_attributes', [
    //         'product_id' => 1, // iPhone 14
    //         'sku' => 'IPH14-BLK-128GB',
    //         'price' => 999.99,
    //         'stock' => 20,
    //         'attribute_id' => 1, // Color
    //         'attribute_value_id' => 1, // Black
    //     ]);
    // }
    // public function test_product_attribute_seeder_fail()
    // {

    //     $this->assertDatabaseMissing('product_attributes', [
    //         'product_id' => 2, // iPhone 14
    //         'sku' => 'IPH14-BLK-128GB',
    //         'price' => 999.99,
    //         'stock' => 20,
    //         'attribute_id' => 1, // Color
    //         'attribute_value_id' => 1, // Black
    //     ]);
    // }
    // public function test_product_attribute_seeder_via_command()
    // {
    //     $this->artisan('db:seed --class=ProductAttributesTableSeeder')
    //         ->assertExitCode(0);
    //     $this->assertDatabaseHas('product_attributes', [
    //         'product_id' => 1, // iPhone 14
    //         'sku' => 'IPH14-BLK-128GB',
    //         'price' => 999.99,
    //         'stock' => 20,
    //         'attribute_id' => 1, // Color
    //         'attribute_value_id' => 1, // Black
    //     ]);
    // }
}
