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
            $table->unsignedBigInteger('id')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('screen_name')->nullable();
            $table->string('photo')->nullable();
            $table->string('secret_key')->nullable();
            $table->boolean('has_secret_key')->default(0);
            $table->boolean('is_sleep')->default(0);
            $table->unsignedInteger('members_count')->default(0);
            $table->unsignedTinyInteger('is_closed')->default(0);
            $table->string('deactivated')->nullable();
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
