<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "orders";

    protected $fillable = [
        'user_id',
        'code',
        'total_price',
        'shipping_address_id',
        'payment_id',
        'note',
        'status',
        'carrier_id',
        'tracking_number',
        'deleted_at',
        'deleted_by'
    ];

    public const CHO_XAC_NHAN = 'Chờ xác nhận';
    public const DA_XAC_NHAN = 'Đã xác nhận';
    public const DANG_GIAO = 'Đang giao';
    public const HOAN_THANH = 'Hoàn thành';
    public const HANG_THAT_LAC = 'Hàng thất lạc';
    public const DA_HUY = 'Đã hủy';

    protected $casts = [
        'deleted_at' => 'boolean',
    ];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function locations() {
        return $this->hasMany(OrderLocation::class);
    }

    public function payment() {
        return $this->belongsTo(Payment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}