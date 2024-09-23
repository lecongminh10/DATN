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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->comment('Khóa ngoại liên kết đến bảng Orders');
            $table->unsignedBigInteger('product_id')->comment('Khóa ngoại liên kết đến bảng Products');
            $table->unsignedBigInteger('variant_id')->nullable()->comment('Khóa ngoại liên kết đến bảng Product_Variants');
            $table->integer('quantity')->comment('Số lượng sản phẩm');
            $table->decimal('price', 10, 2)->comment('Giá sản phẩm tại thời điểm mua');
            $table->decimal('discount', 10, 2)->nullable()->comment('Giảm giá áp dụng cho chi tiết đơn hàng');

            // Foreign keys
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('set null');

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
        Schema::dropIfExists('order_items');
    }
};
