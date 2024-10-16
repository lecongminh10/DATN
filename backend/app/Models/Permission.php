<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory , SoftDeletes;

    protected $tablle = 'permissions';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        "permission_name",
        "description",
    ];
    public function permissionValues()
    {
        return $this->hasMany(PermissionValue::class , 'permissions_id' ,'id');
    }

}
