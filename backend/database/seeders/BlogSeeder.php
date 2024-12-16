<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run()
    {
        Post::create([
            'title' => 'Blog Post 1',
            'content' => 'Nội dung của bài viết 1.',
            'slug' => 'blog-post-1',
            'meta_title' => 'Meta Title 1',
            'meta_description' => 'Meta Description 1',
            'thumbnail' => 'thumbnail1.jpg',
            'user_id' => 1,
            'is_published' => true,
            'published_at' => now(),
        ]);

        Post::create([
            'title' => 'Blog Post 2',
            'content' => 'Nội dung của bài viết 2.',
            'slug' => 'blog-post-2',
            'meta_title' => 'Meta Title 2',
            'meta_description' => 'Meta Description 2',
            'thumbnail' => 'thumbnail2.jpg',
            'user_id' => 1,
            'is_published' => false,
            'published_at' => null,
        ]);
    }
}
