<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'start_date',
        'end_date',
        'is_active',
    ];

    /**
     * Get the products associated with the discount.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'discount_product');
    }

    /**
     * Get the categories associated with the discount.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'discount_category');
    }

    /**
     * Determine if the discount is currently active.
     */
    public function isActive()
    {
        $now = now();
        return $this->is_active && $this->start_date <= $now && $this->end_date >= $now;
    }
}
