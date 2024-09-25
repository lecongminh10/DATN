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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique()->comment('Tên đăng nhập');
            $table->string('email')->unique()->comment('Email');
            $table->string('password')->comment('Mật khẩu (đã mã hóa)');
            $table->string('language')->nullable()->comment('Ngôn ngữ ưu tiên');
            $table->string('currency')->nullable()->comment('Tiền tệ ưu tiên');
            $table->integer('loyalty_points')->default(0)->comment('Điểm khách hàng thân thiết');
            $table->boolean('is_verified')->default(false)->comment('Cờ xác nhận email');
            $table->string('profile_picture')->nullable()->comment('URL hình ảnh hồ sơ');
            $table->date('date_of_birth')->nullable()->comment('Ngày sinh');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->comment('Giới tính');
            $table->string('phone_number', 11)->unique()->nullable()->comment('Số điện thoại');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->comment('Trạng thái tài khoản');

            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable()->comment('Thời gian xác nhận email');
            $table->timestamp('last_login_at')->nullable()->comment('Thời gian đăng nhập cuối');
            $table->foreignId('created_by')->nullable()->constrained('users')->comment('Người tạo tài khoản');
            $table->foreignId('updated_by')->nullable()->constrained('users')->comment('Thời gian cập nhật tài khoản');
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
        Schema::dropIfExists('users');
    }
};
