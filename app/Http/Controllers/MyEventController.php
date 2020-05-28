<?php

namespace App\Http\Controllers;

use App\City;
use App\Events\Newevent;
use App\Events\NewMessage;
use App\Girl;
use App\Jobs\SendMessageAboutEvent;
use App\Jobs\SendSMSAboutEvent;
use App\Myevent;
use App\EventStatys;
use App\EventPhoto;
use App\Eventrequwest;
//use App\Events\Neweventrequwest;
use App\User;
use DateTime;
use Doctrine\DBAL\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use DB;
use File;

class MyEventController extends Controller
{
    //

    public function myevent(Request $request)
    {
        return view('event.myevent');
    }

    //форма события
    public function create(Request $request)
    {
        return view('event.create');
    }

    //обновление события
    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'name'        => 'required',
            'description' => 'required',
            'max'         => 'numeric',
            'min'         => 'numeric',
            'date'        => 'date_format:Y-m-d',
            'time'        => 'required|date_format:H:i:s',
            'city'        => 'required',
        ]);


        //  die();
        $event = Myevent::select([
            'id',
            'name',
            'description',
            'max_people',
            'min_people',
            'begin',
            'city_id',
            'organizer_id',
        ])->where(['id' => $request->id])->first();
        if ($event == null) {
            return null;
        }

        $event->name = $request->name;
        $event->description = $request->description;
        $event->max_people = $request->max;
        $event->min_people = $request->min;
        $begin = new DateTime($request->date.' '.$request->time);
        $begin = $request->date.' '.$request->time;
        $event->begin = $begin;

        if ($request->has('place')) {
            $event->place = $request->place;
        }
        $user = Auth::user();
        $girl = Girl::select(['id', 'name', 'user_id'])
            ->where('user_id', $user->id)->first();
        if ($girl == null) {
            return null;
        }


        if ($request->has('city')) {
            $event->city_id = $request->city;
        }
        $event->organizer_id = $girl->id;

        $event->save();

        /*
                if (Input::hasFile('file')) {
                    foreach ($request->file as $key) {
                        $image_extension = $key->getClientOriginalExtension();
                        $image_new_name = md5(microtime(true));
                        $key->move(public_path().'/images/events/',
                            strtolower($image_new_name.'.'.$image_extension));

                        $photo = new EventPhoto();
                        $photo['photo_name'] = $image_new_name.'.'.$image_extension;
                        $photo['myevent_id'] = $event->id;
                        $photo->save();
                    }
                }
        */

        return redirect("/myevent");
    }

    public function store(Request $request)
    {


        $event = new Myevent();
        $event->name = $request->name;
        $event->description = $request->description;
        $event->max_people = $request->max;
        $event->min_people = $request->min;
        $event->begin = new DateTime($request->date.' '.$request->time);
        if ($request->has('place')) {
            $event->place = $request->place;
        }
        $user = Auth::user();
        $girl = Girl::select(['id', 'name', 'user_id'])
            ->where('user_id', $user->id)->first();
        if ($girl == null) {
            return null;
        }

        if ($request->has('city')) {
            $event->city_id = $request->city;
        } else {
            $city = City::GetCurrentCity();
            if ($city != null) {
                $event->city_id = $city->id;
            }
        }
        $event->organizer_id = $girl->id;

        $event->save();

        if (Input::hasFile('file')) {
            foreach ($request->file as $key) {
                $image_extension = $key->getClientOriginalExtension();
                $image_new_name = md5(microtime(true));
                $key->move(public_path().'/images/events/',
                    strtolower($image_new_name.'.'.$image_extension));

                $photo = new EventPhoto();
                $photo['photo_name'] = $image_new_name.'.'.$image_extension;
                $photo['myevent_id'] = $event->id;
                $photo->save();
            }
        }


        return redirect("/myevent");
    }

    public function list(Request $request)
    {
        $user = Auth::user();
        $girl = $user->anketisExsis();
        if ($girl == null) {
            return null;
        }
        $events
            = collect(DB::select('select myevents.id,myevents.name,event_statys.name as `event_statys`,city.id,city.name as \'city_name\',myevents.begin, myevents.place,myevents.created_at,myevents.updated_at from myevents  left join event_statys on myevents.status_id=event_statys.id left join cityes_api city on myevents.city_id=city.id'));

        return response()->json(["events" => $events]);
    }

    public function edit($id)
    {
        $events = collect(DB::select('select myevents.id as `id`, myevents.name,myevents.description,
myevents.begin,myevents.end_applications,city.id_city,city.name as \'city_name\',myevents.status_id as `status_id`, 
myevents.place,myevents.created_at,myevents.updated_at,myevents.max_people,myevents.min_people,statys.name as \'status_name\'  from myevents  
left join event_statys statys on myevents.status_id=statys.id left join
 cities city on myevents.city_id=city.id_city where myevents.id=?',
            [$id]));
        $events = $events[0];
        $statys = EventStatys::select()->get();


        $bigin = $events->begin;
        $arr = explode(' ', $bigin);
        $date = $arr[0];
        $time = $arr[1];

        return view('event.edit')->with([
            'event'  => $events,
            'statys' => $statys,
            'date'   => $date,
            'time'   => $time,
        ]);
    }

    public function viewmyevent($id)
    {
        $events = collect(DB::select('select myevents.id as `id`, myevents.name,myevents.description,
myevents.begin,myevents.end_applications,city.id as `id_city`,city.name as \'city_name\',myevents.status_id as `status_id`, 
myevents.place,myevents.created_at,myevents.updated_at,statys.name as \'status_name\'  from myevents  
left join event_statys statys on myevents.status_id=statys.id left join
 cityes_api city on myevents.city_id=city.id where myevents.id=?',
            [$id]));
        $events = $events[0];

        $statys = EventStatys::select()->get();
        if ($events == null) {
            return null;
        }

        return view('event.viewmy')->with([
            'event'  => $events,
            'statys' => $statys,
        ]);
    }

    public function inmycity(Request $request)
    {
        if ($request->city) {
            $city = City::get(intval($request->get('city')));
            $events = Myevent::inMyCity($city);

            $partificator = null;
            $partifucationArray = array();
            foreach ($events as $item) {
                $partificator = $item->checkUserPartification();
                if ($partificator != false) {
                    array_push($partifucationArray, $partificator);
                }
            }

            return response()->json([
                "events"        => $events,
                "partification" => $partifucationArray,
            ]);
        } else {
            return response()->json();
        }
    }


    public function singup($id)
    {
        $events = Myevent::select([
            'id',
            'name',
            'place',
            'begin',
            'description',
            'max_people',
            'organizer_id',
        ])->where('id', $id)->first();
        //моё ли это событие
        $auth_user = Auth::user();
        $girl_id = $auth_user->get_girl_id();

        if ($girl_id == $events->organizer_id) {
            return redirect("/myevent/".$id);
        }

        $days = [
            'Воскресенье',
            'Понедельник',
            'Вторник',
            'Среда',
            'Четверг',
            'Пятница',
            'Суббота',
        ];
        $months = [
            'Январь',
            'Февраль',
            'Март',
            'Апрель',
            'Май',
            'Июнь',
            'Июль',
            'Август',
            'Сентябрь',
            'Октябрь',
            'Ноябрь',
            'Декабрь',
        ];
        $arr = explode(" ", $events->begin);
        $day_num = date("w", strtotime($arr[0]));
        $day_name = $days[$day_num];
        $d = date_parse_from_format("Y-m-d", $arr[0]);
        $month_name = $months[$d["month"]];
        $day = $d["day"];


        $organizer = Girl::select(['id', 'name', 'main_image'])
            ->where('id', $events->organizer_id)->first();
        $photo = $events->photo()->get();


        return view('event.singup')->with([
            'event'      => $events,
            'day_name'   => $day_name,
            'month_name' => $month_name,
            'day'        => $day,
            'time'       => $arr[1],
            'organizer'  => $organizer,
            'photo'      => $photo
            /* 'count' => $count*/
        ]);
    }

    public function makerequwest(Request $request)
    {

        $user = Auth::user();
        $girl = Girl::select(['id', 'name'])->where('user_id', $user->id)
            ->first();
        if ($girl == null) {
            return null;
        }
        $event = Myevent::select([
            'id',
            'name',
            'place',
            'description',
            'max_people',
            'organizer_id',
        ])->where('id',
            $request->id)->first();
        if ($event == null) {
            return response(404);
        }

        $rez = $event->makeRequwest($girl);

        $user = User::getautch();

        // $eventEvent = new Newevent($user);
        // broadcast(new Newevent($eventEvent));

        $eventOwgene = Girl::select(['id', 'user_id'])
            ->where('id', $event->organizer_id)->first();
        //  $user = $eventOwgene->user()->get();
        $user = User::select(['id'])->where('id', $eventOwgene->user_id)
            ->first();
        if ($user != null) {
            new SendMessageAboutEvent("Новая заявка на мероприятие",
                $user->email,
                $user->name, 'Новая заявка на ваше мероприятие!');
            new SendSMSAboutEvent("Новая заявка на мероприятие", $user->phone,
                $event->name);
        }


        return response(200);
    }

    public function checkrequwest(Request $request)
    {
        $user = Auth::user();
        $girl = Girl::select(['id', 'name'])->where('user_id', $user->id)
            ->first();
        if ($girl == null) {
            return null;
        }
        $eventreq = Eventrequwest::select(['id', 'status'])
            ->where('girl_id', $girl->id)->where('event_id',
                $request->id)->first();

        if ($girl != null && $eventreq != null) {
            //return response()->json('sended');
            return response()->json($eventreq);
        } else {
            return response()->json('notsend');
        }
    }

    public function requwestlist(Request $request)
    {

        $list
            = collect(DB::select('select girl.id,girl.name,girl.age,req.status,girl.main_image,req.id as `req_id` from event_requwest req left join girls girl on req.girl_id=girl.id where event_id=?',
            [$request->eventid]));
        $accepted
            = collect(DB::select('select girl.id,girl.name,girl.age,req.status,girl.main_image,req.id as `req_id` from event_requwest req left join girls girl on req.girl_id=girl.id where event_id=? and req.status="accept"',
            [$request->eventid]));
        $reject
            = collect(DB::select('select girl.id,girl.name,girl.age,req.status,girl.main_image,req.id as `req_id` from event_requwest req left join girls girl on req.girl_id=girl.id where event_id=? and req.status="denide"',
            [$request->eventid]));
        $unreaded
            = collect(DB::select('select girl.id,girl.name,girl.age,req.status,girl.main_image,req.id as `req_id` from event_requwest req left join girls girl on req.girl_id=girl.id where event_id=? and req.status="unreaded"',
            [$request->eventid]));

        return response()->json([
            'all'      => $list,
            'accepted' => $accepted,
            'reject'   => $reject,
            'unreaded' => $unreaded,
        ]);
    }


    public function unreaded(Request $request)
    {
        $unreaded
            = collect(DB::select('select girl.id,girl.name,girl.age,req.status,girl.main_image,req.id as `req_id` from event_requwest req left join girls girl on req.girl_id=girl.id where event_id=? and req.status="unread"',
            [$request->eventid]));

        return response()->json($unreaded);
    }

    public function accepted(Request $request)
    {
        $unreaded
            = collect(DB::select('select girl.id,girl.name,girl.age,req.status,girl.main_image,req.id as `req_id` from event_requwest req left join girls girl on req.girl_id=girl.id where event_id=? and req.status="accept"',
            [$request->eventid]));

        return response()->json($unreaded);
    }

    public function denided(Request $request)
    {
        $unreaded
            = collect(DB::select('select girl.id,girl.name,girl.age,req.status,girl.main_image,req.id as `req_id` from event_requwest req left join girls girl on req.girl_id=girl.id where event_id=? and req.status="denide"',
            [$request->eventid]));

        return response()->json($unreaded);
    }

    public function accept(Request $request)
    {
        $id = $request->useris;
        $action = $request->action;
        $eventid = $request->eventid;
        //id запрома
        $reqid = $request->reqid;

        /*
         * создам событие
         *
         * */

        $eventRequwest = Eventrequwest::select(['*'])->where('id', $reqid)
            ->first();


        $event = Myevent::select('*')->where('id', $eventid)->first();
        if ($event == null) {
            return response()->json('notevent');
        }
        $girl = Girl::select('*')->where('id', $eventRequwest->girl_id)
            ->first();

        if ($girl == null) {
            return response()->json('notgirl');
        }
        $req = Eventrequwest::select('id')->where('id', $reqid)->first();
        if ($req == null) {
            return response()->json('notreq');
        }

        $user = $girl->user()->first();

        $eventEvent = new Newevent(null, $user);
        broadcast($eventEvent);


        if ($action == 'accept') {
            DB::table('event_requwest')
                ->where('id', $reqid)
                ->update(['status' => 'accept']);

        } elseif ($action == 'reject') {
            DB::table('event_requwest')
                ->where('id', $reqid)
                ->update(['status' => 'denide']);
        }


        //отправить сообщение и уведомление по почте
        $user->sendmail("Ваша заявка принята", null, null, "event_accept", null,
            $event);


        return response(200);

    }

    public function countunreaded(Request $request)
    {
        $user = Auth::user();
        if ($user == null) {
            return 502;
        }
        $girl = $user->anketisExsis();

        if ($girl == null) {
            return 502;
        }

        $unredded
            = collect(DB::select('SELECT * FROM `event_requwest` `eventreq` LEFT JOIN `myevents` `myeven` ON
`eventreq`.`event_id`=`myeven`.`id`
WHERE `myeven`.`organizer_id`=? and `eventreq`.`status`=\'unread\'',
            [$girl->id]))->count();

        return response()->json(['organizer' => $unredded]);
    }

    public function requwestcount(Request $request)
    {
        $event = Myevent::select(['id', 'name', 'max_people', 'min_people'])
            ->where('id', $request->eventid)
            ->first();
        if ($event == null) {
            return 404;
        }
        $accepted = Eventrequwest::select([
            'id',
            'event_id',
            'girl_id',
            'status',
        ])
            ->where('event_id', $event->id)
            ->where('status', 'accept')
            ->count();


        $unreaded = Eventrequwest::select([
            'id',
            'event_id',
            'girl_id',
            'status',
        ])
            ->where('event_id', $event->id)
            ->where('status', 'unreaded')
            ->get();

        return response()->json([
            'event'    => $event,
            'accepted' => $accepted,
            'unreaded' => $unreaded,
        ]);
    }

    public function myparticipation(Request $request)
    {

        $user = Auth::user();
        if ($user == null) {
            return 502;
        }
        $girl = $user->anketisExsis();

        if ($girl == null) {
            return 502;
        }


        if ($request->has('myparticipation')
            && $request->get('myparticipation') == '1'
        ) {
            $event = Myevent::myparticipation($girl);
        } else {
            $event = Myevent::myparticipation($girl, true);
        }

        return response()->json($event);
    }

    public function requwestMyeventslist(Request $request)
    {

        return view('event.allRequwesList');
    }

    public function reminders(Request $request)
    {
        $user = Auth::user();
        if ($user == null) {
            return 502;
        }
        $girl = $user->girl()->first();


        if ($girl == null) {
            return 404;
        }


        // напоминание каждые два часа
        $requestMyEvent
            = collect(DB::select('select even.name,even.id,req.id as `req_id`,even.place as `place`,girls.id as `girl_id`, even.id as `event_id`,girls.main_image as `girl_main_image`,
  even.begin,photos.photo_name,
 girls.name as `girl_name`,req.status as `req_status` 
              from new_chat.event_requwest req 
              left join new_chat.myevents even on req.event_id=even.id 
              left join girls on req.girl_id=girls.id 
              left join event_photos photos on photos.myevent_id=even.id
              where (req.girl_id=? or  even.organizer_id=?)  and DATE(even.begin)=CURDATE()
              and  	alert_notification_today_received=0
              and ((TIMESTAMPDIFF(HOUR, alert_notification_today, NOW())>2) or (alert_notification_today is null))',
            [$girl->id, $girl->id]));

        return response()->json([
            'requestMyEvent' => $requestMyEvent,
        ]);

    }

    public function remindersAll(Request $request)
    {
        $user = Auth::user();
        if ($user == null) {
            return 502;
        }
        $girl = $user->girl()->first();

        if ($girl == null) {
            return 404;
        }

        //запросы к моим событиям
        $requestMyEvent
            = collect(DB::select('select even.name,even.id,req.id as `req_id`,even.place as `place`,girls.id as `girl_id`, even.id as `event_id`,girls.main_image as `girl_main_image`,
  even.begin,
 girls.name as `girl_name`,req.status as `req_status` 
              from new_chat.event_requwest req 
              left join new_chat.myevents even on req.event_id=even.id 
              left join girls on req.girl_id=girls.id 
              where  DATE(even.begin)=CURDATE()'));

        /* return response()->json([
             'requestMyEvent' => $requestMyEvent,
         ]);*/

    }

    public function requwestListAll(Request $request)
    {
        $user = Auth::user();
        //мои запросы
        $myRequwest = Myevent::myRequwest($user);

        //запросы к моим событиям
        $requestMyEvent = Myevent::RequwestToMyEvent($user);


        return response()->json([
            'myRequwest'     => $myRequwest,
            'requestMyEvent' => $requestMyEvent,
        ]);

    }

    //
    public function remindersRecived(Request $request)
    {
        $user = Auth::user();
        //  $girl = $user->anketisExsis();
        $girl = $user->girl()->first();
        if ($girl == null) {
            return response()->json([
                'fail2',
            ]);
        }

        $req = Eventrequwest::select([
            'id',
            'alert_notification_today_received',
            'alert_notification_today',
        ])
            ->where('event_id', $request->event_id)
            ->where('girl_id', $girl->id)
            ->first();

        if ($req == null) {
            return response()->json([
                'fail2',
            ]);
        }
        if ($request->action == "alert_late") {
            $req->alert_notification_today = new \DateTime();
        } else {
            $req->alert_notification_today_received = 1;
            $req->alert_notification_today = new \DateTime();
        }
        $req->save();

        return response()->json([
            'ok',
        ]);

    }
}
