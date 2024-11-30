<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsUpdateTable extends Migration
{
    public function up()
    {
        // Xóa bảng nếu tồn tại
        Schema::dropIfExists('announcements'); // Đảm bảo rằng tên bảng là 'announcements'

        // Tạo bảng mới
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->integer('discount_percentage');
            $table->string('category');
            $table->dateTime('start_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('end_date');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        // Thêm bản ghi ban đầu vào bảng announcements
       
    }

    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}