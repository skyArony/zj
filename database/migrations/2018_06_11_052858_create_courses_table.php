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
            $table->unsignedinteger('id')->unique()->comment("课程ID");
            $table->unsignedBigInteger('teacher_id')->comment("教师ID");
            $table->string('name')->comment("课程名");
            $table->text('intro')->comment("课程介绍");
            $table->string('pic')->comment("课程图");
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('courses');
    }
}
