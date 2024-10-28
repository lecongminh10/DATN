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

    public function getAdminWithAddresses()
    {
        // Tìm admin đầu tiên và eager load địa chỉ
        $admin = User::with('addresses')
            ->whereHas('permissionsValues', function ($query) {
                $query->where('value', User::TYPE_ADMIN);
            })
            ->first(); // Lấy admin đầu tiên

        // Kiểm tra xem admin có tồn tại không
        if ($admin) {
            return $admin; // Trả về admin (có cả địa chỉ)
        }

        return null; // Trả về null nếu không tìm thấy admin
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