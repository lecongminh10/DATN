<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payments';

    public const VNPay='VNPay';
    
    public const Cash='Cash';

    public const Pending='pending';

    public const Completed ='completed';

    public const Failed ='failed';

    public const Refunded ='refunded';

    protected $fillable = [
        'order_id',
        'payment_gateway_id',
        'amount',
        'status',
        'transaction_id',
        'deleted_at',
        'deleted_by',
        'created_by',
        'updated_by',
    ];


    protected $casts = [
        'deleted_at' => 'boolean'
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function paymentGateway(){
        return $this->belongsTo(PaymentGateway::class);
    }
}
