<?php

namespace App\Http\Controllers\Concerns;

trait AuthorizesModuleAccess
{
    protected function authorizeModule(string $module, string $action): void
    {
        $user = auth()->user();

        abort_unless(
            $user && $user->canAccessModule($module, $action),
            403,
            'Akses ditolak.'
        );
    }
}
