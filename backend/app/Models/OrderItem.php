<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'quantity',
        'price',
        'discount',
        'deleted_at',
        'deleted_by',
    ];

    protected $casts = [
        'deleted_at' => 'boolean',
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productVariant(){
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

}