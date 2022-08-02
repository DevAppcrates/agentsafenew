<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('video_id')->unique();
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('type')->default('panic');
            $table->text('session_token');
            $table->text('opentok_token');
            $table->string('archive_id');
            $table->softDeletes();
            $table->string('status')->default('enabled');
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
        Schema::dropIfExists('videos');
    }
}
