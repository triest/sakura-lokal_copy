<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    //
    protected $table = "view_history";

    public function who()
    {
        return $this->hasOne('App\Girl', 'id', 'who_id');
    }

    public function target()
    {
        return $this->hasOne('App\Girl', 'id', 'girl_id');
    }
}
