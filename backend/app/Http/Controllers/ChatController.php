<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\TestEvent;
use App\Events\MessageSent;
use App\Models\ChatMessage;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Events\NotificationMessage;
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
        $users = $this->userService->getAllClient([User::TYPE_CLIENT])->get();
        $subAdminOrAdmin = $this->userService->getAllClient([User::TYPE_SUBADMIN ,User::TYPE_ADMIN])->get();
        return view('admin.chat', compact('users','subAdminOrAdmin'));
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

        if($sender->isAdmin() && $receiver->isAdmin()){
            $roomId = $sender->id > $receiver->id 
            ? $sender->id * 100000 + $receiver->id 
            : $receiver->id * 100000 + $sender->id;
        }

        if (!$sender->isAdmin() && !$receiver->isAdmin()) {
            $admin = $this->userService->getAllClient([User::TYPE_SUBADMIN ,User::TYPE_ADMIN])->first();
            if ($admin) {
                $receiver = $admin;
                $roomId = $sender->id;
            }
        }
        Log::info('roomId: ' . $roomId);
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
        broadcast(new NotificationMessage($roomId, $sender, $receiver, $chatMessage->message));
        return response()->json([
            'status' => 'Message sent successfully',
            'message' => $chatMessage->message,
            'media_path' => $mediaPath ? asset("storage/{$mediaPath}") : null,
            'roomId' =>$chatMessage->room_id
        ]);
    }

    public function getDataChatAdmin(Request $request)
    {
        $sender = auth()->user();
        $receiver = User::find($request->userId);
    
        if (!$receiver) {
            return response()->json(['status' => 'Receiver not found'], 404);
        }
        if ($sender->isAdmin() && $receiver->isAdmin()) {
            $roomId = $sender->id > $receiver->id
                      ? $sender->id * 100000 + $receiver->id
                      : $receiver->id * 100000 + $sender->id;
        } else {
            $roomId = $sender->isAdmin() ? $receiver->id : $sender->id;
        }
        $data = ChatMessage::getChatMessages($roomId);
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

    /**
     * API để tính toán roomId giữa người đăng nhập và người khác.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoomId(Request $request)
    {
        $loggedInUser = auth()->user(); // Người đang đăng nhập
        $otherUser = User::find($request->user_id); // Người khác từ request

        if (!$otherUser) {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }

        // Kiểm tra quyền admin của người dùng
        $isLoggedInUserAdmin = $loggedInUser->isAdmin(); // Hàm isAdmin() bạn cần định nghĩa
        $isOtherUserAdmin = $otherUser->isAdmin(); // Hàm isAdmin() bạn cần định nghĩa

        // Tính toán roomId
        $roomId = $this->calculateRoomId(
            $loggedInUser->id,
            $otherUser->id,
            $isLoggedInUserAdmin,
            $isOtherUserAdmin
        );

        return response()->json([
            'status' => 'success',
            'roomId' => $roomId,
        ]);
    }

    /**
     * Tính toán Room ID dựa trên ID của người dùng.
     *
     * @param int $loggedInUserId
     * @param int $otherUserId
     * @param bool $isLoggedInUserAdmin
     * @param bool $isOtherUserAdmin
     * @return int
     */
    private function calculateRoomId(int $loggedInUserId, int $otherUserId, bool $isLoggedInUserAdmin, bool $isOtherUserAdmin): int
    {
        if ($isLoggedInUserAdmin && $isOtherUserAdmin) {
            return $loggedInUserId > $otherUserId
                ? $loggedInUserId * 100000 + $otherUserId
                : $otherUserId * 100000 + $loggedInUserId;
        }

        return $isLoggedInUserAdmin ? $otherUserId : $loggedInUserId;
    }

    public function deleteChatMessageById(Request $request)
    {

        $id = $request->input('id');
        $respone = ChatMessage::deleteChatMessageById($id);
        if($respone){
            return redirect()->back()->with(['message'=>'Đã xóa thành công' , 'status'=>true]);
        }
        return redirect()->back()->with(['message'=>'Đã xóa có lỗi' , 'status'=>true]);
    }
}
