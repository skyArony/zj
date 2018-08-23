<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

class AnswerRecord extends Model
{
    //
    protected $table = 'answer_records';
    protected $fillable = ['id', 'survey_id', 'tags', 'creater_id'];

    // 关联到 survey
    public function belongsToSurvey()
    {
        return $this->belongsTo('App\Models\DB\Survey', 'survey_id', 'id');
    }
}
