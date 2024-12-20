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
        Schema::create('carts', function (Blueprint $table) {
            $table->id()->comment('Khóa chính');
            $table->unsignedBigInteger('user_id')->comment('Khóa ngoại liên kết đến bảng Users');
            $table->unsignedBigInteger('product_id')->comment('Khóa ngoại liên kết đến bảng Product');
            $table->unsignedBigInteger('product_variants_id')->nullable()->comment('Khóa ngoại liên kết đến bảng ProductVariants');
            $table->integer('quantity')->comment('Số lượng sản phẩm');
            $table->decimal('total_price', 10, 2)->comment('Tổng giá trị giỏ hàng');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_variants_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');


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
        Schema::dropIfExists('carts');
    }
};
