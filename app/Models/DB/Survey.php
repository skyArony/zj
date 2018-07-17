<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'surveys';
    protected $fillable = ['course_id', 'course', 'creater_id', 'creater', 'title', 'desc', 'questions'];
}
