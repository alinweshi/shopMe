<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_number',
        'total_price',
        'status',
        'payment_method',
        'shipping_address_id',
        'billing_address_id',
        'shipping_method_id',
        'tax_rate',
        'tax_amount',
        'total_with_tax',
        'order_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionAble_id');
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function calculateTax()
    {
        // Retrieve tax rate from the order or shipping method
        $taxRate = $this->tax_rate ?? $this->shippingMethod->tax_rate ?? 0.1; // Default to 10%
        return $this->total_price * $taxRate;
    }

    public function getTotalWithTax()
    {
        return $this->total_price + $this->calculateTax();
    }

    // Accessors
    public function getTaxAmountAttribute()
    {
        return $this->tax_amount ?? $this->calculateTax();
    }

    public function getTotalWithTaxAttribute()
    {
        return $this->total_with_tax ?? $this->getTotalWithTax();
    }

    public function saveOrderWithTax()
    {
        $this->tax_amount = $this->calculateTax();
        $this->total_with_tax = $this->getTotalWithTax();
        $this->save();
    }
}
