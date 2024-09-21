<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transactionAble_id',
        'transactionAble_type',
        'invoice_number',
        'status',
        'total',
        'tax',
        'currency',
        'billed_at',
    ];

    // Optionally, you can define relationships if there are any
    // For example, if a transaction belongs to a user or an order:
    public function billable()
    {
        return $this->morphTo(); //user+order+product
    }
}
