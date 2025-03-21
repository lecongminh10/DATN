<?php

namespace App\Models;

use App\Events\ProductEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
              'category_id',
              'code',
              'name',
              'short_description',
              'content',
              'price_regular',
              'price_sale',
              'stock',
              'rating',
              'warranty_period',
              'view',
              'buycount',
              'wishlistscount',
              'is_active',
              'is_hot_deal',
              'is_show_home',
              'is_new',
              'is_good_deal',
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
              'is_good_deal' => 'boolean',
              'deleted_at' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function gallery(){
        return $this->hasOne(ProductGallery::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function getMainImage(){
        return $this->galleries()->where('is_main', true)->first();
    }
    
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupons_products')
                    ->withTimestamps();
    }

    //Gọi Sự Kiện Khi Có Thay Đổi Trong Cơ Sở Dữ Liệu
    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            event(new ProductEvent());
        });

        static::updated(function () {
            event(new ProductEvent());
        });

        static::deleted(function () {
            event(new ProductEvent());
        });
    }
    public function seos()
    {
        return $this->belongsToMany(SEO::class, 'seo_product')->withTimestamps()->withTrashed();
    }


    public function productDimension()
    {
        return $this->hasOne(ProductDimension::class, 'product_id');  // Sử dụng hasOne vì mỗi sản phẩm chỉ có một bảng kích thước
    }

    public function wishList()
    {
        return $this->hasOne(WishList::class, 'product_id');
    }
}


