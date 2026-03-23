<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        // Cek apakah user adalah operator
        if ($user->role !== 'operator') {
            abort(403, 'Access denied. Operator privileges required.');
        }
        
        return $next($request);
    }
}
