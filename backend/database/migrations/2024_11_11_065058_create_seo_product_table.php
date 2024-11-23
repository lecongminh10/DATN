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
        Schema::create('seo_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seo_id')->constrained('seos')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->softDeletes()->comment('Thời gian xóa mềm');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete()->comment('Người thực hiện xóa mềm');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_product');
    }
};
