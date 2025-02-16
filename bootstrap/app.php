<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Application;
use App\Http\Middleware\AdminMiddleware;
use App\Exceptions\CartNotFoundException;
use App\Exceptions\ProductNotFoundException;
use App\Http\Middleware\AdminPasswordConfirm;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(callback: function (Middleware $middleware) {
        $middleware->web([
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

        ])->alias(
            [
                'admin.password.confirm' => AdminPasswordConfirm::class,
                'admin.auth' => AdminMiddleware::class,
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
if (env('APP_DEBUG')) {
    $app->register(Barryvdh\Debugbar\LumenServiceProvider::class);
}
