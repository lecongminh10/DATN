<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'attribute_name',
        'description',
    ];

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'id_attributes');
    }

}
