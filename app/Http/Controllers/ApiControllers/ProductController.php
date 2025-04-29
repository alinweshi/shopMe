<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\UploadFileService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\ProductResource;

use App\Http\Requests\StoreProductRequest;
use App\Exceptions\ProductNotFoundException;

class ProductController extends Controller
{
    public function __construct(public UploadFileService $uploadFileService)
    {
        $this->uploadFileService = $uploadFileService;
    }
    public function index()
    {
        return ProductResource::collection(Product::with('categories')->paginate(10));
        // return ProductResource::collection(Product::with('categories')->get());
    }

    public function show($id)
    {
        $product = Product::with('categories')->find($id);
        if (!$product) {
            throw new ProductNotFoundException();
        }
        return response()->json([
            'data' => new ProductResource($product)
        ]);
    }
    public function store(StoreProductRequest $request)
    {
        // The request is automatically validated at this point
        $validatedData = $request->validated();

        // Create the product using validated data
        $product = new Product();
        $product->name = $validatedData['name'];
        $product->slug = $validatedData['slug'];
        $product->description = $validatedData['description'];
        $product->category_id = $validatedData['category_id'];
        $product->brand = $validatedData['brand'];
        $product->price = $validatedData['price'];
        $product->discount_type = $validatedData['discount_type'];
        $product->discount = $validatedData['discount'];
        $product->final_price = $product->getDiscountedPriceAttribute();
        $product->image = $validatedData['image'];

        // Handle image upload
        if ($request->hasFile('image')) {
            $this->uploadFileService->uploadFile($validatedData['image']);
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return response()->json([
            'message' => 'Product created successfully',
            'data' => new ProductResource($product),
        ], 201);
    }
    public function update(Request $request, $id)
    {
        // Validate incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'brand' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Find the product by ID
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        if (! Gate::allows('update-post', $product)) {
            abort(403);
        }
        $product->lockForUpdate();
        // Update product
        $product->update($validated);

        return response()->json(['message' => 'Product updated successfully', 'data' => $product]);
    }
    public function delete($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json(["message" => "Product not found"], 404);
            }
            $product->delete();
            return response()->json(["message" => "Product deleted successfully"]);
        } catch (\Exception $e) {
            return response()->json(["message" => "Product not found"], 404);
        }
    }
    public function getProductByCategory($category)
    {
        $products = Product::where('category', $category)->paginate(10);
        return ProductResource::collection($products);
    }
}
