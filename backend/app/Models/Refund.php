<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refund extends Model
{
    use HasFactory, SoftDeletes;

    public const  STATUS_PENDING ='pending';


    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'admin_id',
        'quantity',
        'amount',
        'refund_method',
        'reason',
        'image',
        'status',
        'requested_at',
        'processed_at',
        'rejection_reason',
        'deleted_by',
    ];

    protected $casts = [
        'image' => 'array', // Tự động chuyển đổi sang mảng
    ];

    // Quan hệ
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
