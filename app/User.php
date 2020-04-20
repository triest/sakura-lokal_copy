<?php

namespace App;

use Illuminate\Filesystem\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'id',
            'name',
            'email',
            'password',
            'money',
            'endvip',
            'beginvip',
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden
        = [
            'password',
            'remember_token',
        ];

    //проверка есть ли анкета
    public function anketisExsis()
    {

        $user_id = Auth::user()->id;
        $girl = Girl::select()
            ->where('user_id', $user_id)->first();

        return $girl;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function finfUserById($id)
    {
        dump($id);
    }


    public function isOnline()
    {
        return \Cache::has('user-is-online-'.$this->id);
    }

    public function get_girl_id()
    {
        $girl = Girl::select('id', 'user_id')->where('user_id', $this->id)
            ->first();
        if ($girl == null) {
            return null;
        } else {
            return $girl->id;
        }
    }

    public static function getautch()
    {
        $user_id = Auth::user();
        $user = User::select(['id', 'name'])->where('id', $user_id->id)
            ->first();

        return $user;
    }

    public function girl()
    {
        return $this->hasOne('App\Girl');
    }


    public static function getIpstatic()
    {
        foreach (
            array(
                'HTTP_CLIENT_IP',
                'HTTP_X_FORWARDED_FOR',
                'HTTP_X_FORWARDED',
                'HTTP_X_CLUSTER_CLIENT_IP',
                'HTTP_FORWARDED_FOR',
                'HTTP_FORWARDED',
                'REMOTE_ADDR',
            ) as $key
        ) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP,
                            FILTER_FLAG_NO_PRIV_RANGE
                            | FILTER_FLAG_NO_RES_RANGE) !== false
                    ) {
                        return $ip;
                    }
                }
            }
        }

        return null;
    }

    //get ip
    public static function getIp()
    {
        foreach (
            array(
                'HTTP_CLIENT_IP',
                'HTTP_X_FORWARDED_FOR',
                'HTTP_X_FORWARDED',
                'HTTP_X_CLUSTER_CLIENT_IP',
                'HTTP_FORWARDED_FOR',
                'HTTP_FORWARDED',
                'REMOTE_ADDR',
            ) as $key
        ) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP,
                            FILTER_FLAG_NO_PRIV_RANGE
                            | FILTER_FLAG_NO_RES_RANGE) !== false
                    ) {
                        return $ip;
                    }
                }
            }
        }

        return null;
    }
}
