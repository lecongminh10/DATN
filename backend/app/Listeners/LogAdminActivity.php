<?php

namespace App\Listeners;

use App\Events\AdminActivityLogged;
use App\Models\UserActivityLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogAdminActivity
{
    public function handle(AdminActivityLogged $event)
    {
        // Ghi vào bảng user_activity_logs
        UserActivityLog::create([
            'user_id' => $event->user_id,
            'activity_type' => $event->activity_type,
            'detail' => $event->detail,
        ]);
    }
}
