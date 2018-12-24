<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    //
    protected $table = 'requests';
    // protected $fillable = ['survey_id', 'desc', 'isMulti', 'option'];

    public function setCreaterIdAttribute($value)
    {
        $this->attributes['creater_id'] = auth('api')->parseToken()->payload()->get('sub');
    }

    // 关联到 task
    public function belongsToTask()
    {
        return $this->belongsTo('App\Models\DB\Task', 'task_id', 'id');
    }
}
