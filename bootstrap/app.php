<?php

use App\Http\Middleware\AdminGuard;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\UserGuard;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);




        // admin guard
        $middleware->alias([
            'adminGuard' => AdminGuard::class,
            'userGuard' => UserGuard::class,
        ]);

        
      
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();