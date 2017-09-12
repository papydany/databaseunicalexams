<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignCourse extends Model
{
    //

     public function user()
    {
    	return $this->belongsTo('App\User');
    }

      public function reg_course()
    {
    	return $this->belongsTo('App\RegisterCourse','registercourse_id');
    }
}
