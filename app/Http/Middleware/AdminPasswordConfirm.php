<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AdminPasswordConfirm
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        // Check if admin is authenticated
        if (!Auth::guard(name: 'admin')->check()) {
            return redirect()->route('admin.login'); // Ensure it redirects to admin login
        }

        // Check if password confirmation has been done recently
        if ($request->session()->has('auth.admin_password_confirmed_at') &&
            time() - $request->session()->get('auth.admin_password_confirmed_at') < config('auth.password_timeout', 900)) {
            return $next($request);
        }

        // If not, redirect to the admin password confirm page
        return redirect()->route('admin.password.confirm');
    }
}
