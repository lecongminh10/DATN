<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoogleAndFacebookIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->unique()->nullable()->after('email'); 
            $table->string('facebook_id')->unique()->nullable()->after('google_id'); 
            $table->string('github_id')->unique()->nullable()->after('facebook_id'); // Chỉnh sửa để đặt sau facebook_id
            $table->string('twitter_id')->unique()->nullable()->after('github_id'); // Chỉnh sửa để đặt sau github_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_id');
            $table->dropColumn('facebook_id');
        });
    }
}
