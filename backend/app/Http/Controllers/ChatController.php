<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\TestEvent;
use App\Events\MessageSent;
use App\Models\ChatMessage;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllClient(User::TYPE_CLIENT)->get();
        return view('admin.chat', compact('users'));
    }

    public function sendMessage(Request $request)
    {
        Log::info('data', $request->all());
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,id',
        ]);

        $sender = auth()->user();
        $receiver = User::find($request->receiver_id);

        if (!$receiver) {
            return response()->json(['status' => 'Receiver not found'], 404);
        }

        $roomId = $sender->isAdmin() ? $receiver->id : $sender->id;

        if (!$sender->isAdmin() && !$receiver->isAdmin()) {
            $admin = $this->userService->getAllClient(User::TYPE_ADMIN)->first();
            if ($admin) {
                $receiver = $admin;
                $roomId = $sender->id;
            }
        }
        $mediaPath = null;
        $mediaType = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $timestamp = now()->format('Ymd_His');
            $extension = $file->getClientOriginalExtension();
            $fileName = "{$timestamp}.{$extension}";

            $mediaPath = $file->storeAs('messages', $fileName, 'public'); 
            $mediaType = $file->getMimeType();
        }

        // Save message in database
        $chatMessage = ChatMessage::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'room_id' => $roomId,
            'message' => $request->message ?? '', 
            'media_type' => $mediaType,
            'media_path' => $mediaPath,
        ]);

        // Broadcast event
        broadcast(new MessageSent($roomId, $sender, $receiver, $chatMessage->message ,$mediaPath));

        return response()->json([
            'status' => 'Message sent successfully',
            'message' => $chatMessage->message,
            'media_path' => $mediaPath ? asset("storage/{$mediaPath}") : null,
        ]);
    }

    public function getDataChatAdmin(Request $request)
    {
        Log::info('requets data', $request->all());
        $data = ChatMessage::getChatMessages($request->userId);
        return response()->json(['data', $data]);
    }

    public function getDataChatClient()
    {
        $data = ChatMessage::getChatMessageClient();
        if ($data == null) {
            return response()->json(['status' => false]);
        }
        return response()->json(['data' => $data, 'status' => true]);
    }
}
