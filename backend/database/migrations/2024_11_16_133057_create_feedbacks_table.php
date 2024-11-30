<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // public function up()
    // {
    //     Schema::create('feedbacks', function (Blueprint $table) {
    //         $table->id('feedback_id');                    // ID tự tăng
    //         $table->foreignId('user_id')->nullable()      // Khóa ngoại tới bảng users
    //             ->constrained('users')
    //             ->onDelete('set null');                // Nếu user bị xóa, đặt user_id = null
    //         $table->string('full_name')->nullable();      // Tên người gửi
    //         $table->string('email')->nullable();          // Email người gửi
    //         $table->string('phone_number')->nullable();   // Số điện thoại
    //         $table->enum('feedback_type', ['Góp ý', 'Khiếu nại', 'Đánh giá', 'Cảm nhận'])
    //             ->default('Góp ý');                    // Loại phản hồi
    //         $table->string('subject');                   // Tiêu đề
    //         $table->text('message');                     // Nội dung phản hồi
    //         $table->tinyInteger('rating')->nullable()    // Điểm đánh giá (1-5)
    //             ->unsigned();

    //         $table->string('subject');
    //         $table->integer('rating')->default(0);
    //         $table->string('attachment_url')->nullable();
    //         $table->timestamp('date_submitted')->useCurrent(); // Thời gian gửi phản hồi
    //         $table->enum('status', ['Chưa xử lý', 'Đang xử lý', 'Đã xử lý'])
    //             ->default('Chưa xử lý');               // Trạng thái xử lý
    //         $table->text('admin_response')->nullable();  // Phản hồi của admin
    //         $table->timestamp('response_date')->nullable();  // Thời gian phản hồi của admin
    //         $table->string('attachment_url')->nullable();    // Đường dẫn tệp đính kèm
    //         $table->timestamps();                         // Thêm created_at và updated_at

    //     });
    // }

    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('address');
            $table->string('feedback_type');
            $table->string('subject');
            $table->text('message');
            $table->integer('rating');
            $table->string('attachment_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }



}
