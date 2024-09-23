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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id()->comment('Khóa chính');
            $table->string('name')->comment('Tên cổng thanh toán');
            $table->string('api_key')->comment('Khóa API để kết nối với cổng thanh toán');
            $table->string('secret_key')->comment('Khóa bí mật để kết nối với cổng thanh toán');
            $table->string('gateway_type')->nullable()->comment('Loại cổng thanh toán');

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
        Schema::dropIfExists('payment_gateways');
    }
};
