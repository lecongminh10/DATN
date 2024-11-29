<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatMessage extends Model
{
    use HasFactory;
    protected $table = 'chat_messages';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'room_id',
        'message',
        'media_type',
        'media_path',
        'read_at',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public static function getChatMessages($roomId)
    {
        $currentUserId = Auth::id();

        $chatMessages = ChatMessage::where('room_id', $roomId)
            ->where(function ($query) use ($currentUserId) {
                $query->where('sender_id', $currentUserId)
                    ->orWhere('receiver_id', $currentUserId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return $chatMessages;
    }


    public static function getChatMessageClient()
    {
        $userId = Auth::id();
        $chatMessages = ChatMessage::where(function ($query) use ($userId,) {
            $query->where('room_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return $chatMessages;
    }
}
