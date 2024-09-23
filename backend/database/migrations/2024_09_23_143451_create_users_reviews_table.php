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
        Schema::create('users_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned()->checkBetween(1, 5); // Xếp hạng từ 1 đến 5 
            $table->text('review_text')->nullable(); 
            $table->dateTime('review_date')->nullable(); 
            $table->json('images')->nullable(); $table->json('videos')->nullable(); 
            $table->boolean('is_verified')->default(false); 
            $table->integer('helpful_count')->default(0); $table->text('reply_text')->nullable(); 
            $table->dateTime('reply_date')->nullable();

          
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
        Schema::dropIfExists('users_reviews');
    }
};
