<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\PermissionsValueUser;
use App\Services\PermissionsValueUserService;
use App\Repositories\UserRepository;
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
        $dataProduct['is_verified'] ??= 0;
        $data = $request->except('id_permissions');
        $user = $this->userService->createUser($data);
        $user->permissionsValues()->attach($request->id_permissions);
        return response()->json($user, 201);
    }

    public function show($id)
    {
        // Lấy thông tin người dùng
        $user = $this->userService->getUserById($id);

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
        $user = $this->userService->getUserById($id);

        // Kiểm tra nếu người dùng tồn tại
        if (!$user) {
            return response()->json(['message' => 'User không tìm thấy'], 404);
        }

        // Thực hiện xóa mềm
        $user->delete();

        return response()->json(['message' => 'User đã được xóa mềm'], 200);
    }

    public function forceDelete($id)
    {
        //  Tìm người dùng theo ID
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return response()->json(['message' => 'User không tìm thấy'], 404);
        }

        // Xóa vĩnh viễn người dùng
        $user->forceDelete();

        return response()->json(['message' => 'User đã được xóa'], 200);
    }
}
