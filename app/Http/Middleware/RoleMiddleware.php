<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // Check if user has required role
        switch ($role) {
            case 'admin':
                if ($userRole !== 'admin') {
                    abort(403, 'Access denied. Admin privileges required.');
                }
                break;
            
            case 'kepala-sekolah':
                if (!in_array($userRole, ['admin', 'kepala_sekolah'])) {
                    abort(403, 'Access denied. Kepala Sekolah privileges required.');
                }
                break;
            
            case 'guru':
                if (!in_array($userRole, ['admin', 'guru'])) {
                    abort(403, 'Access denied. Guru privileges required.');
                }
                break;
            
            case 'operator':
                if (!in_array($userRole, ['admin', 'operator'])) {
                    abort(403, 'Access denied. Operator privileges required.');
                }
                break;
            
            default:
                abort(403, 'Access denied. Invalid role specified.');
        }

        return $next($request);
    }
}
