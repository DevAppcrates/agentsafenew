<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationDeleteUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('del_notification_user', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('notification_id')->unsigned()->nullable();
            $table->foreign('notification_id')->references('id')->on('notifications')->onDelete('cascade');
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('del_notification_user');
    }
}
