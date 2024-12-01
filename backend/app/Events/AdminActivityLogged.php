<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminActivityLogged
{
    use SerializesModels;

    public $user_id;
    public $activity_type;
    public $detail;

    public function __construct($user_id, $activity_type, $detail)
    {
        $this->user_id = $user_id;
        $this->activity_type = $activity_type;
        $this->detail = $detail;
    }
}
