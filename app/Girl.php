<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use App\Myevent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Girl extends Model
{
    //
    protected $fillable
        = [
            'name',
            'description',
            'sex',
            'ptivate',
            'phone_settings',
            'views_all',
            'user_id',
            'filter_enable',
        ];


    public static function get($id)
    {
        $anket = Girl::select(['*'])
            ->where('id', $id)
            ->first();

        return $anket;
    }

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function privatephotos()
    {
        return $this->hasMany('App\Privatephoto');
    }


    public function albums()
    {
        return $this->hasMany('App\Album');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function seachsettings()
    {
        return $this->hasOne('App\SearchSettings');
    }

    public function target()
    {
        //return $this->hasOne('App\Target');
        return $this->belongsToMany('App\Target', 'girl_target', 'girl_id',
            'target_id');
    }

    public function aperance()
    {
        //return $this->hasOne('App\Target');
        return $this->belongsTo('App\Aperance');

    }

    public function interest()
    {
        //return $this->hasOne('App\Target');
        return $this->belongsToMany('App\Interest', 'girl_interess', 'girl_id');
    }

    public function like()
    {
        return $this->hasOne('App\Girl');
    }

    public function eventorganizer()
    {
        return $this->hasMany('App\Myevent');
    }

    public function events()
    {
        return $this->belongsToMany('App\Myevent');
    }

    public function eventreq()
    {
        return $this->belongsToMany('App\Eventrequwest');
    }

    public function children()
    {
        return $this->belongsTo('App\Children');
    }

    public function relation()
    {
        return $this->belongsTo('App\Relationh');
    }

    public function city()
    {
        $temp = $this->hasOne('App\City', 'id', 'user_id');

        return $temp;
    }


    public function getCity()
    {
        return $city = DB::table('cities')->where('id_city', $this->city_id)
            ->first();
    }

    public function getRegion($city)
    {
        $region = DB::table('regions')
            ->where('id_region', $city->id_region)->first();

        return $region;
    }

    public function updateMainImage($request)
    {
        $image_new_name = $this->main_image;
        $temp_file = base_path().'/public/images/upload/'
            .strtolower($image_new_name);// кладем файл с новыс именем
        $request->file('file')
            ->move(base_path().'/public/images/upload/',
                strtolower($image_new_name));
        $origin_size = getimagesize($temp_file);
        $this['main_image'] = $image_new_name;
        $small = base_path().'/public/images/small/'
            .strtolower($image_new_name);
        copy($temp_file, $small);
        $image = new ImageResize($small);
        $image->resizeToHeight(300);
        $this->save();
    }

    public function lastLoginFormat()
    {
        $last_login = $this->last_login;
        if ($this->last_login == null) {
            return "";
        }
        $mytime = Carbon::now();
        $last_login = Carbon::createFromFormat('Y-m-d H:i:s', $last_login);
        $datediff = date_diff($last_login, $mytime);
        if ($datediff->y == 0 && $datediff->m == 0 && $datediff->d == 0) {
            if ($datediff->h < 1) {
                $last_login = "менее часа назад";
            } elseif ($datediff->h == 1) {
                $last_login = "час назад";
            } elseif (($datediff->h > 1 && $datediff->h <= 4)
                || ($datediff->h >= 22 && $datediff->h <= 23)
            ) {
                $last_login = $datediff->h." часа назад";
            } elseif ($datediff->h >= 5 && $datediff->h <= 20) {
                $last_login = $datediff->h." часов назад";
            } elseif ($datediff->h == 21) {
                $last_login = $datediff->h." час назад";
            }
        } elseif ($datediff->y == 0 && $datediff->m == 0 && $datediff->d > 0) {
            if ($datediff->d == 1) {
                $last_login = "вчера";
            } elseif ($datediff->d < 7) {
                $last_login = $datediff->d." дня назад";
            } elseif ($datediff->d >= 7 && $datediff->d <= 13) {
                $last_login = "неделю назад";
            } elseif ($datediff->d > 13) {
                $last_login = "две недели назад";
            } elseif ($datediff->d > 21) {
                $last_login = "три недели назад";
            }
        } elseif ($datediff->y == 0 && $datediff->m == 1) {
            $last_login = "месяц назад";
        } elseif ($datediff->y == 0 && $datediff->m > 1) {
            $last_login = $datediff->m."месяцев назад";
        } elseif ($datediff->y >= 1) {
            $last_login = "давно";
        }

        return $last_login;
    }

    /**
     * Check is user online.
     *
     * @return bool
     */
    public function isOnline()
    {
        $user = $this->user()->first();

        if ($user) {
            return $user->isOnline();
        } else {
            return null;
        }
        //return Cache::has('user-is-online-'.$this->id);
    }

    public function newLike()
    {

        $user = Auth::user();

        if ($user == null) {
            return false;
        }

        $whoGirl = Girl::select([
            'name',
            'id',
            'description',
            'main_image',
            'sex',
            'meet',
            'weight',
            'height',
            'age',
            'country_id',
            'region_id',
            'city_id',
            'banned',
            'user_id',
            'status',
        ])->where('user_id', $user->id)->first();

        if ($whoGirl == null) {
            return false;
        }

        $like = new Like();
        $like->target_id = $this->id;
        $like->who_id = $whoGirl->id;
        $like->save();

        return true;
    }


}


