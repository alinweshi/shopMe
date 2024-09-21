<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSizeColorStyle extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'size_id', 'color_id', 'style_id', 'quantity', 'price', 'discount_price'];
    protected $table = 'product_size_color_style';
    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function style()
    {
        return $this->belongsTo(Style::class);
    }
}
