<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDimension extends Model
{
    use HasFactory;

    protected $table = 'product_dimensions';

  
    protected $fillable = ['product_id', 'height', 'length', 'weight', 'width'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');  // Sử dụng belongsTo vì product_id là khóa ngoại
    }
}
