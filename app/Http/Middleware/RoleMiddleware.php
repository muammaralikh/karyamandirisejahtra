<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth('web')->check()) {
            return redirect()->route('login');
        }
        $userRole = trim(strtolower(auth('web')->user()->role));
        $roles = array_map(
            fn ($role) => trim(strtolower($role)),
            $roles
        );
        if (!in_array($userRole, $roles, true)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
