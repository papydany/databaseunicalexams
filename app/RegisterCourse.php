<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterCourse extends Model
{
    //
    public function assigncourse()
    {

        return $this->hasMany('App\AssignCourse');
    }
}
