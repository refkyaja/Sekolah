<?php
// app/Models/ActivityLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
        'user_agent',
        'device',
        'browser',
        'platform',
        'location',
        'old_data',
        'new_data',
        'status'
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function getActionBadgeAttribute()
    {
        return match($this->action) {
            'login' => 'bg-green-100 text-green-800',
            'logout' => 'bg-gray-100 text-gray-800',
            'update_profile' => 'bg-blue-100 text-blue-800',
            'change_password' => 'bg-yellow-100 text-yellow-800',
            'update_photo' => 'bg-purple-100 text-purple-800',
            default => 'bg-indigo-100 text-indigo-800',
        };
    }

    public function getActionIconAttribute()
    {
        return match($this->action) {
            'login' => 'fa-sign-in-alt',
            'logout' => 'fa-sign-out-alt',
            'update_profile' => 'fa-user-edit',
            'change_password' => 'fa-key',
            'update_photo' => 'fa-camera',
            default => 'fa-history',
        };
    }
}