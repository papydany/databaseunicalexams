<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    // 
    public function fos()
    {
        return $this->hasMany('App\Fos');
    }

      
}
