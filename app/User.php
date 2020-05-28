<?php

namespace App;

use App\Jobs\SendMessage;
use Illuminate\Filesystem\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

    public static function get($id)
    {

    }

//проверка есть ли анкета
    public function anketisExsis()
    {

        $girl = Girl::select('*')
            ->where('user_id', $this->id)->first();

        return $girl;
    }

    public
    function get_id()
    {
        return $this->id;
    }

    public
    static function findById(
        $id
    ) {
        $user = User::select(['id', 'name', 'email'])->where('id', $id)
            ->first();

        return $user;
    }


    public
    function isOnline()
    {
        return \Cache::has('user-is-online-'.$this->id);
    }

    public
    function get_girl_id()
    {
        $girl = Girl::select('id', 'user_id')->where('user_id', $this->id)
            ->first();
        if ($girl == null) {
            return null;
        } else {
            return $girl->id;
        }
    }

    public
    static function getautch()
    {
        $user_id = Auth::user();
        $user = User::select(['id', 'name'])->where('id', $user_id->id)
            ->first();

        return $user;
    }

    public
    function girl()
    {
        return $this->hasOne('App\Girl');
    }


    public
    static function getIpstatic()
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
    public
    static function getIp()
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

    public function sendmail(
        $message,
        $blade,
        $fromUser = null,
        $type = 'newMessage',
        $ankets = null,
        $event = null
    ) {
        switch ($type) {
            case "newMessage":
                $anket = $this->anketisExsis();

                if ($fromUser == null || $anket == null) {
                    return false;
                }
                $mail = $this->email;
                if ($mail == null) {
                    return false;
                }

                SendMessage::dispatch($mail, $anket, $message, $type)
                    ->delay(100);
                break;
            case "newAnkets":
                $anket = $this->anketisExsis();

                if ($anket == null) {
                    return false;
                }

                $mail = $this->email;
                if ($mail == null) {
                    return false;
                }

                SendMessage::dispatch($mail, $anket, $message, $type, $ankets)
                    ->delay(100);
                break;

            case "anketViews":
                $anket = $this->anketisExsis();

                if ($anket == null) {
                    return false;
                }

                $mail = $this->email;
                if ($mail == null) {
                    return false;
                }

                SendMessage::dispatch($mail, $anket, $message, $type, $ankets)
                    ->delay(100);

                break;
            case  "event-today":
                $anket = $this->anketisExsis();

                if ($anket == null) {
                    return false;
                }

                $mail = $this->email;
                if ($mail == null) {
                    return false;
                }

                SendMessage::dispatch($mail, $anket, $message, $type, $ankets,
                    $event)
                    ->delay(100);
                break;
            case "event_accept":

                $mail = $this->email;

                if ($mail == null) {
                    return false;
                }

                SendMessage::dispatch($mail, null, null, $type, null,
                    $event);
                break;

            case "event_denide":

                $mail = $this->email;

                if ($mail == null) {
                    return false;
                }

                SendMessage::dispatch($mail, null, null, $type, null,
                    $event);
                break;
        }
    }

}
