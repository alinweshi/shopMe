<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AdminPasswordConfirm;
use App\Http\Controllers\Backend\AdminProfileController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController;

Route::prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        // if (!auth()->guard('admin')->check()) {
        //     return redirect()->route(route: 'admin.login'); // Use named route for redirection
        // }

        return view('dashboard');
    })->name('admin.dashboard')->middleware(AdminMiddleware::class);

    // Admin login routes
    Route::get(uri: '/login', action: [AuthenticatedSessionController::class, 'create'])
        ->name(name: 'admin.login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('admin.login.post');

    // Password reset routes
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('admin.password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('admin.password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('admin.password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('admin.password.update');

    // Email verification routes (if applicable)
    Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
        ->name('admin.verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->name('admin.verification.verify');

    // Two-factor authentication routes (if applicable)
    Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])
        ->name('admin.two-factor.login');
    Route::post('/two-factor-challenge', action: [TwoFactorAuthenticatedSessionController::class, 'store'])
        ->name('admin.two-factor.store');
    Route::post('/logout', function () {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    })->name('admin.logout')->middleware('auth:admin');
    Route::post('two-factor-authentication', action: [TwoFactorAuthenticationController::class, 'store'])->middleware(middleware: ['auth:admin'])->name('admin.two-factor.enable');
    Route::delete('two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])->middleware(middleware: [AdminPasswordConfirm::class, 'auth:admin'])->name('admin.two-factor.disable');

    Route::get("profile", [AdminProfileController::class, 'viewProfile'])->middleware(AdminMiddleware::class)->name('admin.profile');
    Route::get('confirm-password', action: [ConfirmablePasswordController::class, 'show'])->middleware(middleware: ['auth:admin'])->name('admin.password.confirm');
    Route::post('confirm-password', action: [ConfirmablePasswordController::class, 'store'])->middleware(middleware: 'auth:admin');
    Route::post("confirmed-two-factor-authentication", action: [ConfirmedTwoFactorAuthenticationController::class, 'store'])->middleware(middleware: 'auth:admin')->name('admin.two-factor.confirm');
    // Other routes...
});
