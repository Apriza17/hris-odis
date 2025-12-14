<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah role user yang login ada di dalam daftar role yang diizinkan
        if (!in_array($request->user()->role, $roles)) {
            // Kalau tidak cocok, lempar error 403 (Forbidden)
            abort(403, 'Akses Ditolak! Anda bukan Admin.');
        }

        return $next($request);
    }
}
