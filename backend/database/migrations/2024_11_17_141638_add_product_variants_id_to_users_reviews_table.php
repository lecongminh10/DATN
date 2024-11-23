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
    Schema::table('users_reviews', function (Blueprint $table) {
        // Thêm cột product_variants_id vào bảng users_reviews
        $table->foreignId('product_variants_id')->nullable()->constrained('product_variants')->onDelete('cascade')->after('product_id')->comment('Biến thể sản phẩm');
    });
}

public function down(): void
{
    Schema::table('users_reviews', function (Blueprint $table) {
        // Xóa cột product_variants_id nếu rollback
        $table->dropColumn('product_variants_id');
    });
}

};
