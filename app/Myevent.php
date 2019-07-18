<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Myevent extends Model
{
    //
    protected $table = "myevents";


    //организатор
    public function organizer()
    {
        return $this->hasOne('App\Girl');
    }

    //учстники
    public function girls()
    {
        //return $this->hasMany('App\Girl');
        return $this->belongsToMany('App\Girl' );
    }

    //фотографии
    public function photo()
    {
        return $this->hasMany('App\EventPhoto');
    }

    public function count_participant()
    {
        //return 1;
        $particant = $this->participant;

        return $particant;
    }
}
