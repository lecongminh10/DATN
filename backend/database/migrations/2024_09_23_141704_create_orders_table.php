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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Khóa ngoại liên kết đến bảng Users');
            $table->string('code')->comment('Mã vận chuyển');
            $table->decimal('total_price', 10, 2)->comment('Tổng giá trị đơn hàng');
            $table->unsignedBigInteger('shipping_address_id')->comment('Khóa ngoại liên kết đến bảng Addresses');
            $table->unsignedBigInteger('payment_id')->nullable()->comment('Khóa ngoại liên kết đến bảng Payments'); // Đặt nullable nếu không phải lúc nào cũng cần
            $table->text('note')->nullable()->comment('Ghi chú của người dùng');
            $table->enum('status', ['Chờ xác nhận', 'Đã xác nhận', 'Đang giao', 'Hoàn thành', 'Đã hủy', 'Hàng thất lạc'])->comment('Trạng thái đơn hàng');
            $table->unsignedBigInteger('carrier_id')->nullable()->comment('Khóa ngoại đến bảng carriers (nhà vận chuyển)');
            $table->string('tracking_number')->nullable()->comment('Mã theo dõi của nhà vận chuyển');
        
            $table->foreign('shipping_address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('carrier_id')->references('id')->on('carriers')->onDelete('set null');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
        
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
        Schema::dropIfExists('orders');
    }
};
