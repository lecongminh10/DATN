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
        Schema::create('banner_extra', function (Blueprint $table) {
            $table->id();
            $table->string('title_1')->nullable();
            $table->string('title_2')->nullable();
            $table->string('title_3')->nullable();
            $table->string('image_1')->nullable();
            $table->string('image_2')->nullable();
            $table->string('image_3')->nullable();
            // $table->decimal('price_1', 10, 2)->nullable();
            // $table->decimal('price_2', 10, 2)->nullable();
            // $table->decimal('price_3', 10, 2)->nullable();
            // $table->string('title_button_1')->nullable();
            // $table->string('title_button_2')->nullable();
            // $table->string('title_button_3')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_extra');
    }
};
