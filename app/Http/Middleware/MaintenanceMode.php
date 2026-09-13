<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class MaintenanceMode
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        if (setting('maintenance_mode', '0') === '1') {
            return response()->view(
                'frontend.pages.maintenance.index',
                status: 503
            );
        }

        return $next($request);
    }
}
