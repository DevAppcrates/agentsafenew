<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationUserStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_user_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notification_id');
            $table->string('user_id');
            $table->integer('sms')->default(0);
            $table->integer('email')->default(0);
            $table->integer('notification')->default(0);
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
        Schema::dropIfExists('notification_user_status');
    }
}
