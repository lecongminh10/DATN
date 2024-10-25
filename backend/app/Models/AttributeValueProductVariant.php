<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValueProductVariant extends Model
{
    use HasFactory;
    protected $table = 'attribute_value_product_variant'; // Tên bảng

    protected $fillable = [
        'product_variant_id',
        'attribute_value_id',
    ];

    // Định nghĩa quan hệ với ProductVariant
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    // Định nghĩa quan hệ với AttributeValue
    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }
}
