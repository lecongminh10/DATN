<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Thêm các trường SEO vào bảng products
        Schema::table('products', function (Blueprint $table) {
            $table->string('meta_keywords')->nullable()->comment('Từ khóa SEO của sản phẩm');
            $table->string('canonical_url')->nullable()->comment('URL chuẩn của sản phẩm');
        });

        // Thêm các trường SEO vào bảng posts
        Schema::table('posts', function (Blueprint $table) {
            $table->string('meta_keywords')->nullable()->comment('Từ khóa SEO của bài viết');
            $table->string('canonical_url')->nullable()->comment('URL chuẩn của bài viết');
        });
    }

    public function down(): void
    {
        // Xóa các trường SEO khỏi bảng products
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['slug', 'meta_title', 'meta_description', 'meta_keywords', 'canonical_url']);
        });

        // Xóa các trường SEO khỏi bảng posts
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['slug', 'meta_title', 'meta_description', 'meta_keywords', 'canonical_url']);
        });
    }
};
