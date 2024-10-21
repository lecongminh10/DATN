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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->comment('Khóa ngoại liên kết đến bảng Products');
            $table->foreignId('product_attribute_id')->constrained('attributes_values')->onDelete('cascade')->comment('Khóa ngoại liên kết với bảng attribute_value');
            $table->decimal('price_modifier', 10, 2)->nullable()->comment('Giá thay đổi do biến thể');
            $table->integer('stock')->comment('Số lượng tồn kho của biến thể');
            $table->string('sku')->unique()->comment('Mã SKU của biến thể');
         
            $table->enum('status', ['available', 'out_of_stock', 'discontinued'])->default('available')->comment('Trạng thái của biến thể');
            $table->text('variant_image')->nullable()->comment('Ảnh của biến thể sản phẩm');
            
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
        Schema::dropIfExists('product_variants');
    }
};
