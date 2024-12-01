<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id(); // Tự động tạo khóa chính với auto-increment
            $table->string('full_name'); // Họ và tên
            $table->string('email'); // Email
            $table->string('phone_number'); // Số điện thoại
            $table->string('address'); // Địa chỉ
            $table->string('feedback_type'); // Loại phản hồi
            $table->string('subject'); // Chủ đề
            $table->text('message'); // Nội dung phản hồi
            $table->integer('rating'); // Đánh giá (rating)
            $table->string('attachment_url')->nullable(); // Đường dẫn file đính kèm (nullable)
            $table->timestamps(); // Tự động thêm cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
};
