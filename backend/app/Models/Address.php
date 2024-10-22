<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

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
        'deleted_by',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_id', 'id')->withTimestamps(); 
    }
}
