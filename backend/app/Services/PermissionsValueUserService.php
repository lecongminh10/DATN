<?php

namespace App\Services;

use App\Repositories\PermissionsValueUserRepository;
use App\Repositories\UserRepository;

class PermissionsValueUserService extends BaseService
{
    protected $permissionsValueUserService;

    public function __construct(PermissionsValueUserRepository $permissionsValueUserService)
    {
        parent::__construct($permissionsValueUserService);
        $this ->permissionsValueUserService = $permissionsValueUserService;
    }

    // public function getByPermissionValueUserId($permissions_value_id)
    // {
    //     return UserRepository::where('permissions_value_id', $permissions_value_id)->get();
    // }
    public function getAll(){
        return $this->permissionsValueUserService->getAllPermissionsValueUser();
    }

    public function createPermissionsValueUser(array $data)
    {
        return $this->permissionsValueUserService->create($data);
    }

    public function getPermissionsValueUserById($id)
    {
        return $this->permissionsValueUserService->findById($id);
    }

    public function updatePermissionsValueUser($id, array $data)
    {
        return $this->permissionsValueUserService->update($id, $data);
    }

    public function deletePermissionsValueUser($id)
    {
        return $this->permissionsValueUserService->delete($id);
    }
}