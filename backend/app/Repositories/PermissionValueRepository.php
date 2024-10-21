<?php
 namespace App\Repositories;
use App\Models\PermissionValue;

 class PermissionValueRepository extends BaseRepository{
    protected $permissionvalueRepository;
    public function __construct( PermissionValue $permissionvalueRepository){
        parent::__construct($permissionvalueRepository);
        $this ->permissionvalueRepository = $permissionvalueRepository;
    }
    public function getByPermissionId($permissionId)
    {
        return PermissionValue::where('permissions_id', $permissionId)->get();
    }
 }

