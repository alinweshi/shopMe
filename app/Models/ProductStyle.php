<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStyle extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'style'];
    public function product()
    {
        return $this->hasMany(ProductStyle::class);
    }

    public function colorSizeStyleCombinations()
    {
        return $this->hasMany(ProductSizeColorStyle::class);
    }
}
