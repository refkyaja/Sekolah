<?php
// app/Http/Middleware/GuruMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Cek apakah user adalah guru
        if (Auth::user()->role !== 'guru') {
            // Jika user adalah admin, redirect ke dashboard admin
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            // Jika role tidak dikenali, redirect ke home
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman guru.');
        }
        
        return $next($request);
    }
}