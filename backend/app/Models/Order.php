<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

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
        'deleted_by',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_id', 'id')->withTimestamps(); 
    }

    public function orderLocation()
    {
        return $this->belongsToMany(OrderLocation::class, 'order_id', 'id')->withTimestamps(); 
    }
}
