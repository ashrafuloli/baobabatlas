<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next,
                ...$roles
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | Get Authenticated User
        |--------------------------------------------------------------------------
        */

        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | Check Authentication
        |--------------------------------------------------------------------------
        */

        if (! $user) {

            return redirect()
                ->route('login');
        }


        /*
        |--------------------------------------------------------------------------
        | Check Route Roles
        |--------------------------------------------------------------------------
        */

        if (empty($roles)) {

            abort(
                403,
                'No authorized roles have been configured for this route.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Normalize Roles
        |--------------------------------------------------------------------------
        |
        | Supports:
        |
        | role:admin
        | role:admin,staff
        | role:admin,staff,client
        |
        */

        $roles = collect($roles)
            ->flatMap(function ($role) {
                return explode(',', $role);
            })
            ->map(function ($role) {
                return trim($role);
            })
            ->filter()
            ->unique()
            ->values()
            ->toArray();


        /*
        |--------------------------------------------------------------------------
        | Check User Role
        |--------------------------------------------------------------------------
        |
        | User::hasRole() checks the roles table through
        | the user_roles pivot table.
        |
        */

        if (! $user->hasRole($roles)) {

            abort(
                403,
                'You are not authorized to access this page.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Continue Request
        |--------------------------------------------------------------------------
        */

        return $next($request);
    }
}
