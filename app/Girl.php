<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use App\Myevent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

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
        ];

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function privatephotos()
    {
        return $this->hasMany('App\Privatephoto');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function target()
    {
        //return $this->hasOne('App\Target');
        return $this->belongsToMany('App\Target', 'girl_target', 'girl_id');
    }

    public function aperance()
    {
        //return $this->hasOne('App\Target');
        return $this->belongsTo('App\Aperance');

    }

    public function interest()
    {
        //return $this->hasOne('App\Target');
        return $this->belongsToMany('App\Interest', 'girl_interess');
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

    public function getCity()
    {
        return $city = DB::table('cities')->where('id_city', $girl->city_id)
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
        $mytime = Carbon::now();
        $last_login = Carbon::createFromFormat('Y-m-d H:i:s', $last_login);
        $datediff = date_diff($last_login, $mytime);
        if ($datediff->y == 0 && $datediff->m == 0 && $datediff->d == 0) {
            if ($datediff->h < 1) {
                $last_login = "менее часа назад";
            } elseif ($datediff->h == 1) {
                $last_login = "час назад";
            } else {
                $last_login = $datediff->h." часа назад";
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

        //return $user->isOnline();
        return Cache::has('user-is-online-'.$this->id);
    }
}


