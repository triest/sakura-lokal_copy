<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeachSettingsInterest extends Model
{
    protected $table = "settings_table";

    public function settings()
    {
        return $this->hasOne('App\SearchSettings', 'id', 'settings_id');
    }
}
