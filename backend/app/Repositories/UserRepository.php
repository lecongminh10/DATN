<?php

namespace App\Repositories;

use App\Models\User;


class UserRepository extends BaseRepository
{
    protected $userRepository;

    public function __construct(User $userRepository)
    {
        parent::__construct($userRepository);
        $this->userRepository = $userRepository;
    }

    public function getAllUser()
    {
        return User::with('permissionsValues')->get();
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function getAllTrashedUsers()
    {
        return User::onlyTrashed()->with('permissionsValues')->get();
    }

   
}