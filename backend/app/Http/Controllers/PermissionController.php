<?php

namespace App\Http\Controllers;

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
        return response()->json([
            'message' => 'success',
            'permission' => $permission,
        ], 200);
    }

    public function show($id)
    {
        $permission = $this->permissionService->findById($id);
        return response()->json($permission);
    }

    public function storeOrUpdate(PermissionRequest $request, $id = null)
    {
        // Lưu hoặc cập nhật permission
        if ($id) {
            $permissions = $this->permissionService->saveOrUpdate($request->all(), $id);
        } else {
            $permissions = $this->permissionService->saveOrUpdate($request->all());
        }
        $permissionsValuesResponse = [];
        if ($request->has('permissions_values')) {
            foreach ($request->permissions_values as $item) {
                $permissionValue = [
                    'permissions_id' => $permissions->id,
                    'value' => $item['value'],
                    'description'=>$item['description']
                ];
                if (isset($item['id'])) {
                    // Cập nhật permissions_value
                    $result = $this->permissionValueService->saveOrUpdate($permissionValue, $item['id']);
                    if ($result) {
                        $permissionsValuesResponse[] = $permissionValue; // Lưu lại permission value nếu thành công
                    } else {
                        return response()->json(['error' => 'Failed to update permission value.'], 500);
                    }
                } else {
                    // Thêm mới permissions_value
                    $result = $this->permissionValueService->saveOrUpdate($permissionValue); // Giả sử bạn có phương thức saveOrUpdate

                    // Kiểm tra xem permission_value có lưu thành công không
                    if ($result) {
                        $permissionsValuesResponse[] = $permissionValue; // Lưu lại permission value nếu thành công
                    } else {
                        return response()->json(['error' => 'Failed to save permission value.'], 500);
                    }
                }
            }
        }
        return response()->json([
            'permissions' => $permissions,
            'permissions_values' => $permissionsValuesResponse
        ], 201);
    }
    public function destroyPermission($id)
    {
        $data = $this->permissionService->getById($id);
        if(!$data){
            return response()->json(['message' => 'Category not found'], 404);
        }
        $data->delete();
        if ($data->trashed()) {
            return response()->json(['message' => 'Category soft deleted successfully'], 200);
        }

        return response()->json(['message' => 'Category permanently deleted and cover file removed'], 200);
    }
    public function destroyPermissionHard($id)
    {
        $permission = $this->permissionService->getIdWithTrashed($id);
        if (!$permission) {
            return response()->json(['error' => 'Permission not found.'], 404);
        }
        $permission->forceDelete();
        return response()->json(['message' => 'Delete with success'], 200);
    }
    public function destroyPermissionValue(int $id)
    {
        $data= $this->permissionValueService->getById($id);
        if(!$data){
            return response()->json(['message' => 'Category not found'], 404);
        }
        $data->delete();
        if ($data->trashed()) {
            return response()->json(['message' => 'Category soft deleted successfully'], 200);
        }
    }
    public function destroyPermissionValueHard(int $id)
    {
        $data = $this->permissionValueService->getIdWithTrashed($id);
        if (!$data) {
            return response()->json(['message' => 'Category not found.'], 404);
        }
        $data->forceDelete();
        return response()->json(['message' => 'Delete with success'], 200);
    }

    public function deleteMuitpalt(Request $request){
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer', 
            'action' => 'required|string',
        ]);
    
        $ids = $request->input('ids');
        $action = $request->input('action'); 
        if (count($ids) > 0) {
            foreach ($ids as $id) {

                switch ($action) {
                    case 'soft_delete_permission':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->permissionService->isSoftDeleted($id);
                            if(!$isSoftDeleted){
                                $this->destroyPermission($id); 
                            }
                        }
                        return response()->json(['message' => 'Soft delete successful'], 200);
                     
                    case 'hard_delete_permission':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->permissionService->isSoftDeleted($id);
                            if( $isSoftDeleted){
                                $this->destroyPermissionHard($id);
                            } 
                        }
                        return response()->json(['message' => 'Hard erase successful'], 200);

                    case 'soft_delete_permission_values':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->permissionValueService->isSoftDeleted($id);
                            if(!$isSoftDeleted){
                                    $this->destroyPermissionValue($id); 
                                }
                            }
                            return response()->json(['message' => 'Soft delete successful'], 200);

                    case 'hard_delete_attribute_value':
                        foreach ($ids as $id) {
                            $isSoftDeleted = $this->permissionValueService->isSoftDeleted($id);
                            if($isSoftDeleted){
                                $this->destroyPermissionValueHard($id);
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
