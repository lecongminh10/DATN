<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Support\Facades\Log;
use App\Models\PermissionValue;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $userRepository;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function index()
    {
        $user = $this->userService->getAll();
        return view('admin.users.index', compact('user'));
    }

    public function add()
    {
        $permissionsValues = Permission::with('permissionValues')
            ->where('permission_name', 'user_management')
            ->first()
            ->permissionValues;
        return view('admin.users.store', compact('permissionsValues'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:users,email',
            'date_of_birth' => 'required|date',
        ]);
        try {
            $data = $request->except('permissions');

            // Tạo người dùng
            $user = $this->userService->createUser($data);

            // Gán quyền cho người dùng
            if ($user && $request->has('permissions')) {
                $user->permissionsValues()->attach($request->permissions);
            }

            return redirect()->route('users.index')->with([
                'user' => $user
            ]);
        } catch (\Exception $e) {
            // Ghi log lỗi để debug hoặc hiển thị thông báo lỗi
            Log::error("Error creating user: " . $e->getMessage());
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo người dùng.');
        }
    }

    public function show($id)
    {
        // Lấy thông tin người dùng
        $user = $this->userService->getById($id);

        // Lấy quyền của người dùng
        $permissions = $user->permissionsValues;

        // Trả về thông tin người dùng cùng với quyền
        return view('admin.users.show', compact('user', 'permissions'));
    }

    public function edit($id)
    {
        // Lấy thông tin người dùng cùng quyền của họ
        $user = User::with('permissionsValues')->findOrFail($id);

        // Lấy tất cả permissionValues liên quan đến `user_management`
        $permissionsValues = Permission::with('permissionValues')
            ->where('permission_name', 'user_management')
            ->first()
            ->permissionValues;

        return view('admin.users.update', compact('user', 'permissionsValues'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:users,email',
            'date_of_birth' => 'required|date',
        ]);
        $data = $request->all();

        // Cập nhật người dùng
        $user = $this->userService->updateUser($id, $data);

        // Cập nhật quyền cho người dùng
        if ($request->has('id_permissions')) {
            // Xóa quyền cũ và gán quyền mới
            $user->permissionsValues()->sync($request->id_permissions);
        }
        return redirect()->route('users.index');
    }

    public function destroy($id, Request $request)
    {
        $user = User::findOrFail($id);

        if ($request->forceDelete === 'true') {
            $user->forceDelete();
        } else {
            $user->delete();
        }

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }


    // UserController.php
    public function deleteMultiple(Request $request)
    {
        $ids = json_decode($request->ids); // Lấy danh sách ID từ yêu cầu
        $forceDelete = $request->forceDelete === 'true'; // Kiểm tra có xóa vĩnh viễn không
        // Xóa người dùng
        foreach ($ids as $id) {
            $user=User::withTrashed()->find($id);
            if ($forceDelete) {
                $user->forceDelete(); // Xóa vĩnh viễn
            } else {
                $user->delete(); // Xóa mềm
            }
        }

        return response()->json(['success' => true, 'message' => 'Người dùng đã được xóa.']);
    }

    public function listdeleteMultiple(){
        $user = $this->userService->getAllTrashedUsers();
        return view('admin.users.deleted', compact('user'));
    }

    public function manage(Request $request, int $id)
    {

        $user = User::onlyTrashed()->find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        if ($request->input('action') === 'restore') {
            $user->restore();
            return response()->json(['success' => true, 'message' => 'User restored successfully.']);
        } elseif ($request->input('action') === 'hard-delete') {
            $user->forceDelete();
            return response()->json(['success' => true, 'message' => 'User deleted permanently.']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid action.'], 400);
    }

}
