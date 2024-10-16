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
        'product_attribute_id',
        'price_modifier',
        'stock',
        'sku',
        "status",
        "variant_image",
        'deleted_at',
        'deleted_by'
    ];

    protected $casts = [
        'deleted_at' => 'boolean',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'product_attribute_id');
    }

    public function attributeValue()
    {
        return $this->hasMany(
            AttributeValue::class,
            'id_attributes',
            'product_attribute_id',
        );
    }
}
