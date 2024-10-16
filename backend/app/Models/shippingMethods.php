<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shippingMethods extends Model
{
    use HasFactory;
    protected $table = 'shipping_methods';
    protected $fillable = [
        'order_id',
        'payment_gateway_id',
        'amount',
        'status',
        'transaction_id',
        'deleted_at',
        'deleted_by'
    ];

    protected $casts = [
        'deleted_at' => 'boolean'
    ];
    
}
