<?php

namespace App\Models;

use App\Models\PermissionValue;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'password',
        'language',
        'currency',
        'loyalty_points',
        'is_verified',
        'profile_picture',
        'date_of_birth',
        'gender',
        'phone_number',
        'status',
        'remember_token',
        'email_verified_at',
        'last_login_at',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'deleted_at' => 'boolean'
    ];

    public function permissionsValues()
    {
        return $this->belongsToMany(PermissionValue::class, 'permissions_value_users', 'user_id', 'permission_value_id')
                    ->withTimestamps();
    }
}
