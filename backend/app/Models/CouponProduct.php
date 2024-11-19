<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponProduct extends Model
{
    use HasFactory;

    protected $table = 'coupons_products';
    protected $fillable = ['coupon_id', 'product_id'];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
