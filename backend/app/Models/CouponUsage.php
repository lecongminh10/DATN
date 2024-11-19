<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CouponUsage extends Model
{
    use HasFactory;
    protected $table = 'coupons_usage';
    protected $fillable = ['coupon_id', 'user_id', 'order_id', 'discount_value', 'deleted_by'];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

}
