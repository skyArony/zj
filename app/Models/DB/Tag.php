<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

// 课程 tag
class Tag extends Model
{
    //
    protected $table = 'tags';
    protected $fillable = ['course_id', 'value'];
}
