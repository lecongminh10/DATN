<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrier extends Model
{
    use HasFactory,SoftDeletes;

    public const GHN='Giao Hàng Nhanh';
    protected $table='carriers';
    protected $fillable = ['name', 'api_url', 'api_token', 'phone', 'email', 'is_active', 'deleted_by'];
}
