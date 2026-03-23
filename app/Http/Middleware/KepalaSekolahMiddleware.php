<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KepalaSekolahMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        // Cek apakah user adalah kepala sekolah
        if ($user->role !== 'kepala_sekolah') {
            abort(403, 'Access denied. Kepala Sekolah privileges required.');
        }
        
        return $next($request);
    }
}
