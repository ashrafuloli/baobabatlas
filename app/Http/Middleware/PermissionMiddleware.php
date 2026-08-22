<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /*
    |--------------------------------------------------------------------------
    | Handle Request
    |--------------------------------------------------------------------------
    */

    public function handle(
        Request $request,
        Closure $next,
        string $permission
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | Authentication
        |--------------------------------------------------------------------------
        */

        if (!$request->user()) {

            abort(401);
        }


        /*
        |--------------------------------------------------------------------------
        | Admin Bypass
        |--------------------------------------------------------------------------
        |
        | Existing Admin users should continue to have full access.
        |
        */

        if ($request->user()->isAdmin()) {

            return $next($request);
        }


        /*
        |--------------------------------------------------------------------------
        | Permission Check
        |--------------------------------------------------------------------------
        |
        | User
        |   ↓
        | Roles
        |   ↓
        | Permissions
        |   ↓
        | Requested Permission
        |
        */

        if (
            !$request->user()->hasPermission($permission)
        ) {

            abort(
                403,
                'You are not authorized to access this page.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Allow Request
        |--------------------------------------------------------------------------
        */

        return $next($request);
    }
}
