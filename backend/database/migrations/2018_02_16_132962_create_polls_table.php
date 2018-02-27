<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quest')->nullable();
	        $table->unsignedBigInteger('user_id')->nullable();
	        $table->unsignedInteger('type_id');
	        $table->date('published_at')->nullable();
	        $table->softDeletes();
            $table->timestamps();

	        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('type_id')->references('id')->on('poll_types')->onDelete('cascade');

	        $table->index('user_id');
            $table->index('type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polls');
    }
}
