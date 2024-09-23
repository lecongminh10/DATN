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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->comment('Khóa ngoại liên kết đến bảng Categories');
            $table->string('name')->comment('Tên sản phẩm');
            $table->text('description')->nullable()->comment('Mô tả chi tiết');
            $table->string('sku')->unique()->comment('Mã SKU');
            $table->decimal('price', 10, 2)->comment('Giá sản phẩm');
            $table->decimal('discount', 10, 2)->nullable()->comment('Giá giảm');
            $table->integer('stock')->comment('Số lượng tồn kho');
            $table->decimal('rating', 3, 2)->nullable()->comment('Điểm đánh giá');
            $table->string('tags')->nullable()->comment('Các thẻ liên quan đến sản phẩm');
            $table->integer('warranty_period')->nullable()->comment('Thời gian bảo hành (tháng)');
            $table->integer('view')->default(0)->comment('Số lượt xem');
            $table->integer('buycount')->default(0)->comment('Số lượng lượt mua');
            $table->integer('wishlistscount')->default(0)->comment('Số lượng lượt yêu thích');
            $table->boolean('is_active')->default(true)->comment('Cờ kích hoạt sản phẩm');
            $table->boolean('is_hotdeal')->default(false)->comment('Trạng thái hot của sản phẩm');
            $table->boolean('is_homeview')->default(false)->comment('Trạng thái hiển thị ra màn hình chủ');
            $table->boolean('is_hotview')->default(false)->comment('Trạng thái lượt xem hiển thị màn hình chính');

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
        Schema::dropIfExists('products');
    }
};
