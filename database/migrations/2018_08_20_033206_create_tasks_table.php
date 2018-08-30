<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     * 教师课题表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedinteger('creater_id')->comment("创建者");
            $table->string('title')->comment("课程标题");
            $table->string('desc')->comment("课程简介");
            $table->text('detail')->comment("课程详情");
            $table->text('file')->nullable()->coment("附件");
            $table->timestamp('regist_end_at')->coment("组队截止时间");
            $table->timestamp('submit_end_at')->coment("成果提交终止时间");
            $table->foreign('creater_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
