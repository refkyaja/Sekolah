<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Check untuk Admin, Guru, Operator, Kepsek (guard 'web')
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->is_active == false) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Akun Anda sedang dinonaktifkan. Silakan hubungi administrator.');
        }

        // 2. Check untuk Siswa (guard 'siswa')
        if (Auth::guard('siswa')->check() && Auth::guard('siswa')->user()->is_active == false) {
            Auth::guard('siswa')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('siswa.login')
                ->withErrors(['email' => 'Akun Anda telah dinonaktifkan oleh administrator.']);
        }

        return $next($request);
    }
}
