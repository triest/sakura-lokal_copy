<?php

namespace App;

use App\Events\Newevent;
use App\Http\Controllers\GirlsController;
use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Myevent extends Model
{
    //
    protected $table = "myevents";


    //организатор
    public function organizer()
    {
        return $this->belongsTo('App\Girl');
    }

    //учстники
    public function girls()
    {
        //return $this->hasMany('App\Girl');
        return $this->belongsToMany('App\Girl');
    }

    //фотографии
    public function photo()
    {
        return $this->hasMany('App\EventPhoto');
    }

    public function count_participant()
    {
        //return 1;
        $particant = $this->participant;

        return $particant;
    }

    public static function myRequwest($user)
    {
        if ($user == null) {
            return 502;
        }
        $girl = $user->anketisExsis()->first();


        if ($girl == null) {
            return null;
        }
        $myRequwest = collect(DB::select('SELECT myeven.id,eventreq.girl_id,myeven.name,myeven.place,myeven.begin,status.name as statys_name,eventreq.status as req_status 
              FROM `event_requwest` `eventreq`  LEFT JOIN `myevents` `myeven` ON  `eventreq`.`event_id`=`myeven`.`id`     left join event_statys status on status.id=myeven.status_id 
            where  `eventreq`.`girl_id`=?',
            [$girl->id]));

        return $myRequwest;
    }

    public static function RequwestToMyEvent($user)
    {
        if ($user == null) {
            return 502;
        }
        $girl = $user->anketisExsis();

        $requestMyEvent
            = collect(DB::select('select even.name,even.id,req.id as `req_id`,even.place as `place`,girls.id as `girl_id`, even.id as `event_id`,girls.main_image as `girl_main_image`, girls.name as `girl_name`,req.status as `req_status` 
            from new_chat.event_requwest req 
              left join new_chat.myevents even on req.event_id=even.id 
              left join girls on req.girl_id=girls.id where even.organizer_id=?',
            [$girl->id]));

        return $requestMyEvent;
    }

    public function makeRequwest($girl)
    {
        $eventreq = new Eventrequwest();
        $eventreq->girl_id
            = $girl->id; //рзобраться с тем, кому отправляеться событие.
        $eventreq->event_id = $this->id;
        $eventreq->status = 'unread';
        $eventreq->save();
        $organizer = $this->organizer()->first();
        if ($organizer != null) {
            new Newevent($organizer);
        }
    }

    public static function myparticipation($girl, $set_readed = false)
    {

        $event = collect(DB::select('SELECT myeven.id,myeven.name,myeven.place,myeven.begin,status.name as statys_name,eventreq.status as req_status
            FROM `event_requwest` `eventreq` 
            LEFT JOIN `myevents` `myeven` ON
              `eventreq`.`event_id`=`myeven`.`id` 
            left join event_statys status on status.id=myeven.status_id 
              WHERE `eventreq`.`girl_id`=?',
            [$girl->id]));

        /*
         *
         * */
        //ставим отметку, что прочитанно
        if ($set_readed) {
            DB::table('event_requwest')->where('girl_id', $girl->id)
                ->update(['read_accept_notification' => 1]);
        }


        return $event;
    }

    public function getOwner()
    {

    }

    public static function inMyCity($city = null, $date = null)
    {
        if ($city == null) {
            $city = City::GetCurrentCity();
        }

        if ($date == null) {
            $date = Carbon::now()->toDateTimeString();
        }

        if ($city != null) {
            return $events = Myevent::select(['*'])
                ->where('city_id', $city->id)
                ->where('begin', '>', $date)
                ->get();
        } else {
            return null;
        }

    }

    /*
     * проверяет, не записан ли пользователь
     * */

    public function checkUserPartification($user = null)
    {
        //   dump($user);
        if ($user == null) {
            $user = Auth::user();
        }

        if ($user == null) {
            return false;
        }


        $anket = $user->girl()->first();

        if ($anket == null) {
            return false;
        }


        $partificatpr = DB::table('event_requwest')->select('*')
            ->where('girl_id', '=', $anket->id)
            ->where('event_id', '=', $this->id)
            ->get();

        return $partificatpr;
    }

    public static function get($id)
    {
        return Myevent::select(['*'])->where('id', $id)->first();
    }
}
