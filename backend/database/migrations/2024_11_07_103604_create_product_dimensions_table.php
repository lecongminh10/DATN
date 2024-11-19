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
        Schema::create('product_dimensions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');  // Khóa ngoại liên kết với bảng products
            $table->integer('height');  // Chiều cao (mm)
            $table->integer('length');  // Chiều dài (mm)
            $table->integer('weight');  // Trọng lượng (gram)
            $table->integer('width');   // Chiều rộng (mm)
            $table->timestamps();

            // Khóa ngoại tham chiếu đến bảng products
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_dimensions');
    }
};
