<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService extends BaseService
{
    protected $userService;
    protected $userRepository;
    protected $permissionsValueUserRepository;

    public function __construct(UserRepository $userService)
    {
        parent::__construct($userService);
        $this ->userService = $userService;
    }

    public function getAll(){
        return $this->userService->getAllUser();
    }


    public function createUser(array $data)
    {
        return $this->userService->create($data);
    }

    public function updateUser($id, array $data)
    {
        return $this->userService->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userService->delete($id);
    }

    public function getAllTrashedUsers(){
        return $this->userService->getAllTrashedUsers();
    }
}