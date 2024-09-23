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
        Schema::create('product_galaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->comment('Khóa ngoại liên kết đến bảng Products');
            $table->string('image_gallery')->comment('hình ảnh biến thể' );
            $table->boolean('is_main')->default(false)->comment('Chờ xác định hình ảnh chính');
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
        Schema::dropIfExists('product_galaries');
    }
};
