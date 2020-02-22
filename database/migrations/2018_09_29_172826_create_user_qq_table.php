<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserQqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_qq', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('qq_id');
            $table->JSON('user_info')->comment('用户 QQ 信息');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary('qq_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_qq');
    }
}
