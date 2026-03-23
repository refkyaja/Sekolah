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
            abort(403, 'Access denied. Guru privileges required.');
        }
        
        return $next($request);
    }
}