<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

// 课程树
class CourseTree extends Model
{
    //
    protected $table = 'course_trees';
    protected $fillable = ['course_id', 'data'];
}
