<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory; //SoftDeletes

    protected $table = 'carts';
    protected $fillable = [
        'user_id',
        'product_id',
        'product_variants_id',
        'quantity',
        'total_price',
        'deleted_at',
        'deleted_by'
    ];

    protected $casts = [
        'deleted_at' => 'boolean'
    ];


    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productVariant() {
        return $this->belongsTo(related: ProductVariant::class, foreignKey: 'product_variants_id');
    }

    public function attributeValues()
    {
        return $this->hasManyThrough(
            AttributeValue::class,
            AttributeValueProductVariant::class,
            'product_variant_id', // Khóa ngoại trong bảng trung gian
            'id',                 // Khóa ngoại trong bảng attributes_values
            'product_variants_id',// Khóa ngoại trong bảng giỏ hàng
            'attribute_value_id'  // Khóa ngoại trong bảng trung gian attribute_value_product_variant
        );
    }
}
