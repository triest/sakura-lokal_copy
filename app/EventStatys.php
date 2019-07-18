<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventStatys extends Model
{
    //
    protected $table = "event_statys";

    public function events()
    {
        return $this->hasMany('App\Myevent');
    }
}
