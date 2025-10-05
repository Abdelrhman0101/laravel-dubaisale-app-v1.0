<?php

use App\Http\Middleware\EnsureUserIsVerified;
// use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\SecureEndpoint;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->alias([
            'SecureEndpoint' => \App\Http\Middleware\SecureEndpoint::class,
            'EnsureUserIsVerified' => \App\Http\Middleware\EnsureUserIsVerified::class,
            'EnsureUserIsAdvertiser' => \App\Http\Middleware\EnsureUserIsAdvertiser::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
