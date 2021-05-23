<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    public function fos()
    {
        return $this->belongsTo('App\Fos');
    }

      
}
