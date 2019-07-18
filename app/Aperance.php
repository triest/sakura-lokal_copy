<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aperance extends Model
{
    //
    protected $table = 'appearance';

    public function girls()
    {
        return $this->hasMany('App\Girls', 'apperance_id');
    }
}
