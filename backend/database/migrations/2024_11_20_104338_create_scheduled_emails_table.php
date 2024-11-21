<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduledEmailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('scheduled_emails', function (Blueprint $table) {
            $table->id();
            $table->json('to_email'); // Danh sách email (JSON)
            $table->string('subject');
            $table->text('message');
            $table->timestamp('schedule_date');
            $table->enum('status', ['pending', 'sent'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('scheduled_emails');
    }
}
