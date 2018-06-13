<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $fillable = ['survey_id', 'desc', 'isMulti', 'option'];
}
