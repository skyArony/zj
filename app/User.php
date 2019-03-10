<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'id', 'org_id', 'org_avatar', 'role_id', 'avatar', 'cookies'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'cookies'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function hasManyTeams()
    {
        return $this->hasMany('App\Models\DB\Team', 'creater_id', 'id');
    }

    public function belongsToManyTeams()
    {
        return $this->belongsToMany('App\Models\DB\Team', 'team_member', 'student_id', 'team_id');
    }

    public function belongsToManyClasses()
    {
        return $this->belongsToMany('App\Models\DB\ClassGroup', 'class_user', 'user_id', 'class_id');
    }
   
}
