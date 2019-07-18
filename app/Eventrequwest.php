<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Girl;

class Eventrequwest extends Model
{
    //
    protected $table = "event_requwest";

    public function who()
    {
        return $this->hasOne('App\Girl', 'girl_id', 'id');
    }

    public function target()
    {
        return $this->hasOne('App\Myevent', 'event_id', 'id');
    }
}
