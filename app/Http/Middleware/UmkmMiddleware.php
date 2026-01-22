<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UmkmMiddleware
{
    public function handle($request, Closure $next)
    {
        // Jika belum login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Jika bukan role umkm
        if (auth()->user()->role !== 'umkm') {
            abort(403, 'Akses khusus UMKM');
        }

        return $next($request);
    }
}
