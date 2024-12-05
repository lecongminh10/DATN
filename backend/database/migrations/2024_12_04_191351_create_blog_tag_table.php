<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('blog_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained()->onDelete('cascade');  // Liên kết với bảng blogs
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');   // Liên kết với bảng tags
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_tag');
    }
};
