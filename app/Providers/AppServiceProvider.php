<?php

namespace App\Providers;

use App\Models\User;
use App\Services\MyFatoorahService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Interfaces\Payments\PaymentServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
        $this->app->bind(PaymentServiceInterface::class, MyFatoorahService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return 'http://localhost:8080/reset-password?token=' . $token . "&email=" . $user->email;
        });
    }
}
