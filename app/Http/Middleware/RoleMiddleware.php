<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Pastikan user sudah login, jika belum arahkan ke halaman login
        if (!auth()->check()) {
            return redirect('login');
        }

        // 2. Jika rolenya adalah 'admin', berikan Full Access (selalu lolos)
        if (auth()->user()->role === 'admin') {
            return $next($request);
        }

        // 3. Cek apakah role user saat ini ada di dalam daftar yang diizinkan
        if (in_array(auth()->user()->role, $roles)) {
            return $next($request);
        }

        // Jika tidak diizinkan, kunci halaman dan tampilkan error 403
        abort(403, 'Akses Ditolak: Anda tidak memiliki hak akses ke halaman ini.');
    }
}