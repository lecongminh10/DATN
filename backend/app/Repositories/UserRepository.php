<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;


class UserRepository extends BaseRepository
{
    protected $userRepository;

    public function __construct(User $userRepository)
    {
        parent::__construct($userRepository);
        $this->userRepository = $userRepository;
    }

    public function getAllUser($perPage = 5)
    {
        return User::with('permissionsValues')->simplePaginate($perPage);
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

    public function getAllClient(array $types)
    {
        $currentUserId = auth()->id();
        return DB::table('users')
            ->join('permissions_value_users', 'users.id', '=', 'permissions_value_users.user_id')
            ->join('permissions_values', 'permissions_value_users.permission_value_id', '=', 'permissions_values.id')
            ->whereIn('permissions_values.value', $types)
            ->where('users.id', '!=', $currentUserId) 
            ->select('users.id' , 'users.username','users.profile_picture');
    }
}