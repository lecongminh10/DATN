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
        Schema::create('customer_support_tickets', function (Blueprint $table) {
            $table->id()->comment('Khóa chính');
            $table->unsignedBigInteger('user_id')->comment('Khóa ngoại liên kết đến bảng Users');
            $table->string('subject')->comment('Chủ đề của phiếu hỗ trợ');
            $table->text('message')->comment('Nội dung tin nhắn hỗ trợ');
            $table->string('status')->comment('Trạng thái của phiếu hỗ trợ');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->comment('Liên kết với bảng Users');

            $table->softDeletes()->comment('Thời gian xóa mềm');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->comment('Người thực hiện xóa mềm');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_support_tickets');
    }
};
