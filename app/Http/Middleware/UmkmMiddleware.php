<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UmkmMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('umkm')->check()) {
            return redirect()->route('umkm.login');
        }

        if (Auth::guard('umkm')->user()->role !== 'umkm') {
            abort(403);
        }

        if (Auth::guard('umkm')->user()->status !== 'active') {
            Auth::guard('umkm')->logout();
            return redirect()->route('umkm.login')
                ->withErrors(['email' => 'Akun belum aktif']);
        }

        return $next($request);
    }
}
