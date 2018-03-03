<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCronMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cron_month', function (Blueprint $table) {
            $table->unsignedInteger('cron_id');
            $table->unsignedTinyInteger('month_num');

            $table->foreign('cron_id')->references('id')->on('cron')->onDelete('cascade');

            $table->primary(['cron_id', 'month_num']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cron_month');
    }
}
