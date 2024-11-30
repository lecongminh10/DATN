<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $idroms;
    public $user;
    public $receiver;
    public $message;

    public function __construct($idroms,$user, $receiver, $message)
    {
        $this->idroms = $idroms;
        $this->user = $user;
        $this->receiver = $receiver;
        $this->message = $message;

        Log::info('Người chat: ' . $user->name);
        Log::info('người nhận: ' . $receiver->name);
        Log::info('nội dung: ' . $message);
    }

    public function broadcastOn()
    {
        
        return new PrivateChannel('chat.' . $this->idroms);
    }

    public function broadcastWith()
    {
        Log::info('Broadcast data:', [
            'user' => $this->user,
            'receiver' => $this->receiver,
            'message' => $this->message,
        ]);
        return [
            'user' => $this->user,
            'receiver'=>$this->receiver,
            'message' => $this->message,
        ];
    }
}