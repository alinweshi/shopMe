<?php

namespace App\Providers;

use App\Repositories\CartRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\CartRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Interfaces\CartServiceInterface::class,
            \App\Services\CartService::class
        );

        $this->app->bind(
            \App\Interfaces\CouponServiceInterface::class,
            \App\Services\CouponService::class
        );
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
