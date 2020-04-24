<?php

namespace App;

use App\Events\NewMessage;
use App\Http\Controllers\GirlsController;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use App\Myevent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Nexmo\Response;

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

    public function WinkForMe()
    {
        return $this->hasMany('App\Wink', 'target_id', 'id');
    }

    public function WinkMakeMe()
    {
        return $this->hasMany('App\Wink', 'who_id', 'id');
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
        $temp = $this->hasOne('App\City', 'id', 'city_id');

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
            } elseif ($datediff->d > 13 && $datediff->d < 21) {
                $last_login = "две недели назад";
            } elseif ($datediff->d >= 21) {
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

    public function newLike($user = null)
    {
        if ($user == null) {
            $user = Auth::user();
        }

        if ($user == null) {
            return false;
        }

        $whoGirl = $user->girl()->first();

        if ($whoGirl == null) {
            return false;
        }

        $like = new Like();
        $like->target_id = $this->id;
        $like->who_id = $whoGirl->id;
        $like->save();

        /*
         * ищим поставил ли он вам дфйк
         * */

        $first = Like::select(['id'])->where('who_id', $this->id)
            ->where('target_id', $whoGirl->id)->first();

        if ($first != null) {
            $whoGirl->sendMessage("Мы понравились друг другу ");
            $this->sendMessage("Мы понравились друг другу ");
        }

        return true;
    }

    public function saveView()
    {
        $AythUser = Auth::user();
        if (request()->has('utm_source')) {
            $utm_source = Input::get('utm_source');
        }

        if ($AythUser != null) {
            $user3 = DB::table('user_user')
                ->where('my_id', $AythUser->id)
                ->where('other_id', $this->user_id)->first();
            if ($user3 != null) {
                $girl = Girl::get($this->id);

                $privatephoto = $girl->privatephotos()->get();
            }
            $ip = User::getIp();
            $ayth_girl = Girl::select('id', 'user_id')
                ->where('user_id', $AythUser->id)->first();
            if ($ip != null and $ayth_girl != null) {

                if ($utm_source != null) {
                    $source_id = DB::table('view_source')
                        ->where('name', $utm_source)->first();

                    if ($source_id != null) {
                        DB::table('view_history')->insert([
                            'girl_id'   => $girl->id,
                            'ip'        => $ip,
                            'source_id' => $source_id->id,
                        ]);
                    }
                } else {
                    $source_id = DB::table('view_source')
                        ->where('name', $utm_source)->first();
                    if ($source_id != null) {
                        DB::table('view_history')->insert([
                            'girl_id'   => $girl->id,
                            'ip'        => $ip,
                            'source_id' => $source_id->id,
                        ]);
                        DB::table('view_history')
                            ->insert(['girl_id' => $girl->id, 'ip' => $ip]);
                    }
                }
            }
        } else {
            $ip = User::getIp();
            //сохраняем данные просмотра
            if (isset($utm_source) && $utm_source != null) {
                $source_id = DB::table('view_source')
                    ->where('name', $utm_source)->first();
                if ($source_id != null) {
                    DB::table('view_history')->insert([
                        'girl_id'   => $this->id,
                        'ip'        => $ip,
                        'source_id' => $source_id->id,
                    ]);
                } else {
                    DB::table('view_history')->insert([
                        'girl_id' => $this->id,
                        'ip'      => $ip,
                    ]);
                }
            }
        }
    }


    public function getPhoneSettings()
    {
        $AythUser = Auth::user();
        $phone_settings = $this->phone_settings;
        $phone = null;
        if ($phone_settings == 1) {
            $phone = $this->phone;
        } else {
            if ($AythUser != null) {
                $auth_girl = Girl::select('id', 'user_id')
                    ->where('user_id', $AythUser->id)->first();
                if ($auth_girl != null) {
                    $girl_in_table = DB::table('girl_open_phone_girl')
                        ->where('girl_id', $auth_girl->id)
                        ->where('target_id', $this->id)->first();
                    if ($girl_in_table != null) {
                        $girl2 = Girl::select([
                            'id',
                            'phone',
                        ])->where('id', $this->id)->first();;
                        $phone = $girl2->phone;
                    } else {
                        $phone = null;
                    }
                } else {
                    $phone = null;
                }
            }
        }
    }

    public function sendMessage($text, $who_girl = null)
    {
        $TargetUser = $this->user()->first();


        if ($who_girl == null) {
            $user = Auth::user();
        } else {
            $user = $who_girl->user()->first();
        }

        if ($user == null || $TargetUser == null) {
            return false;
        }

        $message = Message::create([
            'from' => $user->id,
            'to'   => $TargetUser->id,
            'text' => $text,
        ]);

        $id2 = $TargetUser->id;
        $dialog = Dialog::select(['id', 'my_id', 'other_id'])
            ->where('my_id', $user->id)->where('other_id',
                $id2)->first();
        if ($dialog == null) {
            $dialog3 = new Dialog();
            $dialog3->my_id = $user->id;
            $dialog3->other_id = $id2;
            $dialog3->save();
        }
        $dialog2 = Dialog::select(['id', 'my_id', 'other_id'])
            ->where('other_id', $user->id)->where('my_id',
                $id2)->first();
        if ($dialog2 == null) {
            $dialog4 = new Dialog();
            $dialog4->other_id = $user->id;
            $dialog4->my_id = $id2;
            $dialog4->save();
        }
        broadcast(new NewMessage($message));

        return true;
    }


}


