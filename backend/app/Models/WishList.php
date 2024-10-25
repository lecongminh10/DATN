<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    use HasFactory;

    protected $table = 'wishlists';
    protected $fillable = [
        'user_id',
        'product_id',
        'product_variants_id',
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
            ProductVariant::class,
            'id',
            'id_attributes',
            'product_variants_id',
            'product_attribute_id'
        );
    }

}