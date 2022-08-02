<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitors', function (Blueprint $table) {
            $table->increments('id');
             $table->string('monitor_id')->unique();
            $table->string('monitor_name');
            $table->string('monitor_email')->unique();
            $table->string('password');
            $table->string('phone_number');
            $table->string('address');
            $table->string('status')->default('enabled');
            $table->string('country_id')->nullable();
            $table->text('additional_fields')->nullable();
            $table->string('additional_detail')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('monitors');
    }
}
