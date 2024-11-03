<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Thêm cột promotion_end_time vào bảng products
        Schema::table('products', function (Blueprint $table) {
            $table->timestamp('promotion_end_time')->nullable()->comment('Thời gian kết thúc khuyến mãi cho sản phẩm');
        });

        // Thêm cột promotion_end_time vào bảng product_variants
        Schema::table('product_variants', function (Blueprint $table) {
            $table->timestamp('promotion_end_time')->nullable()->comment('Thời gian kết thúc khuyến mãi cho biến thể sản phẩm');
        });
    }

    public function down()
    {
        // Xóa cột promotion_end_time khỏi bảng products
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('promotion_end_time');
        });

        // Xóa cột promotion_end_time khỏi bảng product_variants
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('promotion_end_time');
        });
    }
};
