<?php

namespace App\Providers;

use App\Actions\Fortify\AuthenticateUser;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Config;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        if (request()->is('admin/*')) {
            \Log::info('Admin route accessed: ' . request()->fullUrl());
            Config::set('fortify.prefix', 'admin');
            Config::set('fortify.guard', 'admin');
            Config::set('fortify.passwords', 'admins');

        };
        // Custom LogoutResponse based on guard
        $this->app->instance(LogoutResponse::class, new class () implements LogoutResponse {
            public function toResponse($request)
            {
                // Check the guard and redirect accordingly
                if (Auth::guard('admin')->check()) {
                    return redirect('/admin/login');
                }
                // Default redirect for non-admins
                return redirect('/');
            }
        });

        // Custom LoginResponse based on guard
        $this->app->instance(LoginResponse::class, new class () implements LoginResponse {
            public function toResponse($request)
            {
                // Check the guard and redirect accordingly
                if (Auth::guard('admin')->check()) {
                    return redirect('/admin/dashboard');
                }
                // Default redirect for non-admin users
                return redirect('/home');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(callback: UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password');
        });
        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge');
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        Fortify::viewPrefix('auth.');
        // Fortify::confirmPasswordView('auth.passwords.confirm-password');
        // Fortify::           ('auth.forgot-password');
        // Fortify::loginView('auth.login');
        // Fortify::registerView('auth.register');
        // Fortify::resetPasswordView('auth.passwords.reset');
        // Fortify::requestPasswordResetLinkView('auth.passwords.email');
        // Fortify::verifyEmailView('auth.verify-email');
        // // Fortify::twoFactorChallengeView('auth.two-factor-challenge');
        if (request()->is('admin/*')) {
            // Set guard and prefix for admin routes
            Config::set('fortify.prefix', 'admin');
            Config::set(key: 'fortify.guard', value: 'admin');
            Config::set('fortify.passwords', 'admins');
            Config::set('fortify.limiters.login', 'admin/login');
            Config::set(key: 'fortify.home', value: 'admin/dashboard');
            Fortify::viewPrefix('backend.admin.auth.');
            Fortify::authenticateUsing(callback: [new AuthenticateUser(), 'authenticate']);
            Fortify::confirmPasswordView(function () {
                return view('backend.admin.auth.confirm-password');
            });
            Fortify::twoFactorChallengeView(function () {
                return view('auth.two-factor-challenge');
            });

            Fortify::confirmsTwoFactorAuthentication();
            Config::set('fortify.features.Features::twoFactorAuthentication', [
                'confirm' => true,
                'confirmPassword' => true,
                // 'window' => 0,
            ]);

            // Define views specifically for admin authentication
            // Fortify::loginView(fn() => view('auth.admin.login'));
            // Fortify::registerView(fn() => view('auth.admin.register'));
            // Fortify::resetPasswordView(fn() => view('auth.admin.passwords.reset'));
            // Fortify::requestPasswordResetLinkView(fn() => view('auth.admin.passwords.email'));
            // Fortify::verifyEmailView(fn() => view('auth.admin.verify-email'));
            // Fortify::twoFactorChallengeView(fn() => view('auth.admin.two-factor-challenge'));
        }
    }
}
