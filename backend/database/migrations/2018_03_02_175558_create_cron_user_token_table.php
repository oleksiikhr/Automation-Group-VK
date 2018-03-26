<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCronUserTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cron_user_token', function (Blueprint $table) {
            $table->unsignedInteger('cron_id');
            $table->unsignedInteger('user_token_id');

            $table->foreign('cron_id')->references('id')->on('cron')->onDelete('cascade');
            $table->foreign('user_token_id')->references('id')->on('user_tokens')->onDelete('cascade');

            $table->primary(['cron_id', 'user_token_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cron_user_token');
    }
}
