<?php

namespace App\Http\Controllers;

use App\Events\Newevent;
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

    //пост события
    public function store(Request $request)
    {
        $validatedData = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'max' => 'numeric|min:1',
                'min' => 'numeric|min:1',
                'date' => 'required|date_format:Y-m-d',
                'time' => 'required|date_format:H:i',
                'city' => 'required',
        ]);


        //  die();

        $event = new Myevent();
        $event->name = $request->name;
        $event->description = $request->description;
        $event->max_people = $request->max;
        $event->min_people = $request->min;
        $event->begin = new DateTime($request->date . ' ' . $request->time);
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

        if (Input::hasFile('file')) {
            foreach ($request->file as $key) {
                $image_extension = $key->getClientOriginalExtension();
                $image_new_name = md5(microtime(true));
                $key->move(public_path() . '/images/events/',
                        strtolower($image_new_name . '.' . $image_extension));

                $photo = new EventPhoto();
                $photo['photo_name'] = $image_new_name . '.' . $image_extension;
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
                = collect(DB::select('select myevents.id,myevents.name,event_statys.name as `event_statys`,city.id_city,city.name as \'city_name\',myevents.begin, myevents.place,myevents.created_at,myevents.updated_at from myevents  left join event_statys on myevents.status_id=event_statys.id left join cities city on myevents.city_id=city.id_city'));

        return response()->json(["events" => $events]);
    }

    public function edit($id)
    {
        $events = DB::table('myevents')
                ->join('event_statys', 'event_statys.id', '=', 'myevents.status_id')
                ->where('myevents.id', '=', $id)
                ->first();
        $statys = EventStatys::select()->get();

        return view('event.edit')->with([
                'event' => $events,
                'statys' => $statys,
        ]);
    }

    public function viewmyevent($id)
    {
        $events = collect(DB::select('select myevents.id as `id`, myevents.name,myevents.description,
myevents.begin,myevents.end_applications,city.id_city,city.name as \'city_name\',myevents.status_id as `status_id`, 
myevents.place,myevents.created_at,myevents.updated_at,statys.name as \'status_name\'  from myevents  
left join event_statys statys on myevents.status_id=statys.id left join
 cities city on myevents.city_id=city.id_city where myevents.id=?',
                [$id]));
        $events = $events[0];

        $statys = EventStatys::select()->get();
        if ($events == null) {
            return null;
        }

        return view('event.viewmy')->with([
                'event' => $events,
                'statys' => $statys,
        ]);
    }

    public function inmycity(Request $request)
    {

        $user = Auth::user();
        if ($user == null) {
            $ip = GirlsController::getIpStatic();
            $response = file_get_contents("http://api.sypexgeo.net/json/"
                    . $ip); //запрашиваем местоположение
            $response = json_decode($response);
            $name = $response->city->name_ru;

            $cities = DB::table('cities')->where('name', 'like', $name . '%')
                    ->first();
            $events = collect(DB::select('select myev.id,myev.name,myev.begin,myev.end,myev.status_id,myev.place,myev.status_id,status.name as `status_name`	             
                from myevents myev left join events_participants evpart on myev.id=evpart.myevent_id left join event_statys status on status.id=myev.status_id 
                 where myev.city_id=? and  myev.begin>now()',
                    [$cities->id_city]));

            return response()->json($events);
        } else {
            $girl = $user->anketisExsis();
            if ($girl == null) {
                $ip = GirlsController::getIpStatic();
                $response = file_get_contents("http://api.sypexgeo.net/json/"
                        . $ip); //запрашиваем местоположение
                $response = json_decode($response);
                $name = $response->city->name_ru;
                $cities = DB::table('cities')->where('name', 'like', $name . '%')
                        ->first();
                $events = collect(DB::select('select myev.id,myev.name,myev.begin,myev.end,myev.status_id,myev.place,myev.status_id,status.name as `status_name`	             
                from myevents myev left join events_participants evpart on myev.id=evpart.myevent_id left join event_statys status on status.id=myev.status_id 
                 where myev.city_id=? and  myev.begin>now()',
                        [$cities->id_city]));

                return response()->json($events);
            } else {
                $girl = Girl::select('id', 'name', 'city_id')
                        ->where('user_id', $user->id)->first();
                $city_id = $girl->city_id;
                if ($city_id != null) {
                    $events = collect(DB::select('select myev.id,myev.name,myev.begin,myev.end,myev.status_id,myev.place,myev.status_id,status.name as `status_name`	             
                from myevents myev left join events_participants evpart on myev.id=evpart.myevent_id left join event_statys status on status.id=myev.status_id 
                 where myev.city_id=? and myev.begin>now()', [$city_id]));
                } else {
                    $ip = GirlsController::getIpStatic();
                    $response
                            = file_get_contents("http://api.sypexgeo.net/json/"
                            . $ip); //запрашиваем местоположение
                    $response = json_decode($response);
                    $name = $response->city->name_ru;
                    $cities = DB::table('cities')
                            ->where('name', 'like', $name . '%')
                            ->first();
                    $events = collect(DB::select('select myev.id,myev.name,myev.begin,myev.end,myev.status_id,myev.place,myev.status_id,status.name as `status_name`	             
                from myevents myev left join events_participants evpart on myev.id=evpart.myevent_id left join event_statys status on status.id=myev.status_id 
                 where myev.city_id=?  and myev.begin>now()',
                            [$cities->id_city]));

                    return response()->json($events);
                }

                return response()->json($events);
            }
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
                'event' => $events,
                'day_name' => $day_name,
                'month_name' => $month_name,
                'day' => $day,
                'time' => $arr[1],
                'organizer' => $organizer,
                'photo' => $photo
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
        $eventreq = new Eventrequwest();
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

        $eventreq->girl_id = $girl->id;
        $eventreq->event_id
                = $event->id;      //  $eventreq->target()->associate($girl)->save();

        $eventreq->status = 'unread';
        $eventreq->save();

        $eventOwgene = Girl::select(['id', 'user_id'])
                ->where('id', $event->organizer_id)->first();
        //  $user = $eventOwgene->user()->get();
        $user = User::select(['id'])->where('id', $eventOwgene->user_id)
                ->first();

        broadcast(new Newevent($eventreq));
        new SendMessageAboutEvent("Новая заявка на мероприятие", $user->email,
                $user->name, 'Новая заявка на ваше мероприятие!');
        new SendSMSAboutEvent("Новая заявка на мероприятие", $user->phone,
                $event->name);


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

        //  dump($unredded);

        return response()->json([
                'all' => $list,
                'accepted' => $accepted,
                'reject' => $reject,
                'unreaded' => $unreaded,
        ]);
    }


    public function unreaded(Request $request)
    {
        $unreaded
                = collect(DB::select('select girl.id,girl.name,girl.age,req.status,girl.main_image,req.id as `req_id` from event_requwest req left join girls girl on req.girl_id=girl.id where event_id=? and req.status="unreaded"',
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

        $event = Myevent::select('id')->where('id', $eventid);
        if ($event == null) {
            return response()->json('notevent');
        }
        $girl = Girl::select('id')->where('id', $id);
        if ($girl == null) {
            return response()->json('notgirl');
        }
        $req = Eventrequwest::select('id')->where('id', $reqid)->first();
        if ($req == null) {
            return response()->json('notreq');
        }


        if ($action == 'accept') {
            DB::table('event_requwest')
                    ->where('id', $reqid)
                    ->update(['status' => 'accept']);

        } elseif ($action == 'reject') {
            DB::table('event_requwest')
                    ->where('id', $reqid)
                    ->update(['status' => 'denide']);
        }

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

        return response()->json($unredded);
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
                'event' => $event,
                'accepted' => $accepted,
                'unreaded' => $unreaded,
        ]);
    }

    public function myparticipation(Request $request)
    {

    }
}

