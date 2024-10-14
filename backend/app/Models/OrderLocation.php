<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_locations';

    protected $fillable = [
        'order_id',
        'address',
        'city',
        'district',
        'ward',
        'latitude',
        'longitude',
        'deleted_at',
        'deleted_by'
    ];

    protected $casts = [
        'deleted_at' => 'boolean',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}