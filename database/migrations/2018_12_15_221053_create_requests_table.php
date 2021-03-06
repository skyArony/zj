<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedinteger('team_id')->comment("所属队伍");
            $table->unsignedinteger('task_id')->comment("所属课题");
            $table->unsignedBigInteger('creater_id')->comment("创建者ID");
            $table->string('title')->comment("申请书标题");
            $table->text('detail')->comment("申请书详情");
            $table->text('file')->nullable()->coment("附件");
            $table->enum('status', ["通过", "未通过", "待检阅"])->default("待检阅")->coment("状态:1表示通过,-1表示未通过,0表示待检阅");
            $table->string('comment', 1000)->nullable()->comment("评语");
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('creater_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('request');
    }
}
