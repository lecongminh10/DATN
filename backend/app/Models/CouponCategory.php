<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponCategory extends Model
{
    use HasFactory;

    protected $table = 'coupons_categories';
    protected $fillable = ['coupon_id', 'category_id'];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function categorys()
    {
        return $this->belongsTo(Category::class);
    }
}
