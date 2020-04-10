<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlbumPhoto extends Model
{
    //
    protected $table = "album_photo";

    public function album()
    {
        return $this->belongsTo('App\Album');
    }
}
