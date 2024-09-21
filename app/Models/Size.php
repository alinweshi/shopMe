<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $fillable = ['size'];

    // Relationships
    public function sizeColorStyleCombinations()
    {
        return $this->hasMany(ProductSizeColorStyle::class);
    }
}
