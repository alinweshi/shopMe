<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
        'total_price',
    ];
    protected $casts = [
        'total_price' => 'float',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function calculateTotal()
    {
        return $this->cartItems->sum(function ($item) {
            return $item->total_price;
        });
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'cart_id')->withTrashed();
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function getTotalWithDiscount()
    {
        $total = $this->cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        // Apply coupon if available
        if ($this->coupon) {
            $discount = $this->calculateDiscount($total);
            $total -= $discount;
        }

        return max(0, $total);
    }

    public function calculateDiscount($total)
    {
        if ($this->coupon->discount_type === 'percentage') {
            return ($this->coupon->discount_value / 100) * $total;
        } else {
            return $this->coupon->discount_value;
        }
    }
    public function clear()
    {
        $this->cartItems()->delete();
    }
}
