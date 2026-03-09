<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\GuruMiddleware;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\SetNgrokHeaders;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Hanya untuk route yang butuh auth
        $middleware->alias([
            'active' => EnsureUserIsActive::class,
            'admin' => AdminMiddleware::class,
            'guru' => GuruMiddleware::class,
            'operator' => CheckRole::class . ':operator',
            'ngrok' => SetNgrokHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //o
    })->create();