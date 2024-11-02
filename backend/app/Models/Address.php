<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'addresses';

    protected $fillable = [
        'recipient_name',
        'user_id',
        'specific_address',
        'ward',
        'district',
        'city',
        'active'
    ];
    protected $casts = [
        'deleted_at' => 'boolean'
    ];

     /**
     * Kiểm tra nếu user_id có địa chỉ active
     *
     * @param int $userId
     * @return bool
     */
    public static function hasActiveAddress($userId)
    {
        return self::where('user_id', $userId)->where('active', true)->exists();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getActiveAddress($userId)
    {
        return self::where('user_id', $userId)->where('active', true)->first();  
    }

}
