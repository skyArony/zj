<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('surveys', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->unsignedinteger('course_id')->comment("所属课程ID");
        //     $table->unsignedBigInteger('creater_id')->comment("创建者ID");
        //     $table->string('title')->comment("问卷名");
        //     $table->string('desc')->comment("问卷介绍");
        //     $table->json('questions')->comment("所有问题");
        //     $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        //     $table->foreign('creater_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->timestamps();
        //     $table->softDeletesTz();    // 软删除
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}
