<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get(); // Eager-load products

        return view('backend.category.index', compact('categories'));
    }
}
