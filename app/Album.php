<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    //

    public function Photos()
    {
        return $this->hasMany('App\AlbumPhoto');
    }
}
