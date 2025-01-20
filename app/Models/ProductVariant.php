<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'SKU', 'price', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // This is the many-to-many relationship between ProductVariant and AttributeValue via the variant_attributes table
    public function attributes()
    {
        return $this->belongsToMany(AttributeValue::class, 'variant_attributes')
            ->withPivot('attribute_value_id');
    }

    public function variantAttributes()
    {
        return $this->hasMany(VariantAttribute::class);
    }
}
