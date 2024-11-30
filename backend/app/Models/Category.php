<?php

namespace App\Models;

use App\Events\CategoryEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'image',
        'parent_id',
        'is_active',
        'deleted_at',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'deleted_at' => 'boolean'
    ];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
  
    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }
    public function getChildrenProductsCountAttribute()
    {
        return $this->children()->withCount('products')->get()->sum('products_count');
    }
  
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupons_categories')
                    ->withTimestamps();
    }
    
    //Gọi Sự Kiện Khi Có Thay Đổi Trong Cơ Sở Dữ Liệu
    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            event(new CategoryEvent());
        });

        static::updated(function () {
            event(new CategoryEvent());
        });

        static::deleted(function () {
            event(new CategoryEvent());
        });
    }


    // Một danh mục có nhiều sản phẩm
    // public function products()
    // {
    //     return $this->hasMany(Product::class);
    // }

    // Phương thức tính tổng số sản phẩm trong danh mục
    // public function productCount()
    // {
    //     return $this->products()->count();
    // }

    // // Phương thức tính tổng doanh thu của danh mục
    // public function totalRevenue()
    // {
    //     // Giả sử trong bảng `products` có cột `price` và bạn muốn tính tổng doanh thu
    //     return $this->products()->sum('price');
    // }

    // // Phương thức lấy sản phẩm bán chạy nhất trong danh mục
    // public function bestSellingProduct()
    // {
    //     // Giả sử trong bảng `products` có cột `sales` hoặc cột theo dõi số lượng bán ra
    //     return $this->products()->orderBy('sales', 'desc')->first();
    // }

    public function getStatistics()
    {
        // Lấy tất cả các danh mục với thông tin cần thiết
        return Category::all()->map(function ($category) {
            return [
                'name' => $category->name,
                'active_status' => $category->is_active ? 'Active' : 'Inactive',
            ];
        });
    }
}