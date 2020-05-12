<?php

    namespace App;

    use App\Events\Newevent;
    use Illuminate\Database\Eloquent\Model;
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

        public static function myparticipation($girl)
        {
            $event = collect(DB::select('SELECT myeven.id,myeven.name,myeven.place,myeven.begin,status.name as statys_name,eventreq.status as req_status
            FROM `event_requwest` `eventreq` 
            LEFT JOIN `myevents` `myeven` ON
              `eventreq`.`event_id`=`myeven`.`id` 
            left join event_statys status on status.id=myeven.status_id 
              WHERE `eventreq`.`girl_id`=?',
                    [$girl->id]));

            return $event;
        }

        public function getOwner()
        {

        }

    }
