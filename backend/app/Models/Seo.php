<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seo extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'seos';

    protected $fillable = [
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'is_active'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'seo_product')->withTimestamps()->withTrashed();
    }

    public static function checkIfActiveExists(): bool
    {
        return self::where('is_active', 1)->exists();
    }

        /**
     * Lấy giá trị của SEO với điều kiện canonical_url LIKE URL hiện tại
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public static function getSeoByCurrentUrl()
    {
        // Lấy URL hiện tại (chỉ lấy phần path mà không có tham số query)
        $currentUrl = request()->fullUrl();
        $currentUrlWithoutQuery = parse_url($currentUrl, PHP_URL_PATH);

        return self::where('canonical_url', 'like', "%$currentUrlWithoutQuery%")->first();
    }
    // Quan hệ với Post
    // public function post()
    // {
    //     return $this->belongsTo(Post::class);
    // }
}
