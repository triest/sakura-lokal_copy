<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SearchSettings extends Model
{
    //
    protected $table = "seach_settings";

    public function girl()
    {
        return $this->hasOne('App\Girl', 'id', 'girl_id');
    }
}
