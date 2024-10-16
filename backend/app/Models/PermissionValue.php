<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermissionValue extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'permissions_values';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        "permissions_id",
        "value",
        "description"
    ];


    public function permission()
    {
        return $this->belongsTo(Permission::class , 'permissions_id' , 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'permissions_value_users', 'permission_value_id', 'user_id')
                    ->withTimestamps();
    }
}
