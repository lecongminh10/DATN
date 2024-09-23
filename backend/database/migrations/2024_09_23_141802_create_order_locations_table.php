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
        Schema::create('order_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->comment('Khóa ngoại liên kết đến bảng Orders, xác định đơn hàng tương ứng với địa điểm này.');
            $table->string('address', 255)->comment('Địa chỉ giao hàng cụ thể, nơi mà đơn hàng sẽ được giao đến.');
            $table->string('city', 100)->comment('Thành phố nơi địa điểm giao hàng nằm.');
            $table->string('district', 100)->comment('Quận/huyện nơi địa điểm giao hàng nằm.');
            $table->string('ward', 100)->nullable()->comment('Xã/phường nơi địa điểm giao hàng nằm (nếu có).');
            $table->decimal('latitude', 9, 6)->nullable()->comment('Vĩ độ của địa điểm giao hàng, hữu ích cho việc xác định vị trí chính xác trên bản đồ.');
            $table->decimal('longitude', 9, 6)->nullable()->comment('Kinh độ của địa điểm giao hàng, hữu ích cho việc xác định vị trí chính xác trên bản đồ.');

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

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
        Schema::dropIfExists('order_locations');
    }
};
