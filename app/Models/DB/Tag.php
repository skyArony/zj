<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $table = 'tags';
    protected $fillable = ['course_id', 'value'];
}
