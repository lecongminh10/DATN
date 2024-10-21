<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOriginalPriceToProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            // Thêm cột giá gốc biến thể
            $table->integer('stock')->nullable()->comment('Số lượng tồn kho của biến thể')->change();
            $table->decimal('original_price', 10, 2)->nullable()->after('price_modifier')->comment('Giá gốc của biến thể');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            // Xóa cột giá gốc biến thể nếu rollback migration
            $table->dropColumn('original_price');
        });
    }
}

