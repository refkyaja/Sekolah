<?php
// app/Http/Middleware/LogUserActivity.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Log activity untuk user yang login
        if (Auth::check()) {
            $user = Auth::user();
            
            // Log halaman yang dikunjungi (opsional)
            if ($request->method() == 'GET' && !$request->ajax()) {
                $user->logActivity(
                    'page_view',
                    'Melihat halaman: ' . $request->path()
                );
            }
        }

        return $response;
    }
}