<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Agent\Agent;

trait LogsActivity
{
    public function logActivity($action, $description = null, $oldData = null, $newData = null, $status = 'success')
    {
        if (!Schema::hasTable('activity_logs')) {
            return;
        }

        $agent = new Agent();
        
        // Deteksi device
        if ($agent->isMobile()) {
            $device = 'Mobile';
        } elseif ($agent->isTablet()) {
            $device = 'Tablet';
        } else {
            $device = 'Desktop';
        }
        
        // Deteksi browser
        $browser = $agent->browser();
        $platform = $agent->platform();
        
        // Dapatkan IP
        $ip = Request::header('CF-Connecting-IP') ?? 
              Request::header('X-Forwarded-For') ?? 
              Request::ip();
        
        // Bersihkan data dari quotes
        if (is_string($oldData)) {
            $oldData = json_decode($oldData, true);
        }
        if (is_string($newData)) {
            $newData = json_decode($newData, true);
        }
        
        try {
            ActivityLog::create([
                'user_id' => $this->id,
                'action' => $action,
                'description' => $description,
                'ip_address' => $ip,
                'user_agent' => Request::userAgent(),
                'device' => $device,
                'browser' => $browser,
                'platform' => $platform,
                'old_data' => $oldData ? json_encode($oldData) : null,
                'new_data' => $newData ? json_encode($newData) : null,
                'status' => $status,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log activity: ' . $e->getMessage());
        }
    }

    public function activities()
    {
        return $this->hasMany(ActivityLog::class)->latest();
    }
}