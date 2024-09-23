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
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->comment('Khóa ngoại liên kết với đơn hàng');
            $table->text('return_reason')->nullable()->comment('Lí do hủy đơn hàng');
            $table->enum('status', ['Yêu cầu', 'Đang xử lý', 'Đã hoàn tất'])->comment('Xác định trạng thái hoàn trả đơn hàng');
            $table->unsignedBigInteger('refund_amount')->comment('Khóa ngoại liên kết với refunds');
            $table->boolean('is_cancelled')->default(false)->comment('Cờ xác nhận đơn hàng bị hủy');
            $table->timestamp('cancelled_at')->nullable()->comment('Thời gian hủy đơn hàng');
 
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('refund_amount')->references('id')->on('refunds')->onDelete('cascade');

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
        Schema::dropIfExists('returns');
    }
};
