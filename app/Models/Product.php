<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // The attributes that are mass assignable
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'brand',
        'price',
        'final_price',
        'discount_type',
        'discount',
        'image',
    ];

    /**
     * Get the categories that belong to the product.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get the product attributes for the product.
     */
    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    /**
     * Get the images for the product.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function discounts()
    {
        return $this->belongsToMany(Discount::class);
    }

    /**
     * Calculate the final price after discount (if applicable).
     */
    public function getDiscountedPriceAttribute()
    {
        if ($this->discount_type === 'percentage') {
            return $this->price - ($this->price * ($this->discount / 100));
        } elseif ($this->discount_type === 'fixed') {
            return $this->price - $this->discount;
        }

        return $this->price; // No discount
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionAble_id');
    }
}
