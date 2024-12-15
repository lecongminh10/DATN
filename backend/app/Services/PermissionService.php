<?php

namespace App\Services;

use App\Models\Permission;
use App\Repositories\PermissionRepository;

class PermissionService extends BaseService
{
    protected $permissionSevice;

    public function __construct(PermissionRepository $permissionSevice)
    {
        parent::__construct($permissionSevice);
        $this->permissionSevice = $permissionSevice;
    }
    public function getSeachPermission($search, $perPage = 10)
    {
        return $this->permissionSevice->getSearch($search, $perPage);
    }
    public function findById($id)
    {
        return Permission::with('permissionValues')->findOrFail($id);
    }
    public function forceDelete($id)
    {
        return Permission::findOrFail($id)->forceDelete(); // Xóa cứng một permission
    }
}
