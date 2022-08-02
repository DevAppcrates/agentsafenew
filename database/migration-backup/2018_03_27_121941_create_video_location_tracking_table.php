<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoLocationTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_location_tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->string('video_tracking_id')->unique();
            $table->string('video_id');
            $table->string('user_id');
            $table->foreign('video_id')->references('video_id')->on('videos');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('latitude');
            $table->string('longitude');
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
        Schema::dropIfExists('video_location_tracking');
    }
}
