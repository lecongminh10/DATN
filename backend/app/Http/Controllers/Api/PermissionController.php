<?php

namespace App\Http\Controllers\Api;

use Log;
use App\Models\Permission;
use Illuminate\Http\Request;
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
        return view();
    }

    public function show($id)
    {
        $permission = $this->permissionService->findById($id);
        return response()->json($permission);
    }

    public function store(PermissionRequest $request)
    {
        // Lưu permission mới
        $permissions = $this->permissionService->saveOrUpdate($request->all());
        $permissionsValuesResponse = [];

        // Lưu các permission_values nếu có
        if ($request->has('permissions_values')) {
            foreach ($request->permissions_values as $item) {
                $permissionValue = [
                    'permissions_id' => $permissions->id,
                    'value' => $item['value']
                ];
                $result = $this->permissionValueService->saveOrUpdate($permissionValue);
                if ($result) {
                    $permissionsValuesResponse[] = $permissionValue; // Lưu lại permission value nếu thành công
                } else {
                    return response()->json(['error' => 'Failed to save permission value.'], 500);
                }
            }
        }

        return response()->json([
            'permissions' => $permissions,
            'permissions_values' => $permissionsValuesResponse
        ], 201);
    }
    public function update(PermissionRequest $request, $id)
    {
        // Cập nhật permission
        $permissions = $this->permissionService->saveOrUpdate($request->all(), $id);
        $permissionsValuesResponse = [];

        // Cập nhật các permission_values nếu có
        if ($request->has('permissions_values')) {
            foreach ($request->permissions_values as $item) {
                $permissionValue = [
                    'permissions_id' => $permissions->id,
                    'value' => $item['value']
                ];

                if (isset($item['id'])) {
                    // Cập nhật permission_value nếu đã tồn tại
                    $result = $this->permissionValueService->saveOrUpdate($permissionValue, $item['id']);
                    if ($result) {
                        $permissionsValuesResponse[] = $permissionValue; // Lưu lại permission value nếu thành công
                    } else {
                        return response()->json(['error' => 'Failed to update permission value.'], 500);
                    }
                }
            }
        }
        return response()->json([
            'permissions' => $permissions,
            'permissions_values' => $permissionsValuesResponse
        ], 200);
    }
    public function destroy($id)
    {
        // Kiểm tra xem permission có tồn tại không
        $permission = $this->permissionService->getById($id);
        if (!$permission) {
            return response()->json(['error' => 'Permission not found.'], 404);
        }
        $permissionsValues = $this->permissionValueService->getByPermissionId($id);

        foreach ($permissionsValues as $value) {
            $this->permissionValueService->delete($value->id);
        }
        $this->permissionService->delete($id);

        return response()->json(null, 204);
    }
    public function deletePermission($id)
    {
        // Kiểm tra xem permission có tồn tại không
        $permission = $this->permissionService->getById($id);
        if (!$permission) {
            return response()->json(['error' => 'Permission not found.'], 404);
        }

        // Lấy danh sách các permissionValues liên quan đến permission
        $permissionsValues = $this->permissionValueService->getByPermissionId($id);

        // Xóa các permissionValues liên quan
        foreach ($permissionsValues as $value) {
            $this->permissionValueService->forceDelete($value->id); // Xóa cứng
        }

        // Xóa cứng permission
        $this->permissionService->forceDelete($id); // Xóa cứng

        return response()->json(null, 204);
    }
    public function detroyPermissionValue(Request $request)
    {

        $id_permission = $request->permissionsId;
        $permission_value_ids = $request->permissions_value_ids;
        $permissions = $this->permissionService->getById($id_permission);

        $list_permission_values = $permissions->permissionValues;
        if (count($list_permission_values) > 0) {
            foreach ($list_permission_values as $value) {
                if (count($permission_value_ids) > 0) {
                    foreach ($permission_value_ids as $id) {
                        if ($value->id == $id) {
                            $this->permissionValueService->delete($value->id);
                        }
                    }
                }
            }
        }
        return response()->json(['data' => $permissions], 200);
    }
    public function detroyValuePermission(Request $request)
    {

        $id_permission = $request->permissionsId;
        $permission_value_ids = $request->permissions_value_ids;
        $permissions = $this->permissionService->getById($id_permission);

        $list_permission_values = $permissions->permissionValues;
        if (count($list_permission_values) > 0) {
            foreach ($list_permission_values as $value) {
                if (count($permission_value_ids) > 0) {
                    foreach ($permission_value_ids as $id) {
                        if ($value->id == $id) {
                            $this->permissionValueService->forceDelete($value->id);
                        }
                    }
                }
            }
        }
        return response()->json(['data' => $permissions], 200);
    }
}
