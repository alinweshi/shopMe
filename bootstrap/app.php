<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\AdminMiddleware;
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

    })->create();
if (env('APP_DEBUG')) {
    $app->register(Barryvdh\Debugbar\LumenServiceProvider::class);
}
