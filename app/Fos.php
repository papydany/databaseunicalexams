<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fos extends Model
{
    //
      public function department()
    {
        return $this->belongsTo('App\Department');
    }

       public function programme()
    {
        return $this->belongsTo('App\Programme');
    }
}
