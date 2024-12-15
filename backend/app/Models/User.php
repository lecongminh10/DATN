<?php

namespace App\Models;

use App\Events\UserEvent;
use App\Models\Order;
use App\Models\PermissionValue;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public function isClient()
    {
        return $this->permissionsValues()
            ->whereIn('value', [self::TYPE_CLIENT])
            ->exists();
    }
    //Gọi Sự Kiện Khi Có Thay Đổi Trong Cơ Sở Dữ Liệu
    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            event(new UserEvent());
        });

        static::updated(function () {
            event(new UserEvent());
        });

        static::deleted(function () {
            event(new UserEvent());
        });
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'user_id', 'id')->withTimestamps();
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    public function reviews()
    {
        return DB::table('users_reviews')->where('user_id', $this->id)->get();
    }

    public function getMembershipLevelAttribute()
    {
        // Kiểm tra số điểm loyalty và trả về hạng thành viên tương ứng
        if ($this->loyalty_points < 50000) {
            return 'Bronze';
        } elseif ($this->loyalty_points <= 100000) {
            return 'Silver';
        } elseif ($this->loyalty_points <= 200000) {
            return 'Gold';
        } else {
            return 'Platinum';
        }
    }
    public function scopeClients($query)
    {
        return $query->whereHas('permissionsValues', function ($q) {
            $q->where('value', self::TYPE_CLIENT);
        });
    }

    // Trong Model User.php
    public function getDeletedByNameAttribute()
    {
        // Kiểm tra nếu deleted_by không phải null và có liên kết tới một User khác
        return $this->deleted_by ? $this->deleted_by->username : 'Không xác định';
    }
}
