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
        Schema::create('permissions_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permissions_id')->constrained('permissions')->comment('Khóa ngoại liên kết với bảng permissions');
            $table->string('value')->unique()->comment('Tên giá trị ');
            $table->string('description')->nullable()->comment('Mô tả Value');
        
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
        Schema::dropIfExists('permissions_values');
    }
};
