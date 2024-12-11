<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'attribute_name',
        'description',
        'deleted_by'
    ];

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'id_attributes');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
