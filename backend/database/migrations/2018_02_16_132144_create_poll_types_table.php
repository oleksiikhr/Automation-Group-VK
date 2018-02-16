<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poll_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->boolean('quest_is_answer')->default(0);
	        $table->unsignedTinyInteger('min_count_answers');
	        $table->unsignedTinyInteger('use_count_answers');
            $table->unsignedTinyInteger('max_count_answers');
            $table->string('pattern_answer')->nullable();
            $table->string('pattern_correct_answer')->nullable();
	        $table->softDeletes();
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
        Schema::dropIfExists('poll_types');
    }
}
