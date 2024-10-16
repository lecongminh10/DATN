<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';
    protected $fillable = [
        'user_id',
        'address_line',
        'address_line1',
        'address_line2',
        'deleted_at',
        'deleted_by'
    ];
    protected $casts = [
        'deleted_at' => 'boolean'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
