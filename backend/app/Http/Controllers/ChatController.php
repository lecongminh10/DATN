<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Events\MessageSent;
use App\Events\UserOnline;
use App\Events\UserOffline;
use App\Services\UserService;

use function PHPUnit\Framework\returnSelf;

class ChatController extends Controller
{
    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = User::clients()->get();
        return view('admin.chat', compact('users'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,id', // Xác thực người nhận tồn tại
        ]);
        $idroms='';
        $sender = auth()->user();
        
        $receiver = User::find($request->receiver_id);

        if (!$receiver) {
            return response()->json(['status' => 'Receiver not found'], 404);
        }

        
        if ($sender->isAdmin()) {
            $idroms=$receiver->id;
        } else {
            $idroms=$sender->id;
        }

        // Phát sự kiện tin nhắn đến người nhận
        broadcast(new MessageSent($idroms,$sender, $receiver, $request->message))->toOthers();

        return response()->json(['status' => 'Message sent']);
    }

}

