<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddressesTable extends Migration
{
    /**
     * Hàm chạy khi thực hiện migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            // Xóa các trường cũ
            $table->dropColumn(['address_line', 'address_line1', 'address_line2']);
            $table->string('specific_address')->nullable()->comment('Địa chỉ cụ thể');
            $table->string('ward')->nullable()->comment('Xã/Phường');
            $table->string('district')->nullable()->comment('Quận/Huyện');
            $table->string('city')->nullable()->comment('Tỉnh/Thành phố');
            $table->boolean('active')->default(true)->comment('Trạng thái hoạt động');
        });
    }

    /**
     * Hàm chạy khi quay lại migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            // Thêm lại các trường cũ
            $table->string('address_line')->nullable()->comment('Địa chỉ dòng cụ thể');
            $table->string('address_line1')->nullable()->comment('Địa chỉ dòng 1');
            $table->string('address_line2')->nullable()->comment('Địa chỉ dòng 2');

            // Xóa các trường mới nếu cần thiết
            $table->dropColumn(['specific_address', 'ward', 'district', 'city']);
        });
    }
}
