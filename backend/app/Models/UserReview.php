<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserReview extends Model
{
    protected $table = 'users_reviews'; // Cập nhật tên bảng chính xác
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'review_text',
        'review_date',
        'images',
        'videos',
        'is_verified',
        'helpful_count',
        'reply_text',
        'reply_date',
        'deleted_by',
        'product_variants_id',
    ];

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // public function productGallery()
    // {
    //     return $this->belongsTo(ProductGallery::class);
    // }
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
