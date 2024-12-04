<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserActivityLog extends Model
{
    use HasFactory ,SoftDeletes;

    protected $table = 'user_activity_logs';

    protected $fillable = [
        'user_id', 'activity_type', 'module', 'detail','created_by','updated_by','deleted_at','deleted_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');  
    }
}
