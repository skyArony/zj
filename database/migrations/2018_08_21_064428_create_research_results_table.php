<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearchResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedinteger('team_id')->comment("所属队伍");
            $table->unsignedinteger('task_id')->comment("所属课题");
            $table->string('title')->comment("成果标题");
            $table->string('desc')->comment("成果简介");
            $table->text('detail')->comment("成果详情");
            $table->text('file')->coment("附件");
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
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
        Schema::dropIfExists('research_results');
    }
}
