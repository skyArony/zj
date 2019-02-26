<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

class ClassGroup extends Model
{
    //
    protected $table = 'class';

    public function setClassNameAttribute($value)
    {
        $this->attributes['className'] = $value;
        $this->attributes['creater_id'] = auth('api')->parseToken()->payload()->get('sub');
    }

    public function belongsToManyUsers()
    {
        return $this->belongsToMany('App\User', 'class_user', 'class_id', 'user_id');
    }
}
