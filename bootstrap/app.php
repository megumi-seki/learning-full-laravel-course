<?php

use App\Http\Middleware\EnsureTodayIsWeekend;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->append(EnsureTodayIsWeekend::class);

        // web, api
        // $middleware->appendToGroup("test", [

        // ]);
        // $middleware->web(remove: []);
        $middleware->alias([
            "weekend" => EnsureTodayIsWeekend::class
        ]);
        // $middleware->validateCsrfTokens([
        //     "strip/*",
        //     "car"
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
