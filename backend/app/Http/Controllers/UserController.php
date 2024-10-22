<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Permission;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderLocation;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            $user = $this->userService->createUser($data);

            if ($user && $request->has('permissions')) {
                $user->permissionsValues()->attach($request->permissions);
            }

            return redirect()->route('users.index')->with([
                'user' => $user
            ]);
        } catch (\Exception $e) {
            Log::error("Error creating user: " . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo người dùng.');
        }
    }

    public function show($id)
    {
        $user = $this->userService->getById($id);

        $permissions = $user->permissionsValues;

        return view('admin.users.show', compact('user', 'permissions'));
    }

    public function edit($id)
    {
        $user = User::with('permissionsValues')->findOrFail($id);

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

        $user = $this->userService->updateUser($id, $data);

        if ($request->has('id_permissions')) {
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
                $user->forceDelete(); 
            } else {
                $user->delete();
            }
        }

        return response()->json(['success' => true, 'message' => 'Người dùng đã được xóa.']);
    }

    public function indexClient()
    {
        $user = $this->userService->getAll();
        return view('client.users.widget', compact('user'));
    }

    public function showClient($id)
    {
        $user = $this->userService->getById($id);

        $address = Address::where('user_id', $id)->first();

        return view('client.users.show', compact('user','address'));
    }

    public function updateClient(Request $request, $id)
    {   
        $request->validate([
            'username' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15|unique:users,phone_number',
            'email' => 'required|email|max:255|unique:users,email',
            'date_of_birth' => 'required|date',
        ]);
        $data = $request->all();

        $user = $this->userService->updateUser($id, $data);

        return redirect()->route('users.showClient', $user->id);
    }

    public function showOrder($id, Request $request)
    {
        $status = $request->input('status', 'all'); 
        $query = Order::query();
    
        if ($status !== 'all') {
            $query->where('status', $status); 
        }
    
        $orders = $query->get(); 
        $totalOrders = $orders->count(); 
    
        return view('client.users.showOrder', compact('orders', 'totalOrders', 'status'));
    }

    public function showDetailOrder($id){

        $orders = Order::findOrFail($id);

        $location = OrderLocation::where('order_id', $id)->first();

        return view('client.users.showDetailOrder', compact('orders','location'));
    }

    public function showLocationOrder($id){

        $location = OrderLocation::findOrFail($id);

        return view('client.users.showLocationOrder', compact('location'));
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
