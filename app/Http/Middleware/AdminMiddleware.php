<?php
// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        // Cek apakah user adalah admin atau super_admin
        if (!in_array($user->role, ['admin', 'super_admin'])) {
            // Jika user adalah guru, redirect ke dashboard guru
            if ($user->role === 'guru') {
                return redirect()->route('guru.dashboard');
            }
            
            // Jika user adalah kepala sekolah atau operator
            if (in_array($user->role, ['kepala_sekolah', 'operator'])) {
                return redirect()->route('dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman admin.');
            }
            
            // Jika role tidak dikenali, redirect ke home
            return redirect()->route('home')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        return $next($request);
    }
}