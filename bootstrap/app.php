<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Yahan agar tum global / group middleware add karna chaaho to kar sakte ho

        // 👇 YAHI JAGAH sabse important hai
        $middleware->alias([
            'auth'      => \App\Http\Middleware\Authenticate::class,
            'role'      => \App\Http\Middleware\RoleMiddleware::class, // 👈 ye line zaroori
            'verified'  => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            // agar aur alias chahiye to yahan add karo
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
