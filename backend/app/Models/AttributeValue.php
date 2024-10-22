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

    public function productVariants()
    {
        return $this->belongsToMany(ProductVariant::class, 'attribute_value_product_variant', 'attribute_value_id', 'product_variant_id');
    }
    public function attribute()
    {     
        return $this->belongsTo(Attribute::class, 'id_attributes');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
