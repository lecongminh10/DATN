<?php

namespace App\Models;

use App\Models\PermissionValue;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const TYPE_ADMIN = 'admin_role';
    const TYPE_SUBADMIN = 'sub_admin_role';
    const TYPE_CLIENT = 'client_role';

    const PERMISSION_ADMIN = 1;
    const PERMISSION_CLIENT = 2;

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
        'google_id',
        'facebook_id',
        'github_id',
        'twitter_id'
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

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'user_coupons')
            ->withPivot('times_used', 'deleted_by')
            ->withTimestamps();
    }

    public function isAdmin()
    {
        return $this->permissionsValues()
            ->whereIn('value', [self::TYPE_ADMIN, self::TYPE_SUBADMIN])
            ->exists();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'user_id', 'id')->withTimestamps(); 
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
