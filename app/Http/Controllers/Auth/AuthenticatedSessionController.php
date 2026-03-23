<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        if (Auth::guard('siswa')->check()) {
            return redirect()->route('siswa.dashboard');
        }

        if (Auth::guard('web')->check()) {
            $dashboardRoute = match (Auth::guard('web')->user()->role) {
                'admin' => 'admin.dashboard',
                'operator' => 'operator.dashboard',
                'guru' => 'guru.dashboard',
                'kepala_sekolah' => 'kepala-sekolah.dashboard',
                default => 'dashboard',
            };

            return redirect()->route($dashboardRoute);
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if (Auth::user()) {
            Auth::user()->forceFill([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ])->save();
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'login',
            'description' => 'Login ke sistem',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Redirect berdasarkan role user
        $user = Auth::user();
        $dashboardRoute = match ($user->role) {
            'admin' => 'admin.dashboard',
            'operator' => 'operator.dashboard',
            'guru' => 'guru.dashboard',
            'kepala_sekolah' => 'kepala-sekolah.dashboard',
            default => 'dashboard',
        };

        return redirect()->intended(route($dashboardRoute, absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $userId = Auth::id();
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($userId) {
            ActivityLog::create([
                'user_id' => $userId,
                'action' => 'logout',
                'description' => 'Logout dari sistem',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return redirect('/');
    }
}
