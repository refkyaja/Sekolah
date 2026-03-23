<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use App\Models\Siswa;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/**
 * Channel notifikasi private per user (admin/guru/operator/kepala_sekolah).
 * Staff login via default 'web' guard.
 */
Broadcast::channel('notifications.{userId}', function ($user, $userId) {
    // Auth via guard 'web' (User model)
    if ($user instanceof User) {
        return (int) $user->id === (int) $userId;
    }
    // Auth via guard 'siswa' (Siswa model)
    if ($user instanceof Siswa) {
        return (int) $user->id === (int) $userId;
    }
    return false;
}, ['guards' => ['web', 'siswa']]);
