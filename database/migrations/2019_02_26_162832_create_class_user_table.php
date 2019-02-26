<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_user', function (Blueprint $table) {
            $table->unsignedinteger('user_id')->comment("用户 ID");
            $table->unsignedinteger('class_id')->comment("班级 ID");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('class')->onDelete('cascade');
            $table->primary(['user_id', 'class_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_user');
    }
}
