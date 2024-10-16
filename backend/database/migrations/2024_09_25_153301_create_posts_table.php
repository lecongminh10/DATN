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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Tiêu đề bài viết')->index();
            $table->text('content')->comment('Nội dung bài viết');
            $table->string('slug')->unique()->comment('Slug cho bài viết, sử dụng trong URL');
            $table->string('meta_title')->nullable()->comment('Tiêu đề SEO của bài viết');
            $table->text('meta_description')->nullable()->comment('Mô tả SEO của bài viết');
            $table->string('thumbnail')->nullable()->comment('Đường dẫn đến hình ảnh đại diện của bài viết');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('Người thực hiện viết bài');
            $table->boolean('is_published')->default(false)->comment('Trạng thái xuất bản bài viết');
            $table->timestamp('published_at')->nullable()->comment('Thời gian xuất bản bài viết');
            $table->softDeletes()->comment('Thời gian xóa mềm');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
