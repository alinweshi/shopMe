<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'transactionable_id',
        'transactionable_type',
        'invoice_number',
        'status',
        'subtotal',
        'tax',
        'discount_amount',
        'shipping_fee',
        'net_total',
        'currency',
        'payment_method',
        'reference_id',
        'billed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'net_total' => 'decimal:2',
        'billed_at' => 'datetime',
    ];

    /**
     * Get the parent transactionable model (order, user, etc.).
     */
    public function transactionable()
    {
        return $this->morphTo();
    }

    /**
     * Accessor to calculate the total tax as a percentage of the subtotal.
     */
    public function getTaxPercentageAttribute()
    {
        return $this->subtotal > 0
            ? round(($this->tax / $this->subtotal) * 100, 2)
            : 0;
    }

    /**
     * Accessor for a formatted currency display.
     */
    public function getFormattedTotalAttribute()
    {
        return number_format($this->net_total, 2).' '.strtoupper($this->currency);
    }
        public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }
}
