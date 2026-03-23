<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Redirect users to their specific dashboard based on their role.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $dashboardRoute = match ($user->role) {
            'admin' => 'admin.dashboard',
            'operator' => 'operator.dashboard',
            'guru' => 'guru.dashboard',
            'kepala_sekolah' => 'kepala-sekolah.dashboard',
            default => null,
        };

        if (!$dashboardRoute) {
            return redirect()->route('home')
                ->with('error', 'Dashboard untuk role Anda belum tersedia.');
        }

        return redirect()->route($dashboardRoute);
    }
}
