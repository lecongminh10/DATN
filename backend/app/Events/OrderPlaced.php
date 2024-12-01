<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $user;
    public $message;

    public function __construct($order, $user, $message)
    {
        $this->order = $order;
        $this->user = $user;
        $this->message = $message;
        Log::info('Message Sent:', [
            'Đơn hàng ' => $order,
            'Người dùng ' => $user->username,
            'Message' => $message,
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('notification_message');
    }

    public function broadcastWith()
    {
        return [
            'order' => $this->order->code,
            'sender' => [
                'id' => $this->user->id,
                'username' => $this->user->username,
                'profile_picture' => $this->user->profile_picture
            ],
            'message' => $this->message,
        ];
    }
}
