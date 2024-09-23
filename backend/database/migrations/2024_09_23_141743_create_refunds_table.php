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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->comment('Khóa ngoại bảng users-người dùng');
            $table->foreignId('order_id')->nullable()->constrained('orders')->comment('Khóa ngoại bảng orders');
            $table->foreignId('product_id')->nullable()->constrained('products')->comment('Khóa ngoại bảng products');
            $table->foreignId('admin_id')->nullable()->constrained('users')->comment('Khóa ngoại bảng users-admin');
            $table->integer('quantity')->comment('Số lượng sản phẩm yêu cầu hoàn trả');
            $table->decimal('amount', 10, 2)->comment('Số tiền hoàn trả cho sản phẩm này');
            $table->string('refund_method')->comment('Phương thức hoàn tiền (ví dụ: Chuyển khoản ngân hàng, Ví điện tử, v.v.)');
            $table->text('reason')->nullable()->comment('Lý do hoàn trả sản phẩm');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending')->comment('Trạng thái của yêu cầu hoàn tiền');
            $table->timestamp('requested_at')->useCurrent()->comment('Thời gian yêu cầu hoàn tiền');
            $table->timestamp('processed_at')->nullable()->comment('Thời gian hoàn tiền được xử lý');
            $table->text('rejection_reason')->nullable()->comment('Lý do từ chối yêu cầu hoàn tiền, nếu có');

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
        Schema::dropIfExists('refunds');
    }
};
