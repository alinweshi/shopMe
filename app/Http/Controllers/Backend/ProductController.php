<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with('categories')->get();

        return view('backend.product.index', compact(var_name: 'products'));
    }
}
