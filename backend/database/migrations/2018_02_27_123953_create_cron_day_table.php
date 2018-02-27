<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCronDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cron_day', function (Blueprint $table) {
            $table->unsignedInteger('cron_id');
            $table->unsignedTinyInteger('day_num');

            $table->foreign('cron_id')->references('id')->on('cron')->onDelete('cascade');

            $table->primary(['cron_id', 'day_num']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cron_day');
    }
}
