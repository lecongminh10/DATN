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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('payment_gateway_id');
            $table->bigInteger('amount');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded']);
            $table->string('transaction_id')->unique();
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
        Schema::dropIfExists('payments');
    }
};
