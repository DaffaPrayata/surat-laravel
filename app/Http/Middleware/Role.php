<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class Role
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        // 🔥 cek login dulu
        if (!$user) {
            abort(ResponseCode::HTTP_FORBIDDEN, 'Unauthorized');
        }

        // 🔥 cek role
        if (!in_array($user->role, $roles)) {
            abort(ResponseCode::HTTP_FORBIDDEN, 'Akses ditolak');
        }

        return $next($request);
    }
}