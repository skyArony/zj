<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerRecordsTable extends Migration
{
    /**
     * Run the migrations.
     * 问卷填写记录
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment("问卷填写者");
            $table->unsignedinteger('user_primary_id')->comment("主键联系 ID- 关系绑定用");
            $table->unsignedinteger('survey_id')->comment("问卷 ID");
            $table->json('tags')->comment("问卷结果记录");
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('user_primary_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
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
        Schema::dropIfExists('answer_records');
    }
}
