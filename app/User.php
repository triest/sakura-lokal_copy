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

}
