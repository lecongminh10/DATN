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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('applies_to', 20)->comment('Xác định phạm vi áp dụng (category, product, all)');
            $table->string('code')->unique()->comment('Mã giảm giá (mã định danh duy nhất)');
            $table->string('description')->nullable()->comment('Mô tả mã giảm giá');
            $table->enum('discount_type', ['percentage', 'fixed_amount'])->comment('Loại giảm giá (theo %, số tiền cố định)');
            $table->decimal('discount_value', 10, 2)->comment('Giá trị giảm giá (phần trăm hoặc số tiền cố định)');
            $table->decimal('max_discount_amount', 10, 2)->nullable()->comment('Giảm giá tối đa (nếu là giảm phần trăm)');
            $table->decimal('min_order_value', 10, 2)->nullable()->comment('Giá trị đơn hàng tối thiểu để áp dụng mã');
            $table->timestamp('start_date')->nullable()->comment('Thời gian bắt đầu áp dụng mã giảm giá');
            $table->timestamp('end_date')->nullable()->comment('Thời gian kết thúc áp dụng mã giảm giá');
            $table->integer('usage_limit')->nullable()->comment('Số lần mã có thể được sử dụng (tổng cộng)');
            $table->integer('per_user_limit')->nullable()->comment('Số lần tối đa mỗi người dùng có thể sử dụng mã');
            $table->boolean('is_active')->default(true)->comment('Trạng thái hoạt động của mã (true/false)');
            $table->boolean('is_stackable')->default(false)->comment('Mã có thể dùng chung với mã khác không (true/false)');
            $table->boolean('eligible_users_only')->default(false)->comment('Mã chỉ dành cho một số người dùng được chọn (true/false)');
            $table->unsignedBigInteger('created_by')->comment('ID của người tạo mã giảm giá (liên kết với bảng users hoặc admins)');
          
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
        Schema::dropIfExists('coupons');
    }
};
