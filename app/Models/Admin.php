<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Laravel\Fortify\TwoFactorAuthenticatable;

class Admin extends User
{
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;
    protected $fillable = ['first_name', 'last_name', 'username', 'email', 'password', 'phone', 'image', 'status', 'is_super'];
    public function hasConfirmedPassword()
    {
        // Logic to check if the admin has confirmed their password
        // For example, this could check a session variable or other logic
        return session('password_confirmed', false); // Adjust based on your logic
    }
    public function confirmTwoFactorAuth($code)
    {
        $codeIsValid = app(TwoFactorAuthenticationProvider::class)
            ->verify(decrypt($this->two_factor_secret), $code);

        if ($codeIsValid) {
            $this->two_factor_confirmed = true;
            $this->save();

            return true;
        }

        return false;
    }
}
