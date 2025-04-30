<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class Vendor extends User
{
    use HasFactory;
    use Notifiable;

    protected $fillable = ['first_name', 'last_name', 'username', 'email', 'password', 'phone', 'image', 'status'];

    /**
     * Get the products associated with the vendor.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
