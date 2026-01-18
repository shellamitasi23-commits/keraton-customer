<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah ada user di guard admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')
                ->withErrors(['error' => 'Silakan login sebagai admin terlebih dahulu.']);
        }

        $user = Auth::guard('admin')->user();

        // Validasi role
        if ($user->role !== 'admin') {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')
                ->withErrors(['error' => 'Anda tidak memiliki akses admin.']);
        }

        return $next($request);
    }
}