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
        Schema::create('shipping_methods', function (Blueprint $table) {
	        $table->id();
            $table->unsignedBigInteger('order_id')->comment('Khóa ngoại liên kết đến bảng Orders');
            $table->unsignedBigInteger('payment_gateway_id')->comment('Khóa ngoại liên kết đến bảng Payment Gateways');
            $table->decimal('amount', 10, 2)->comment('Số tiền thanh toán');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->comment('Trạng thái thanh toán');
            $table->string('transaction_id')->unique()->comment('ID giao dịch từ cổng thanh toán');

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->comment('Liên kết với bảng Orders');
            $table->foreign('payment_gateway_id')->references('id')->on('payment_gateways')->onDelete('cascade')->comment('Liên kết với bảng Payment Gateways');

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
        Schema::dropIfExists('shipping_methods');
    }
};
