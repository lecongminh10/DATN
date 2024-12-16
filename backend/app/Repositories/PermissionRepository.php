<?php
 namespace App\Repositories;
 use App\Models\Permission;

 class PermissionRepository extends BaseRepository{
    protected $permissionRepository;
    public function __construct( Permission $permissionRepository){
        parent::__construct($permissionRepository);
        $this ->permissionRepository = $permissionRepository;
    }
    public function getSearch($search = null, $perPage = 10)
    {
        $query = Permission::with('permissionValues');
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('permission_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }
        return $query->paginate($perPage);
    }
 }

