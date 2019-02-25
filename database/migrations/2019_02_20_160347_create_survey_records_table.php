<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedinteger('creater_id')->comment("问卷填写者");
            $table->unsignedinteger('course_id')->comment("问卷所属课程");
            $table->json('tags')->comment("问卷填写结果 tag 的 id");
            $table->json('detail')->comment("问卷填写详情");
            $table->foreign('creater_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
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
        Schema::dropIfExists('survey_records');
    }
}
