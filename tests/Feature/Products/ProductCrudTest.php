<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Psy\Exception\Exception;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Database\Seeders\ProductsTableSeeder;
use Illuminate\Support\Facades\Exceptions;
use Database\Seeders\CategoriesTableSeeder;
use App\Exceptions\ProductNotFoundException;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

class ProductCrudTest extends TestCase
{
    // use DatabaseMigrations;

    use RefreshDatabase;


    public function test_product_index(): void
    {
        // $user = User::factory()->create();
        // // dd($user);
        // $token = $user->createToken('test-token')->plainTextToken;
        // dd($token);
        $this->withoutMiddleware();
        $products = \App\Models\Product::factory()->count(3)->create();
        $response = $this->json('get', 'api/products');

        $response->dump();
        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(
                fn(AssertableJson $json) =>
                $json->has('data', 3)
                    ->has('meta')
                    ->has('links')
                    ->where('meta.current_page', 1)
                    ->where('meta.per_page', 10)
                    ->has(
                        'data.2',
                        fn(AssertableJson $json) =>
                        $json
                            // ->where('id', 1)
                            ->where('name', $products[2]->name)
                            ->whereType('id', ['string', 'integer'])

                            // ->where('email', fn(string $email) => str($email)->is('victoria@gmail.com'))
                            ->missing('discount_type')
                            ->etc()
                    )
            );
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
        dd($pdf);



        dd($image);
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
        dump($image->hashName());
        Storage::disk('public')->assertExists('products/' . $image->hashName());

        // $image = Storage::putFile('/products', $image);
        // // dd($image);

        // Storage::disk('public')->assertExists($image);

        // Storage::disk('public')->deleteDirectory('product');
        // $response->dump();
    }
    public function test_product_update(): void
    {

        $this->withoutMiddleware();
        Gate::shouldReceive('allows')->with('update-post', \Mockery::any())->andReturn(true);

        $category = \App\Models\Category::factory()->create();
        $image = UploadedFile::fake()->create('product.jpg', 500);
        $product = \App\Models\Product::factory()->create();
        // $response = $this->putJson("/products/" . $product->id . "/update", [ ... ]);

        $response = $this->putJson("api/products/{$product->id}/update", [
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
        // dump($response);
        $response->dump();
        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => ['id', 'name', 'slug', 'category_id', 'brand', 'description', 'price', 'final_price', 'discount_type', 'discount', 'image']
            ]);
    }
    public function test_product_delete(): void
    {
        $this->withoutMiddleware();
        $product = \App\Models\Product::factory()->create();
        if (!$product) {
            Exceptions::assertReported(ProductNotFoundException::class);
        }
        $response = $this->deleteJson("api/products/{$product->id}/delete");
        $response->assertStatus(200);
    }
    public function test_product_show(): void
    {
        $this->withoutMiddleware();
        Exceptions::fake();

        $product = \App\Models\Product::factory()->create();

        $response = $this->getJson("api/products/{$product->id}");

        Exceptions::assertNotReported(ProductNotFoundException::class);
        Exceptions::assertNothingReported();


        $response->assertStatus(200);
    }
    public function test_product_not_found(): void
    {
        $this->withoutMiddleware();
        $response = $this->getJson("api/products/1");
        $response->assertStatus(404);
    }
    public function test_product_not_found_exception(): void
    {
        // Disable middleware to focus on the core functionality
        $this->withoutMiddleware();

        // Start tracking exceptions
        Exceptions::fake();

        // Act: Make the API request
        $response = $this->getJson("api/products/1");
        // $response = $this->withoutExceptionHandling()->getJson("api/products/1");

        // Assert 1: Verify the exception was thrown internally
        Exceptions::assertReported(ProductNotFoundException::class);
        // Exceptions::assertReported(function (ProductNotFoundException $e) {
        //     return $e->getMessage() === 'Product not found.';
        // });

        // Assert 2: Verify the API returns a proper 404 response
        $response->assertStatus(404);

        // Optional: Verify the JSON error structure (recommended)
        $response->assertJson([
            'error' => 'Product not found.', // or your actual error message
        ]);
        $response->dump();
    }
    public function test_product_not_found_exception_not_reported(): void
    {
        // Disable middleware to focus on the core functionality
        $this->withoutMiddleware();

        // Start tracking exceptions
        Exceptions::fake();

        // Act: Make the API request
        $response = $this->getJson("api/products/1");

        $response->assertNotReported(ProductNotFoundException::class);
    }
    public function test_products_can_be_created()
    {
        // First seed categories, then products
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ProductsTableSeeder::class);
        $this->assertDatabaseCount('products', 18);
        $this->assertDatabaseHas('products', [
            'name' => 'Lipstick',
        ]);
        $product = Product::find(1);
        $this->assertEquals('Men\'s Casual Shirt', $product->name);
        $product = Product::factory()->create();
        $this->assertModelExists($product);
        $product->delete();

        $this->assertModelMissing($product);


        // $this->assertNotSoftDeleted($product);
    }
    protected function setUp(): void
    {
        parent::setUp();

        // Run migrations and seed necessary data
        $this->artisan('migrate:fresh');
    }
}
