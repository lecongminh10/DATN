<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'applies_to',
        'code',
        'description',
        'discount_type',
        'discount_value',
        'max_discount_amount',
        'min_order_value',
        'start_date',
        'end_date',
        'usage_limit',
        'per_user_limit',
        'is_active',
        'is_stackable',
        'eligible_users_only',
        'created_by'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_coupons')
            ->withPivot('times_used', 'deleted_by')
            ->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'coupons_categories')
            ->withTimestamps();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'coupons_products')
            ->withTimestamps();
    }

    public function usage()
    {
        return $this->hasMany(CouponUsage::class);
    }
    public function couponUsages()
    {
        return $this->hasMany(CouponUsage::class, 'coupon_id');
    }
}
