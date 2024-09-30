<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeValue extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attributes_values';

    protected $fillable = [
        'attribute_value',
        'id_attributes',
        'delete_by'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'id_attributes');
    }
}
