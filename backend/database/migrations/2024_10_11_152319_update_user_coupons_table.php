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
        Schema::table('user_coupons', function (Blueprint $table) {
            // Thay đổi tên cột từ admin_id thành user_id
            $table->renameColumn('admin_id', 'user_id');

            // Thêm onDelete cascade
            $table->dropForeign(['user_id']); // xóa ràng buộc cũ (nếu có)
            $table->foreign('user_id')->nullable()->constrained('users')->onDelete('cascade')->comment('Khóa ngoại bảng users-người dùng');
        });
    }

    public function down()
    {
        Schema::table('user_coupons', function (Blueprint $table) {
            $table->renameColumn('user_id', 'admin_id');
            $table->dropForeign(['admin_id']); // xóa ràng buộc cũ (nếu có)
            $table->foreign('admin_id')->nullable()->constrained('users')->comment('Khóa ngoại bảng users-người dùng');
        });
    }
};
