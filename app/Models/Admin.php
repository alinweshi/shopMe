<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;
    protected $fillable = ['first_name', 'last_name', 'username', 'email', 'password', 'phone', 'image', 'status', 'is_super', 'token_version', 'role_id'];
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
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        // Include token version in JWT claims
        return [
            'token_version' => $this->token_version
        ];
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function hasPermission(string $permissionName): bool
    {
        return $this->role->permissions->contains('name', $permissionName);
    }
}
