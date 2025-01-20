<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'total_price',
        'transaction_id',
        'transaction_status',
    ];

    public function transaction()
    {
        return $this->morphMany(Transaction::class, 'transactionAble_id');
    }
}
