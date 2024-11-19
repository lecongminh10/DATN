<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    // Tên bảng
    protected $table = 'posts';

    // Các thuộc tính có thể được gán
    protected $fillable = [
        'title',
        'content',
        'slug',
        'meta_title',
        'meta_description',
        'thumbnail',
        'user_id',
        'is_published',
        'published_at',
        'deleted_at',
    ];

    // Các thuộc tính sẽ được xem là ngày tháng
    protected $dates = [
        'published_at',
        'deleted_at',
    ];

    
   

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
