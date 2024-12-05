<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserOnline implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets,SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new Channel('usersonline');
    }

    public function broadcastWith()
    {
        return [
            'user' => $this->user,
        ];
    }
}
