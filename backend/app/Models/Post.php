<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'posts';
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
        'deleted_by'
    ];

    protected $casts = [
        'published_at',
        'deleted_at',
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với Tag qua bảng trung gian post_tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags', 'post_id', 'tag_id');
    }

    
}
