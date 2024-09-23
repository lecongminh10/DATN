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
        // id integer [primary key, note: 'Khóa chính']
        // user_id integer [not null, note: 'Khóa ngoại liên kết đến bảng Users']
        // address_line1 varchar [not null, note: 'Địa chỉ dòng 1']
        // address_line2 varchar [note: 'Địa chỉ dòng 2']
        // city varchar [not null, note: 'Thành phố']
        // state varchar [note: 'Bang/Tỉnh']
        // zip_code varchar [not null, note: 'Mã bưu điện']
        // country varchar [not null, note: 'Quốc gia']
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->comment('Khóa ngoại liên kết với Users');
            $table->string('address_line')->nullable()->comment('Địa chỉ dòng cụ thể');
            $table->string('address_line1')->nullable()->comment('Địa chỉ dòng 1');
            $table->string('address_line2')->nullable()->comment('Địa chỉ dòng 2');

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
        Schema::dropIfExists('addresses');
    }
};
