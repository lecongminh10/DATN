<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('info_boxes', function (Blueprint $table) {
        $table->id();
        $table->string('description_shopping')->nullable();
        $table->string('description_money')->nullable();
        $table->string('description_support')->nullable();
        $table->string('title1')->nullable();
        $table->string('title2')->nullable();
        $table->string('title3')->nullable();
        $table->boolean('active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_boxes');
    }
};
