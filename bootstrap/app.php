<?php

use App\Http\Middleware\PermissionMiddleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(
    basePath: dirname(__DIR__)
)
    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    */

    ->withRouting(

        web: __DIR__ . '/../routes/web.php',

        commands: __DIR__ . '/../routes/console.php',

        health: '/up',

    )
    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    */

    ->withMiddleware(function (Middleware $middleware): void {

        /*
        |--------------------------------------------------------------------------
        | Custom Middleware Aliases
        |--------------------------------------------------------------------------
        */

        $middleware->alias([

            /*
            |--------------------------------------------------------------------------
            | Existing Role Middleware
            |--------------------------------------------------------------------------
            */

            'role' => RoleMiddleware::class,


            /*
            |--------------------------------------------------------------------------
            | Custom Permission Middleware
            |--------------------------------------------------------------------------
            */

            'permission' => PermissionMiddleware::class,

        ]);

    })
    /*
    |--------------------------------------------------------------------------
    | Exceptions
    |--------------------------------------------------------------------------
    */

    ->withExceptions(function (Exceptions $exceptions): void {

        //

    })
    /*
    |--------------------------------------------------------------------------
    | Create Application
    |--------------------------------------------------------------------------
    */

    ->create();
