<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

// 课程
class Course extends Model
{
    //
    // protected $primary = 'course_id';
    protected $table = 'courses';
    protected $fillable = ['id', 'name', 'intro', 'pic', 'teacher_id'];

    // 模型关联
    public function hasOneCourseTree()
    {
        return $this->hasOne('App\Models\DB\CourseTree', 'course_id', 'id');
    }

    public function belongsToUser()
    {
        return $this->hasOne('App\User', 'id', 'teacher_id');
    }

    public function hasManySurveys()
    {
        return $this->hasMany('App\Models\DB\Survey', 'course_id', 'id');
    }

    public function hasManyQuestionsThroughTag()
    {
        return $this->hasManyThrough('App\Models\DB\Question', 'App\Models\DB\Tag', 'course_id', 'tag_id', 'id', 'id');
    }

}
