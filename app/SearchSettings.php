<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class SearchSettings extends Model
{
    //
    protected $table = "seach_settings";

    public function girl()
    {
        return $this->hasOne('App\Girl', 'id', 'girl_id');
    }

    public function target()
    {
        //return $this->hasOne('App\Target');
        return $this->belongsToMany('App\Target', 'search_target',
            'search_id', 'target_id');
    }

    public function interest()
    {
        //return $this->hasOne('App\Target');
        return $this->belongsToMany('App\Interest', 'search_interest',
            'search_id',
            'interest_id');
    }

    public static function getSeachSettings()
    {
        $cookie = null;
        $userAuth = Auth::user();
        dump($userAuth);
        if ($userAuth != null) {
            $user = User::select(['id', 'name'])
                ->where('id', $userAuth->id)->first();

            //сли не авторизован, то смотрим по кукам.
            if ($user != null) {
                $anket = Girl::select(['id', 'name'])
                    ->where('user_id', $user->id)
                    ->first();
                if ($anket == null) {
                    return false;
                }
                $seachSettings = $anket->seachsettings()->first();
            } else {

                $cookie = Cookie::get('seachSettings');
                $seachSettings = SearchSettings::select(['id'])
                    ->where("cookie", "=", $cookie)->first();
                if ($seachSettings != null) {
                    return $seachSettings;
                }
            }
        } else {
            $cookie = Cookie::get('seachSettings');
            if ($cookie != null) {
                $seachSettings = SearchSettings::select([
                    'id',
                    'girl_id',
                    'cookie',
                    'target_array',
                    'interest_array',
                    'meet',
                    'age_to',
                    'age_from',
                    'children',
                ])
                    ->where("cookie", "=", $cookie)->first();

                if ($seachSettings == null) {
                    $seachSettings = new SearchSettings();
                    $seachSettings->cookie = $cookie;
                    $seachSettings->save();

                    return $seachSettings;
                }

                return $seachSettings;
            } else {
                $seachSettings = new SearchSettings();
                $seachSettings->save();

                return $seachSettings;
            }
        }


    }
}
