<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cookie;

class Team extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $table = 'teams';

    public function setTeamNameAttribute($value)
    {
        $this->attributes['team_name'] = $value;
        $this->attributes['creater_id'] = Cookie::get('id');
    }

    public function belongsToUser()
    {
        return $this->belongsTo('App\User', 'creater_id', 'id');
    }

    public function belongsToManyTasks()
    {
        return $this->belongsToMany('App\Models\DB\Task', 'team_task', 'team_id', 'task_id');
    }
}
