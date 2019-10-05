<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use App\Myevent;

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
        return $this->hasOne('App\User');
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
}


