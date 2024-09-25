<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'code',
        'name',
        'short_description',
        'content',
        'sku',
        'price_regular',
        'price_sale',
        'stock',
        'rating',
        'tags',
        'warranty_period',
        'view',
        'buycount',
        'wishlistscount',
        'is_active',
        'is_hot_deal',
        'is_show_home',
        'is_new',
        'slug',
        'meta_title',
        'meta_description',
        'deleted_at',
        'deleted_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_hot_deal' => 'boolean',
        'is_show_home' => 'boolean',
        'is_new' => 'boolean',
        'deleted_at' => 'boolean',
    ];

    public function catgories() {
        return $this->belongsTo(Category::class);
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

}


