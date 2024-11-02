<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCoupon extends Model
{
    use HasFactory;

    protected $table = 'user_coupons';
    protected $fillable = ['coupon_id', 'user_id', 'times_used', 'deleted_by'];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
