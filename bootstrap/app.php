<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AdminMiddlewareRedirect;
use App\Http\Middleware\Customer\CustomerMiddleware;
use App\Http\Middleware\Customer\CustomerRedirect;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Router;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        function(Router $router) {
            $router->middleware('web')->group(base_path('routes/admin.php'));
            $router->middleware('web')->group(base_path('routes/front.php'));
        }
        // web: __DIR__.'/../routes/web.php',
        // commands: __DIR__.'/../routes/console.php',
        // health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'guest.admin' => AdminMiddlewareRedirect::class,
            'auth.admin' => AdminMiddleware::class,
            'guest.customer' => CustomerRedirect::class,
            'auth.customer' => CustomerMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
