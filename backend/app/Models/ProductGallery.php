<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGallery extends Model
{
    use HasFactory ,SoftDeletes;

    protected $table = 'product_galaries';

    protected $fillable = [
        'product_id',
        'image_gallery',
        'is_main',
        'deleted_at',
        'deleted_by',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'deleted_at' => 'boolean',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }



}
