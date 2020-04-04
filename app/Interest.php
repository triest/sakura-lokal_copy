<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    //
    protected $table = "interests";

    public function girl()
    {
        return $this->belongsToMany('App\Girl', 'girl_interess');
    }

    public function seachSetting()
    {
        return $this->belongsToMany('App\SearchSettings', 'search_interest');
    }
}
