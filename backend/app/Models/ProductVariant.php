<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

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

    public function attributes()
    {
        return $this->belongsTo(Product::class);
    }
}
