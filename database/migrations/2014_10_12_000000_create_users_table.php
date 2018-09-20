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
            $table->unsignedinteger('id')->unique()->comment("用户ID");
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 11)->default(null)->unique()->comment("手机号");
            $table->string('QQ', 20)->default(null)->unique()->comment("QQ号");
            $table->string('org_id')->comment("所属组织id");
            $table->string('org_avatar')->comment("组织头像");
            $table->string('password');
            $table->text('cookies')->comment("上一次登录获取的 cookies");
            $table->rememberToken();
            $table->timestamps();
            $table->primary('id');
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
