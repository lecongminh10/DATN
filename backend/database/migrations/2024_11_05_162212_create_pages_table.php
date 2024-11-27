<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id(); // Trường ID tự động tăng
            $table->string('name'); // Tên trang
            $table->string('permalink')->unique(); // Permalink, đảm bảo là duy nhất
            $table->text('description')->nullable(); // Mô tả, có thể để trống
            $table->longText('content'); // Nội dung trang
            $table->boolean('is_active')->default(true)->comment('Cờ kích hoạt hiện , ẩn');
            $table->string('template')->nullable(); // Mẫu trang, có thể để trống
            $table->string('seo_title')->nullable(); // Tiêu đề SEO, có thể để trống
            $table->text('seo_description')->nullable(); // Mô tả SEO, có thể để trống
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
