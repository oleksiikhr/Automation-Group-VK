<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('screen_name')->nullable();
            $table->string('photo_100')->nullable();
            $table->string('secret_key')->nullable();
            $table->boolean('has_secret_key')->default(0);
            $table->boolean('deactivated')->default(0);
            $table->integer('vk_users')->default(0);
            $table->boolean('vk_closed')->default(0);
            $table->boolean('vk_blocked')->default(0);
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
        Schema::dropIfExists('groups');
    }
}
