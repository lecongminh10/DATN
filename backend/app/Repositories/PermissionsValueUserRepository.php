<?php


namespace App\Repositories;

use App\Models\PermissionsValueUser;


class PermissionsValueUserRepository extends BaseRepository
{
    protected $permissionsValueUser;

    public function __construct(PermissionsValueUser $permissionsValueUser)
    {
        parent::__construct($permissionsValueUser);
        $this->permissionsValueUser = $permissionsValueUser;
    }

    public function getAllPermissionsValueUser()
    {
        return PermissionsValueUser::all();
    }

    public function create(array $data)
    {
        return PermissionsValueUser::create($data);
    }

    public function findById($id)
    {
        return PermissionsValueUser::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $permissionsValueUser = PermissionsValueUser::findOrFail($id);
        $permissionsValueUser->update($data);
        return $permissionsValueUser;
    }

    public function delete($id)
    {
        $user = PermissionsValueUser::findOrFail($id);
        $user->delete();
    }

   
}