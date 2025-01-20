<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = [
        'name',
        'cost',
        'delivery_time',
        'description',
        'is_active',
        'image',
        'slug',
        'is_default',
        'is_free',
        'is_pickup',

    ];

    /**
     * Get the orders associated with the shipping method.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
