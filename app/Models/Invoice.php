<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'status',
        'subtotal',
        'tax',
        'discount_amount',
        'shipping_fee',
        'total',
        'currency',
        'customer_name',
        'customer_mobile',
        'billed_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'total' => 'decimal:2',
        'billed_at' => 'datetime',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'invoice_number', 'invoice_number');
    }
}
