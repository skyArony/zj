<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->unique()->comment("课程ID");
            $table->string('name')->comment("课程名");
            $table->text('intro')->comment("课程介绍");
            $table->string('pic')->comment("课程图");
            $table->string('teacher')->comment("课程教师");
            $table->integer('teacher_id')->comment("教师ID");
            $table->foreign('teacher_id')->references('user_id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('courses');
    }
}
