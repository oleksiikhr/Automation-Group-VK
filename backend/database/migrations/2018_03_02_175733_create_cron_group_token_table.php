<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCronGroupTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cron_group_token', function (Blueprint $table) {
            $table->unsignedInteger('cron_id');
            $table->unsignedInteger('group_token_id');

            $table->foreign('cron_id')->references('id')->on('cron')->onDelete('cascade');
            $table->foreign('group_token_id')->references('id')->on('group_tokens')->onDelete('cascade');

            $table->primary(['cron_id', 'group_token_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cron_group_token');
    }
}
