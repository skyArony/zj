<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'surveys';
    protected $fillable = ['course_id', 'course', 'creater_id', 'creater', 'title', 'desc', 'questions'];

    // 关联到 course
    public function belongsToCourse()
    {
        return $this->belongsTo('App\Models\DB\Course', 'course_id', 'course_id');
    }
}
