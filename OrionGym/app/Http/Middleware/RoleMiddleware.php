<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        foreach ($roles as $role) {
            if ($request->user() && $request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }
}
