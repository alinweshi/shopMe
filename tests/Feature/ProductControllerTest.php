<?php

// tests/Feature/ProductControllerTest.php
namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
        $response->assertStatus(200);

        // Assert the response matches the ProductResource structure
        $response->assertJsonStructure([
            'id',
            'name',
            'slug',
            'description',
            'price',
            'brand',
            'category_id',
            'image'
        ]);

        // Assert the response contains the product data
        $response->assertJson([
            'id' => $product->id,
            'name' => $product->name,
        ]);
    }

    public function test_show_returns_404_if_product_not_found()
    {
        // Make a GET request to a non-existent product ID
        $response = $this->get('/api/products/999');

        // Assert the response status is 404 (Not Found)
        $response->assertStatus(404);

        // Assert the response contains the error message
        $response->assertJson(['message' => 'Product not found']);
    }
    public function test_store_creates_product()
    {
        // Create fake data for the request
        $data = [
            'name' => 'Test Product',
            'slug' => 'test-product',
            'description' => 'This is a test product',
            'category_id' => 1,
            'brand' => 'Test Brand',
            'price' => 100,
            'discount_type' => 'percentage',
            'discount' => 10,
            'image' => 'test.jpg',
        ];

        // Make a POST request to the store endpoint
        $response = $this->post('/api/products', $data);

        // Assert the response status is 201 (Created)
        $response->assertStatus(201);

        // Assert the response contains the success message
        $response->assertJson(['message' => 'Product created successfully']);

        // Assert the product was saved in the database
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'slug' => 'test-product',
        ]);
    }
    public function test_update_updates_product()
    {
        // Create a product in the database
        $product = Product::factory()->create();

        // New data for the update
        $data = [
            'name' => 'Updated Product',
            'description' => 'This is an updated product',
            'price' => 200,
            'brand' => 'Updated Brand',
            'category' => 'Updated Category',
        ];

        // Make a PUT request to the update endpoint
        $response = $this->put("/api/products/{$product->id}", $data);

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the response contains the success message
        $response->assertJson(['message' => 'Product updated successfully']);

        // Assert the product was updated in the database
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
        ]);
    }
    public function test_delete_deletes_product()
    {
        // Create a product in the database
        $product = Product::factory()->create();

        // Make a DELETE request to the delete endpoint
        $response = $this->delete("/api/products/{$product->id}");

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the response contains the success message
        $response->assertJson(['message' => 'Product deleted successfully']);

        // Assert the product was deleted from the database
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    public function test_delete_returns_404_if_product_not_found()
    {
        // Make a DELETE request to a non-existent product ID
        $response = $this->delete('/api/products/999');

        // Assert the response status is 404 (Not Found)
        $response->assertStatus(404);

        // Assert the response contains the error message
        $response->assertJson(['message' => 'Product not found']);
    }
    public function test_getProductByCategory_returns_products()
    {
        // Create products in the database with a specific category
        Product::factory()->count(5)->create(['category' => 'Electronics']);
        Product::factory()->count(3)->create(['category' => 'Clothing']);

        // Make a GET request to the getProductByCategory endpoint
        $response = $this->get('/api/products/category/Electronics');

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the response contains 5 products (pagination)
        $response->assertJsonCount(5, 'data');

        // Assert the response structure matches the ProductResource
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'slug', 'description', 'price', 'brand', 'category_id', 'image']
            ],
            'links',
            'meta'
        ]);
    }
}
