<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('image')->nullable()->after('content')->comment('Hình ảnh của trang');
        });
    }

    /**
     * Thực hiện rollback, xóa cột vừa thêm.
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
