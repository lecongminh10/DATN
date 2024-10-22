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
        'deleted_by', 
        'created_at', 
        'updated_at'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_id', 'id')->withTimestamps(); 
    }
}
