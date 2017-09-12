<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
	 protected $connection = 'mysql2';
    public function pdguser()
    {

        return $this->belongsTo('App\PdgUser');
    }
}
