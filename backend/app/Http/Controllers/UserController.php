<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PermissionsValueUser;
use App\Services\PermissionsValueUserService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $permissionsValueUser;
    protected $userRepository;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function index()
    {
        $users = $this->userService->getAll();
        return response()->json($users, 200);
    }

    public function store(Request $request)
    {
        $data = $request->except('id_permissions');
        $user = $this->userService->createUser($data);
        $user->permissionsValues()->attach($request->id_permissions);
        return response()->json($user, 201);
    }

    public function show($id)
    {
        // Lấy thông tin người dùng
        $user = $this->userService->getById($id);

        // Lấy quyền của người dùng
        // $permissions = $user->permissionsValues;

        // Trả về thông tin người dùng cùng với quyền
        return response()->json([
            'user' => $user,
            // 'permissions' => $permissions
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        // Cập nhật người dùng
        $user = $this->userService->updateUser($id, $data);

        // Cập nhật quyền cho người dùng
        if ($request->has('id_permissions')) {
            // Xóa quyền cũ và gán quyền mới
            $user->permissionsValues()->sync($request->id_permissions);
        }

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        // Tìm người dùng theo ID
        $user = $this->userService->getById($id);

        // Kiểm tra nếu người dùng tồn tại
        if (!$user) {
            return response()->json(['message' => 'User không tìm thấy'], 404);
        }

        // Thực hiện xóa mềm
        $user->delete();

        return response()->json(['message' => 'User đã được xóa mềm'], 200);
    }

    public function hardDelete($id)
    {
        $user = $this->userService->getIdWithTrashed($id);
        if (!$user) {
            return response()->json(['message' => 'User không tìm thấy'], 404);
        }
        $user->forceDelete();

        return response()->json(['message' => 'User đã được xóa'], 200);
    }

    public function deleteMuitpalt(Request $request){
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer', // Đảm bảo tất cả các ID là kiểu số nguyên
            'action' => 'required|string', // Thêm xác thực cho trường action
        ]);
        // Lấy các ID và action từ yêu cầu
        $ids = $request->input('ids'); // Lấy mảng ID
        $action = $request->input('action'); // Lấy giá trị của trường action

        if (count($ids) > 0) {
            foreach ($ids as $id) {

                switch ($action) {
                    case 'soft_delete':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->userService->isSoftDeleted($id);
                            if(!$isSoftDeleted){
                                $this->destroy($id); 
                            }
                        }
                        return response()->json(['message' => 'Soft delete successful'], 200);
        
                    case 'hard_delete':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->userService->isSoftDeleted($id);
                            if($isSoftDeleted){
                                $this->hardDelete($id); 
                            }
                        }
                        return response()->json(['message' => 'Hard erase successful'], 200);
        
                    default:
                        return response()->json(['message' => 'Invalid action'], 400);
                }
            }
            return response()->json(['message' => 'Categories deleted successfully'],200);
        } else {
            return response()->json(['message' => 'Error: No IDs provided'], 500);
        }
    }
}
