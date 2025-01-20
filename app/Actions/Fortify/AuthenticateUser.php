<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;

class AuthenticateUser
{
    public function authenticate($request)
    {
        // Attempt to find the admin user by username, email, or phone
        $username = $request->post(config('fortify.username'));
        $admin = \App\Models\Admin::where('username', '=', $username)
            ->orWhere('email', '=', $username)
            ->orWhere('phone', '=', $username)
            ->first();

        // If admin is found and the password is valid
        if ($admin && Hash::check($request->post('password'), $admin->password)) {
            // Manually log in the admin user
            return $admin;
        }

        // If authentication fails, return false
        return false;
    }
}
