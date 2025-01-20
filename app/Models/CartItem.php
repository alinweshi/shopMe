<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "id",
        'cart_id',
        'product_id',
        'product_attribute_id',
        'quantity',
        'original_price',
        'item_discount',
        'final_price',
    ];

    /**
     * Define the relationship with the Cart model.
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Define the relationship with the Product model.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Define the relationship with the ProductAttribute model.
     */
    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id');
    }

    /**
     * Calculate the total price of the cart item based on quantity and discounted price.
     */
    public function calculateTotalPrice()
    {
        return $this->quantity * ($this->discounted_price ?? $this->original_price);
    }
}
