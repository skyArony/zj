<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

// 问卷填写记录
class SurveyRecord extends Model
{
    //
    protected $table = 'survey_records';
    protected $fillable = ['id', 'course_id', 'tags', 'creater_id', 'detail'];
}
