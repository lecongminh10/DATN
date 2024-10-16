<?php
namespace App\Services;
use App\Models\PermissionValue;
use App\Repositories\PermissionValueRepository;

class PermissionValueService extends BaseService {
    protected $permissionValueService;

    public function __construct(PermissionValueRepository $permissionValueService) {
        parent::__construct($permissionValueService);
        $this->permissionValueService = $permissionValueService;
    }
    public function getByPermissionId($permissionId)
    {
        return PermissionValue::where('permissions_id', $permissionId)->get();
    }
    public function forceDelete($id)
{
    return PermissionValue::findOrFail($id)->forceDelete(); // Xóa cứng một permission
}
}
