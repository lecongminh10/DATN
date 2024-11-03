<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory ,SoftDeletes;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'price_modifier',
        'original_price',
        'stock',
        'sku',
        "status",
        "variant_image",
        'deleted_at',
        'deleted_by',
        'promotion_end_time'
    ];

    protected $casts = [
        'deleted_at' => 'boolean',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'attribute_value_product_variant', 'product_variant_id', 'attribute_value_id');
    }
}
