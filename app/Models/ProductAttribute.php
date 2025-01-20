<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'sku', 'price', 'stock', 'attribute_id', 'attribute_value_id'];

    /**
    * Get the product that owns the attribute.
    */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
    * Get the attribute associated with the product attribute.
    */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    /**
    * Get the attribute value associated with the product attribute.
    */
    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }
}
