<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeModuleAction
{
    public function handle(Request $request, Closure $next, string $module, string $action): Response
    {
        $user = $request->user();

        if (!$user || !$user->canAccessModule($module, $action)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
