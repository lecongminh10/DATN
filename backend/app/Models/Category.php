<?php

namespace App\Models;

use App\Events\CategoryEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory , SoftDeletes;

    protected $dates = ['deleted_at'];

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

    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
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

        // Sự kiện trước khi xóa (deleting)
        static::deleting(function ($category) {
            if (auth()->check()) {
                $user = auth()->user();
                $category->deleted_by = $user->id;
                $category->save();
            }
        });

        // Sự kiện sau khi xóa (deleted)
        static::deleted(function () {
            event(new CategoryEvent());
        });
    }

}