<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','plain_password','faculty_id','department_id','fos_id','programme_id','edit_right',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
 public function assigncourse()
    {

        return $this->hasMany('App\AssignCourse');
    }

    

     public function roles()
    {
        return $this->belongsToMany('App\Role','user_roles','user_id', 'role_id');
    }

    public function hasAnyRole($roles)
    {
        if(is_array($roles))
        {
            foreach ($roles as $key => $value) {
               if($this->hasRole($value))
               {
                return true;
               }
            }
        }else{
         if($this->hasRole($roles))
               {
                return true;
               }
        }
        return false;
    }

    public function hasRole($role)
    {
        if($this->roles()->where('name',$role)->first())
        {
            return true;
        }

        return false;
    }
}
