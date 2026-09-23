<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (Auth::user()->role !== $role) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('dashboard');
            }
            return redirect()->route('user.katalog')->with('error', 'Akses ditolak. Halaman khusus Admin.');
        }

        return $next($request);
    }
}
