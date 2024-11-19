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
        Schema::table('coupons_usage', function (Blueprint $table) {
            // Xóa cột category_id
            $table->dropForeign(['category_id']); // Xóa khóa ngoại nếu có
            $table->dropColumn('category_id');    // Xóa cột category_id

            // Thêm cột discount_value
            $table->decimal('discount_value', 10, 2)->nullable()->comment('Giá trị giảm giá')->after('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons_usage', function (Blueprint $table) {
            // Quay lại thay đổi, xóa cột discount_value và khôi phục cột category_id
            $table->dropColumn('discount_value');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
        });
    }
};
