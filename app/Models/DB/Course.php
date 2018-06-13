<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
    protected $table = 'courses';
    protected $fillable = ['course_id', 'name', 'intro', 'pic', 'teacher', 'teacher_id'];
}
