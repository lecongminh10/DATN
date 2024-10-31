<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentGateways extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payment_gateways';
    protected $fillable = [
        'name',
        'api_key',
        'secret_key',
        'gateway_type',
        'deleted_at',
        'deleted_by'
    ];

    protected $casts = [
        'deleted_at' => 'boolean'
    ];

    public function payments() {
        return $this->hasMany(Payment::class);
    }
}