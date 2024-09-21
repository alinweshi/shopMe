<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class Admin extends User
{
    use HasFactory, Notifiable;
    protected $fillable = ['first_name', 'last_name', 'username', 'email', 'password', 'phone', 'image', 'status', 'is_super'];
}
