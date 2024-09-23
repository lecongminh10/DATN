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
        Schema::create('carriers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('Tên nhà vận chuyển');
            $table->string('api_url', 255)->nullable()->comment('URL API của nhà vận chuyển');
            $table->string('api_token', 255)->nullable()->comment('Token API của nhà vận chuyển');
            $table->string('phone', 15)->nullable()->comment('Số điện thoại của nhà vận chuyển');
            $table->string('email', 255)->nullable()->comment('Email của nhà vận chuyển');
            $table->enum('is_active', ['active', 'inactive'])->comment('Trạng thái của nhà cung cấp vận chuyển');
            
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
        Schema::dropIfExists('carriers');
    }
};
