<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_methods', function (Blueprint $table) {
            // Adding the shipping_fee column with default value 0.00
            $table->decimal('shipping_fee', 10, 2)->default(0.00)->comment('Phí vận chuyển');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_methods', function (Blueprint $table) {
            // Dropping the shipping_fee column in case we need to rollback
            $table->dropColumn('shipping_fee');
        });
    }
};
