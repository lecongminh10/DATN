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
        Schema::table('banner_extra', function (Blueprint $table) {
            $table->decimal('price_1', 10, 2)->nullable()->after('image_3');
            $table->decimal('price_2', 10, 2)->nullable()->after('price_1');
            $table->decimal('price_3', 10, 2)->nullable()->after('price_2');
            $table->string('title_button_1')->nullable()->after('price_3');
            $table->string('title_button_2')->nullable()->after('title_button_1');
            $table->string('title_button_3')->nullable()->after('title_button_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banner_extra', function (Blueprint $table) {
            $table->dropColumn(['price_1', 'price_2', 'price_3', 'title_button_1', 'title_button_2', 'title_button_3']);
        });
    }
};
