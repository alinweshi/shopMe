<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'discount_type', 'discount_value', 'expires_at', 'is_active'];
    protected $casts = [
        'is_active' => 'boolean',
    ];
    protected $dates = ['expires_at'];

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('amount', 'discount');
    }

}
