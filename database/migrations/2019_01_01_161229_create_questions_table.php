<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment("题干");
            $table->json('option')->comment('选项');
            $table->enum('type', ['radio', 'multi'])->comment('单选或多选');
            $table->enum('level', [1, 2, 3, 4, 5])->comment('难度');
            $table->json('answer')->comment('答案');
            $table->unsignedinteger('tag_id')->comment("知识点");
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
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
        Schema::dropIfExists('questions');
    }
}
