<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{

    use HasFactory;

    protected $primaryKey = 'orderNumber'; // Specify the primary key
    public $incrementing = false; // Since orderNumber is not auto-incrementing

    protected $fillable = [
        'orderNumber',
        'orderDate',
        'requiredDate',
        'shippedDate',
        'status',
        'comments',
        'customerNumber',
    ];

    // Define relationships if needed

}
