<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTokenPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_token_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_token_id');
            $table->string('permission');

            $table->foreign('user_token_id')->references('id')->on('user_tokens')->onDelete('cascade');

            $table->index('user_token_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_token_permissions');
    }
}
