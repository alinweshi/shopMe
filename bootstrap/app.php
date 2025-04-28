<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Application;
use App\Http\Middleware\AdminMiddleware;
use App\Exceptions\CartNotFoundException;
use App\Exceptions\ProductNotFoundException;
use App\Http\Middleware\AdminPasswordConfirm;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Facade;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        channels: __DIR__ . '/../routes/channels.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(callback: function (Middleware $middleware) {
        $middleware->api([
            // \Laravel\Telescope\Http\Middleware\Authorize::class

        ]);
        $middleware->web([
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

        ])->alias(
            [
                'admin.password.confirm' => AdminPasswordConfirm::class,
                'admin.auth' => AdminMiddleware::class,
                Facade::defaultAliases()->merge([
                    'Redis' => Illuminate\Support\Facades\Redis::class,
                ])->toArray(),
            ]
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Reporting the exception (log only)
        // $exceptions->report(function (ProductNotFoundException $exception) {
        //     Log::error('Product not found', ['error' => $exception->getMessage()]);
        // });

        // Handling the response when the exception occurs
        $exceptions->render(function (\App\Exceptions\ProductNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        });
        $exceptions->render(function (\App\Exceptions\AuthorizationException $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        });

        // $exceptions->report(function (CartNotFoundException $exception) {
        //     Log::error('Cart not found', ['error' => $exception->getMessage()]);
        // });

        $exceptions->render(function (CartNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        });
    })->create();
// if (env('APP_DEBUG')) {
//     $app->register(Barryvdh\Debugbar\LumenServiceProvider::class);
// }
