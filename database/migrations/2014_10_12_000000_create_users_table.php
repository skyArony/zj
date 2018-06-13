<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unique()->comment("用户ID");
            $table->string('name');
            $table->string('email')->unique();
            $table->string('org_id')->comment("所属组织id");
            $table->string('org_avatar')->comment("组织头像");
            $table->string('password');
            $table->text('cookies')->comment("上一次登陆获取的 cookies");
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
