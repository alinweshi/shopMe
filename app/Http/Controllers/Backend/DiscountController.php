<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function discountCategories()
    {
        $discounts = Discount::with('categories')->get();
        return view('backend.discount.discount-categories', compact('discounts'));
    }
    public function discountProducts()
    {
        $discounts = Discount::with('products')->get();
        return view('backend.discount.discount-products', compact('discounts'));
    }
}
