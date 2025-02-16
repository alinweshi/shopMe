<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Policies\CartPolicy;
use App\Policies\ProductPolicy;
use App\Services\MyFatoorahService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\AliasLoader;
use App\Repositories\PaymentRepository;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
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
        $this->app->bind(PaymentRepository::class, function () {
            return new PaymentRepository();
        });
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
        // Product::preventLazyLoading(!$this->app->isProduction);
        Gate::policy(Cart::class, CartPolicy::class);
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::define('update-product', function (User $user, Product $post) {
            return $user->id === $post->user_id;
        });
        Gate::define('edit-settings', function (User $user) {
            return $user->isAdmin
                ? Response::allow()
                : Response::deny('You must be an administrator.');
        });
    }
}
