<?php

// tests/Feature/ProductControllerTest.php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Exceptions;
use App\Exceptions\ProductNotFoundException;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase; // Reset the database after each test

    public function test_index_returns_paginated_products()
    {
        // Create 15 products in the database
        Product::factory()->count(15)->create();

        // Make a GET request to the index endpoint
        $response = $this->get('/api/products');

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the response contains 10 products (pagination)
        $response->assertJsonCount(10, 'data');

        // Assert the response structure matches the ProductResource
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'slug', 'description', 'price', 'brand', 'category_id', 'image']
            ],
            'links',
            'meta'
        ]);
    }
    public function test_show_returns_product()
    {
        // Create a product in the database
        $product = Product::factory()->create();

        // Make a GET request to the show endpoint
        $response = $this->get("/api/products/{$product->id}");

        // Assert the response status is 200 (OK)
        // $response->dump();
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'categories',
                    'slug',
                    'description',
                    'category_id',
                    'brand',
                    'price',
                    'final_price',
                    'discount_type',
                    'discount',
                    'image',
                ]
            ]);
    }

    public function test_show_returns_404_if_product_not_found()
    {
        Exceptions::fake();

        // Create a product in the database
        $product = Product::factory()->create();
        // Make a GET request to a non-existent product ID
        $response = $this->get('/api/products/999');

        // Assert the response status is 404 (Not Found)
        $response->assertStatus(404);
        Exceptions::assertReported(ProductNotFoundException::class);

        // Assert the response contains the error message
        // $response->assertJson(['message' => 'Product not found']);
    }
    public function test_product_store(): void
    {
        $this->withoutMiddleware();

        $category = \App\Models\Category::factory()->create();
        // $image = UploadedFile::fake()->create('product.jpg', 500);
        // dd($image);

        Storage::fake('public');

        // $image = UploadedFile::fake()->image('product.jpg');
        $width = 100;
        $height = 100;
        $sizeInKilobytes = 1024;

        $image = UploadedFile::fake()->image('product.jpg', $width, $height)->size(100);
        $pdf = UploadedFile::fake()->create(
            'documents/document.pdf',
            $sizeInKilobytes,
            'application/pdf' //MIME_TYPE from validation 
        );
        // dd($pdf);



        // dd($image);
        $response = $this->postJson('api/products', [
            'name' => 'product 1',
            'slug' => 'product-1',
            "category_id" => $category->id,
            "brand" => 'brand 1',
            'description' => 'description 1',
            'price' => 100,
            "final_price" => 90,
            'discount_type' => 'percentage',
            'discount' => 10,
            'image' => $image,
        ]);
        // $response->dump();
        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'name',
                    'final_price',
                    'image'
                ]
            ])
            ->assertJson(
                fn(AssertableJson $json) =>
                $json->where('message', 'Product created successfully')
                    ->where('data.name', 'product 1')
                    // ->where('data.slug', 'product-1')
                    ->where('data.final_price', 90)
                    // ->where('data.category_id', $category->id)
                    // ->where('data.price', 100)
                    // ->where('data.discount', 10)
                    // ->where('data.discount_type', 'percentage')
                    ->missing('data.deleted_at')
                    /*
                                        Common Use Cases:
                    For Soft Deletable Models:

                    php
                    Copy
                    // Verify active records don't show deletion timestamp
                    ->missing('deleted_at')
                    For Sensitive Data:

                    php
                    Copy
                    // Ensure password fields aren't exposed
                    ->missing('password')
                    ->missing('password_confirmation')
                    For Hidden Fields:

                    php
                    Copy
                    // Check fields marked as $hidden in model
                    ->missing('api_token')*/
                    ->where('data.image', fn(string $image) => str($image)->contains('product'))
                    ->where('data.image', fn(string $image) => str($image)->endsWith('.jpg'))

                    ->etc()
            )
            ->assertJsonPath('message', 'Product created successfully')
            ->assertJsonPath('data.name', 'product 1')
            ->assertJsonPath('data.final_price', 90)
            ->assertJsonPath('data.final_price', fn(int $price) => $price > 0)


            ->assertJson([
                'message' => 'Product created successfully',
                "data" => [
                    "name" => "product 1",
                    "final_price" => 90,
                ]
                // 'data' => ['id', 'name', 'slug', 'category_id', 'brand', 'description', 'price', 'final_price', 'discount_type', 'discount', 'image']
            ]);
        $this->assertEquals('Product created successfully', $response['message']);

        $this->assertDatabaseHas('products', [
            'name' => 'product 1',
            'final_price' => 90,
        ]);
        // dump($image->hashName());
        Storage::disk('public')->assertExists('products/' . $image->hashName());

        // $image = Storage::putFile('/products', $image);
        // // dd($image);

        // Storage::disk('public')->assertExists($image);

        // Storage::disk('public')->deleteDirectory('product');
        // $response->dump();
    }
    // public function test_update_updates_product()
    // {
    //     // Create a product in the database
    //     $product = Product::factory()->create();

    //     // New data for the update
    //     $data = [
    //         'name' => 'Updated Product',
    //         'description' => 'This is an updated product',
    //         'price' => 200,
    //         'brand' => 'Updated Brand',
    //         'category' => 'Updated Category',
    //     ];

    //     // Make a PUT request to the update endpoint
    //     $response = $this->put("/api/products/{$product->id}", $data);

    //     // Assert the response status is 200 (OK)
    //     $response->assertStatus(200);

    //     // Assert the response contains the success message
    //     $response->assertJson(['message' => 'Product updated successfully']);

    //     // Assert the product was updated in the database
    //     $this->assertDatabaseHas('products', [
    //         'id' => $product->id,
    //         'name' => 'Updated Product',
    //     ]);
    // }
    // public function test_delete_deletes_product()
    // {
    //     // Create a product in the database
    //     $product = Product::factory()->create();

    //     // Make a DELETE request to the delete endpoint
    //     $response = $this->delete("/api/products/{$product->id}");

    //     // Assert the response status is 200 (OK)
    //     $response->assertStatus(200);

    //     // Assert the response contains the success message
    //     $response->assertJson(['message' => 'Product deleted successfully']);

    //     // Assert the product was deleted from the database
    //     $this->assertDatabaseMissing('products', [
    //         'id' => $product->id,
    //     ]);
    // }

    // public function test_delete_returns_404_if_product_not_found()
    // {
    //     // Make a DELETE request to a non-existent product ID
    //     $response = $this->delete('/api/products/999');

    //     // Assert the response status is 404 (Not Found)
    //     $response->assertStatus(404);

    //     // Assert the response contains the error message
    //     $response->assertJson(['message' => 'Product not found']);
    // }
    // public function test_getProductByCategory_returns_products()
    // {
    //     // Create products in the database with a specific category
    //     Product::factory()->count(5)->create(['category' => 'Electronics']);
    //     Product::factory()->count(3)->create(['category' => 'Clothing']);

    //     // Make a GET request to the getProductByCategory endpoint
    //     $response = $this->get('/api/products/category/Electronics');

    //     // Assert the response status is 200 (OK)
    //     $response->assertStatus(200);

    //     // Assert the response contains 5 products (pagination)
    //     $response->assertJsonCount(5, 'data');

    //     // Assert the response structure matches the ProductResource
    //     $response->assertJsonStructure([
    //         'data' => [
    //             '*' => ['id', 'name', 'slug', 'description', 'price', 'brand', 'category_id', 'image']
    //         ],
    //         'links',
    //         'meta'
    //     ]);
    // }
}
