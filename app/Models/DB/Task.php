<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cookie;

class Task extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $table = 'tasks';
    
    public function setCreaterIdAttribute($value)
    {
        $this->attributes['creater_id'] = auth('api')->parseToken()->payload()->get('sub');
    }

    public function belongsToManyTeams()
    {
        return $this->belongsToMany('App\Models\DB\Team', 'team_task', 'task_id', 'team_id');
    }

    public function belongsToUser()
    {
        return $this->belongsTo('App\User', 'creater_id', 'id');
    }
}
