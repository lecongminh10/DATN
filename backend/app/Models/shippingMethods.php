<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shippingMethods extends Model
{
    use HasFactory;

    public const HANG_NHE = 2;
    public const HANG_NANG = 5;
    public const WEIGHT =20000;

    public const PENDING ='pending';
    public const COMPLETED ='completed';
    public const FAILED ='failed';
    public const REFUNDE='refunded';
    protected $table = 'shipping_methods';

    protected $fillable = [
        'order_id',
        'payment_gateway_id',
        'amount',
        'status',
        'transaction_id',
        'deleted_at',
        'deleted_by',
        'shipping_fee'
    ];

    protected $casts = [
        'deleted_at' => 'boolean'
    ];
    
}
