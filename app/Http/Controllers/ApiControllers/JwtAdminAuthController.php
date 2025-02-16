<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\Jwt\Admins\AdminLoginRequest;


class JwtAdminAuthController extends Controller implements HasMiddleware
{
    public function __construct()
    {
        $this->middleware('auth:api-admin', ['except' => ['login', 'register']]);
    }
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware() {}
    public function register() {}
    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Retrieve the admin user by credentials
        // $admin = Auth::getProvider()->retrieveByCredentials($credentials);

        // if (!$admin) {
        //     return response()->json(['error' => 'Invalid credentials'], 401);
        // }

        // // Increment token version
        // $admin->token_version += 1;
        // $admin->save();

        // Generate token - this will include the new version in the payload
        if (!$token = auth('api-admin')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'message' => 'You are logged in',
            'token' => $token
        ], 200);
    }

    public function logout()
    {

        auth('api-admin')->logout();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
    public function refresh()
    {
        // Refresh token logic goes here
    }
    public function me()
    {
        // Get authenticated admin details
    }
    public function updatePassword()
    {
        // Update admin password
    }
    public function updateTwoFactorAuth()
    {
        // Update admin two-factor authentication settings
    }
    public function confirmTwoFactorAuth()
    {
        // Confirm admin two-factor authentication
    }
}
