<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

class SurveyRecord extends Model
{
    //
    protected $table = 'survey_records';
    protected $fillable = ['id', 'course_id', 'tags', 'creater_id'];
}
