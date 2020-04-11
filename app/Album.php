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


    public function getCover()
    {
        $item = $this->Photos()->first();
        if ($item != null) {
            return $item->photo_name;
        } else {
            return "no_avatar.gif";
        }
    }

    public function coutPhotos()
    {
        return $this->Photos()->count();
    }
}
