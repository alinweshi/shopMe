<?php

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    RouteServiceProvider::class,
    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    Barryvdh\Debugbar\ServiceProvider::class,
];
