<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'password', 'image'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionAble_id');
    }
    public static function search($search)
    {
        $users = User::where('first_name', 'like', value: '%' . $search . '%')
            ->orWhere('last_name', 'like', value: '%' . $search . '%')
            ->orWhere('email', 'like', value: '%' . $search . '%')
            ->orWhere('phone', 'like', value: '%' . $search . '%')
            ->orWhere('id', 'like', value: '%' . $search . '%')
            ->paginate(8);
        return $users;
    }
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
