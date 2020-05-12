<?php

namespace App;

use App\Http\Controllers\AnketController;
use App\Http\Controllers\GirlsController;
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
        return $this->belongsTo('App\Girl');
    }

    public function target()
    {
        return $this->belongsToMany('App\Target', 'search_target',
            'search_id', 'target_id');
    }

    public function interest()
    {
        return $this->belongsToMany('App\Interest', 'search_interest',
            'search_id',
            'interest_id');
    }

    public static function getSeachSettings()
    {
        $cookie = null;
        $userAuth = Auth::user();
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

                if ($seachSettings != null) {
                    return $seachSettings;
                } else {
                    $seachSettings = new SearchSettings();
                    $seachSettings->save();
                    $anket->seachsettings()->save($seachSettings);

                    return $seachSettings;
                    //   $anket->target()->attach($seachSettings);
                }
            } else {
                if (!isset($_COOKIE["seachSettings"])) {
                    $_COOKIE["seachSettings"]
                        = AnketController::randomString(64);
                }
                $cookie = $_COOKIE["seachSettings"];
                $seachSettings = SearchSettings::select(['id'])
                    ->where("cookie", "=", $cookie)
                    ->orderBy('created_at', 'desc')
                    ->first();
                if ($seachSettings != null) {
                    return $seachSettings;
                }
            }
        } else {


            if (isset($_COOKIE["seachSettings"])
                && $_COOKIE["seachSettings"] != null
            ) {
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
                    ''
                ])
                    ->orderBy('created_at', 'desc')
                    ->where("cookie", "=", $_COOKIE["seachSettings"])->first();

                if ($seachSettings == null) {

                    $seachSettings = new SearchSettings();
                    $seachSettings->cookie = $_COOKIE["seachSettings"];
                    $seachSettings->save();

                    return $seachSettings;
                }

                return $seachSettings;
            } else {


                $cookie = AnketController::randomString(100);

                $seachSettings = new SearchSettings();
                $seachSettings->cookie = $cookie;
                $seachSettings->save();
                Cookie::queue("seachSettings", $cookie, 6000);

                return $seachSettings;
            }
        }


    }
}
