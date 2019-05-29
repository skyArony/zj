<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

// 课题申请
class Request extends Model
{   
    protected $table = 'requests';

    public function setCreaterIdAttribute($value)
    {
        $this->attributes['creater_id'] = auth('api')->parseToken()->payload()->get('sub');
    }

    public function setDetailAttribute($value)
    {
        $this->attributes['status'] = "待检阅";
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['status'] = "待检阅";
    }

    public function setFileAttribute($value)
    {
        $this->attributes['status'] = "待检阅";
    }

    public function setTaskIdAttribute($value)
    {
        $this->attributes['status'] = "待检阅";
    }

    public function setTeamIdAttribute($value)
    {
        $this->attributes['status'] = "待检阅";
    }

    // 关联到 task
    public function belongsToTask()
    {
        return $this->belongsTo('App\Models\DB\Task', 'task_id', 'id');
    }
}
