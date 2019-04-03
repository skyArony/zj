<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearchResultRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_result_records', function (Blueprint $table) {
            $table->unsignedinteger('id')->unique()->comment("课程ID");
            $table->unsignedinteger('team_id')->nullable()->comment("所属队伍");
            $table->unsignedinteger('task_id')->nullable()->comment("所属课题");
            $table->unsignedinteger('creater_id')->nullable()->comment("创建者ID");
            $table->string('title')->comment("成果标题");
            $table->string('desc')->comment("成果简介");
            $table->text('detail')->comment("成果详情");
            $table->text('file')->nullable()->coment("附件");
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
        Schema::dropIfExists('research_result_records');
    }
}
