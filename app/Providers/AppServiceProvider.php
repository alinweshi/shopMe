<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Mixins\StrMixin;
use App\Mixins\ArrayMixin;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Policies\CartPolicy;
use Illuminate\Http\Request;
use App\Macros\BuilderMacros;
use App\Policies\ProductPolicy;
use App\Macros\CollectionMacros;
use App\Services\MyFatoorahService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\AliasLoader;
use App\Repositories\PaymentRepository;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Interfaces\Payments\PaymentServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        };


        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $this->app->bind(PaymentRepository::class, function () {
            return new PaymentRepository();
        });
        $this->app->bind(PaymentServiceInterface::class, MyFatoorahService::class);
        // Register the macro using a callable
        Collection::macro('toUpper', (new CollectionMacros)->toUpper());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Builder::macro('findOrFalse', (new BuilderMacros)->findOrFalse());
        // Builder::macro('findOrFalse', function ($id, $columns = ['*']) {
        //     return  $this->find($id, $columns) ?? false;
        // });
        Str::mixin(new StrMixin);
        Arr::mixin(new ArrayMixin);
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
        $this->configureRateLimiting();
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('global', function ($request) {
            return Limit::perMinute(3)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(3)->by($request->user()?->id ?: $request->ip())
                ->response(function (Request $request, array $headers) {
                    return response('This will be handy for Rate limiters on API routes', 429, $headers);
                });
        });
    }
}
