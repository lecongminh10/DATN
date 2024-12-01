<?php

namespace App\Http\Controllers;

use App\Events\AdminActivityLogged;
use Log;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\PermissionValue;
use App\Services\PermissionService;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Services\PermissionValueService;

class PermissionController extends Controller
{
    protected $permissionService;
    protected $permissionValueService;

    public function __construct(PermissionService $permissionService, PermissionValueService $permissionValueService)
    {
        $this->permissionService = $permissionService;
        $this->permissionValueService = $permissionValueService;
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage');
        $permission = $this->permissionService->getSeachPermission($search, $perPage);
        $permissions = Permission::paginate(10);
        $permissionValues = $this->permissionValueService->paginate(10);
        return view('admin.permissions.list', compact('permissions', 'permissionValues','search'));
    }

    public function show($id)
    {
        $permission = Permission::with('permissionValues')->findOrFail($id);
        return view('admin.permissions.show', compact('permission'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }
    public function store(PermissionRequest $request)
    {
        // dd($request->all());
        $permission = Permission::create([
            'permission_name' => $request->permission_name,
            'description' => $request->description1,
        ]);

        foreach ($request->value as $key => $value) {
            PermissionValue::create([
                'permissions_id' => $permission->id,
                'value' => $value,
                'description' => $request->description[$key],
            ]);
        }

        $logDetails = sprintf(
            'Thêm quyền: Tên - %s',
            $permission->permission_name,
        );

        // Ghi nhật ký hoạt động
        event(new AdminActivityLogged(
            auth()->user()->id,
            'Thêm mới',
            $logDetails
        ));
        
        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
    }
    public function edit($id)
    {
        $permission = Permission::with('permissionValues')->findOrFail($id);
        return view('admin.permissions.edit', compact('permission'));
    }
    public function update(PermissionRequest $request, $id)
    {
        // dd($request->all());
        $permission = Permission::findOrFail($id);

        $permission->update([
            'permission_name' => $request->permission_name,
            'description' => $request->description1,
        ]);

        $PermissionValues = $permission->permissionValues;

        foreach ($request->value as $key => $value) {
            if (isset($PermissionValues[$key])) {
                $PermissionValues[$key]->update([
                    'value' => $value,
                    'description' => $request->description[$key],
                ]);
            } else {
                PermissionValue::create([
                    'permissions_id' => $permission->id,
                    'value' => $value,
                    'description' => $request->description[$key],
                ]);
            }
        }

        $logDetails = sprintf(
            'Sửa quyền: Tên - %s',
            $permission->permission_name,
        );

        // Ghi nhật ký hoạt động
        event(new AdminActivityLogged(
            auth()->user()->id,
            'Sửa',
            $logDetails
        ));

        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
    }
    public function destroyPermission($id)
    {
        $permission = Permission::findOrFail($id);

        $permissionValues = $permission->permissionValues;

        foreach ($permissionValues as $value) {
            $value->delete();
        }
        if (!$permission) {
            return redirect()->back()->with('error', 'Permission not found.');
        }
        $permission->delete();
        if ($permission->trashed()) {
            return redirect()->route('admin.permissions.index')->with('success', 'Permission soft deleted successfully.');
        }

        $logDetails = sprintf(
            'Xóa quyền: Tên - %s',
            $permission->permission_name,
        );

        // Ghi nhật ký hoạt động
        event(new AdminActivityLogged(
            auth()->user()->id,
            'Xóa',
            $logDetails
        ));
        return redirect()->route('admin.permissions.index')->with('error', 'An error occurred while deleting the category.');
    }
    public function destroyPermissionHard($id)
    {
        $permission = $this->permissionService->getIdWithTrashed($id);
        $permissionValues = $permission->permissionValues;
        foreach ($permissionValues as $value) {
            $value->forceDelete();
        }
        if (!$permission) {
            return redirect()->back()->with('error', 'Permission not found.');
        }
        $permission->forceDelete();
        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }
    public function destroyPermissionValue($id)
    {
        $permissionValue = PermissionValue::findOrFail($id);

        $permissionValue->delete();

        return redirect()->route('admin.permissions.index')->with('success', 'Permission Value đã được xóa.');
    }
    public function destroyPermissionValueHard($id)
    {
        $data = $this->permissionValueService->getIdWithTrashed($id);
        if (!$data) {
            return redirect()->back()->with('error', 'Permission not found.');
        }
        $data->forceDelete();
        if ($data->trashed()) {
            return redirect()->route('admin.permissions.index')->with('success', 'Permission value soft deleted successfully.');
        }
    }
    public function destroy($id, Request $request)
    {
        $permission = Permission::findOrFail($id);

        if ($request->forceDelete === 'true') {
            $permission->forceDelete();
        } else {
            $permission->delete();
        }

        return redirect()->route('admin.permissions.index')->with('success', 'User deleted successfully');
    }

    public function destroyMultiple(Request $request)
    {
        $ids = json_decode($request->input('ids'));
        if (is_array($ids) && count($ids) > 0) {
            foreach ($ids as $id) {
                $permission = Permission::find($id);
                if ($permission) {
                    PermissionValue::where('permissions_id', $id)->delete();
                    $permission->delete();
                }
            }

            return redirect()->route('admin.permissions.index')->with('success', 'Permissions and their values deleted successfully.');
        } else {
            return redirect()->route('admin.permissions.index')->with('error', 'No permissions were selected to delete.');
        }
    }




    public function destroyMultipleValues(Request $request)
    {
        $valueIds = json_decode($request->input('value_ids'));
        PermissionValue::whereIn('id', $valueIds)->delete();
        return redirect()->route('permissions.index')->with('success', 'Các giá trị quyền đã được xóa thành công.');
    }
}
