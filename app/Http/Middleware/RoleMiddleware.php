<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        // CEK ADMIN
        if ($role === 'admin') {
            if (!Auth::guard('admin')->check()) {
                return redirect()->route('admin.login');
            }

            if (Auth::guard('admin')->user()->role !== 'admin') {
                abort(403);
            }
        }

        // CEK UMKM
        if ($role === 'umkm') {
            if (!Auth::guard('umkm')->check()) {
                return redirect()->route('umkm.login');
            }

            if (Auth::guard('umkm')->user()->role !== 'umkm') {
                abort(403);
            }
        }

        return $next($request);
    }
}