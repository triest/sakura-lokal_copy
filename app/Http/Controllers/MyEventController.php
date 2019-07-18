<?php

namespace App\Http\Controllers;

use App\Girl;
use App\Myevent;
use App\EventStatys;
use App\EventPhoto;
use App\Eventrequwest;
//use App\Events\Neweventrequwest;
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
            'max' => 'required|numeric|min:1',
            'min' => 'required|numeric|min:1',
            'begin' => 'required',
            'end' => 'required',
            'city' => 'required',
        ]);


        $event = new Myevent();
        $event->name = $request->name;
        $event->description = $request->description;
        $event->max_people = $request->max;
        $event->min_people = $request->min;
        if ($request->has('place')) {
            $event->place = $request->place;
        }
        $user = Auth::user();
        $girl = Girl::select(['id', 'name', 'user_id'])->where('user_id', $user->id)->first();
        if ($girl == null) {
            return null;
        }

        if ($request->has('city')) {
            $event->city_id = $request->city;
        }
        $event->girl_id = $girl->id;
        $event->save();

        if (Input::hasFile('file')) {
            foreach ($request->file as $key) {
                $image_extension = $key->getClientOriginalExtension();
                $image_new_name = md5(microtime(true));
                $key->move(public_path().'/images/events/', strtolower($image_new_name.'.'.$image_extension));

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
        $events = collect(DB::select('select myevents.id,myevents.name,event_statys.status_name,city.id_city,city.name as \'city_name\', myevents.place,myevents.created_at,myevents.updated_at from myevents  left join event_statys on myevents.status_id=event_statys.id left join cities city on myevents.city_id=city.id_city'));

        return response()->json(["events" => $events]);
    }

    public function edit($id)
    {
        $events = DB::table('myevents')
            ->join('event_statys', 'event_statys.id', '=', 'myevents.status_id')
            ->where('myevents.id', '=', $id)
            ->first();
        //dump($events);
        $statys = EventStatys::select()->get();

        // dump($statys);

        return view('event.edit')->with(['event' => $events, 'statys' => $statys]);
    }

    public function viewmyevent($id)
    {
        $events = collect(DB::select('select myevents.id as `id`, myevents.name,myevents.description,
myevents.begin,myevents.end_applications,city.id_city,city.name as \'city_name\',myevents.status_id as `status_id`, 
myevents.place,myevents.created_at,myevents.updated_at,statys.status_name from myevents  
left join event_statys statys on myevents.status_id=statys.id left join
 cities city on myevents.city_id=city.id_city where myevents.id=?',
            [$id]));
        $events = $events[0];

        //dump($events);
        $statys = EventStatys::select()->get();
        // dump($events);

        // dump($statys);
        //dump($events);

        if ($events == null) {
            return null;
        }

        return view('event.viewmy')->with(['event' => $events, 'statys' => $statys]);
    }

    public function eventsinmycity(Request $request)
    {

        // $events = collect(DB::select('select myev.id,myev.name,myev.begin,myev.end,myev.status_id from myevents myev left join girl_myevent evpart on myev.id=evpart.myevent_id
        //     where myev.city_id=? ', [$request->id]));
        $user = Auth::user();
        // dump($user);
        if ($user == null) {
            echo "not user";

            return response()->json("not user");
        } else {
            $girl = $user->anketisExsis();

            if ($girl == null) {
                return response()->json("nogirl");
            } else {
                $girl = Girl::select('id', 'name', 'city_id')->where('user_id', $user->id)->first();
                $city_id = $girl->city_id;
                $events = collect(DB::select('select myev.id,myev.name,myev.begin,myev.end,myev.status_id,myev.place,myev.status_id,status.status_name 	             
                from myevents myev left join girl_myevent evpart on myev.id=evpart.myevent_id left join event_statys status on status.id=myev.status_id 
                 where myev.city_id=? ', [$city_id]));

                return response()->json($events);
            }
        }

    }


    public function singup($id)
    {
        //выбираем событие
        /* $events = collect(DB::select('select myev.id,myev.name,myev.place,myev.description,myev.max_people,myev.min_people,myev.begin,myev.end,myev.status_id from myevents myev left join events_participants evpart on myev.id=evpart.event_id
              where myev.id=? limit 1', [$id]));*/
        $events = Myevent::select(['id', 'name', 'place', 'description', 'max_people'])->Paginate(1);
        //dump($events);
        /*  $count = collect(DB::select('select myev.id,myev.name,myev.begin,myev.end,myev.city_id from myevents myev left join events_participants evpart on myev.id=evpart.event_id
               where myev.id=? group by myev.id', [$id]));
  */

        // dump($count);


        return view('event.singup')->with(['events' => $events,/* 'count' => $count*/]);
    }

    public function makerequwest(Request $request)
    {
        // dump($request);
        $user = Auth::user();
        $girl = Girl::select(['id', 'name'])->where('user_id', $user->id)->first();
        if ($girl == null) {
            return null;
        }
        $eventreq = new Eventrequwest();
        $eventreq->save();

        $event = Myevent::select(['id', 'name', 'place', 'description', 'max_people'])->where('id',
            $request->id)->first();

        //$eventreq->who()->associate($girl)->save();
        $eventreq->girl_id = $girl->id;
        $eventreq->event_id = $event->id;      //  $eventreq->target()->associate($girl)->save();

        $eventreq->status = 'unredded';
        $eventreq->save();

        // broadcast(new Neweventrequwest($eventreq));

        return response()->json('ok');
    }

    public function checkrequwest(Request $request)
    {
        $user = Auth::user();
        $girl = Girl::select(['id', 'name'])->where('user_id', $user->id)->first();
        if ($girl == null) {
            return null;
        }
        $eventreq = Eventrequwest::select(['id', 'status'])->where('girl_id', $girl->id)->where('event_id',
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
        $list = collect(DB::select('select girl.id,girl.name,girl.age,req.status,girl.main_image,req.id as `req_id` from event_requwest req left join girls girl on req.girl_id=girl.id where event_id=?',
            [$request->eventid]));
        $accepted = collect(DB::select('select girl.id,girl.name,girl.age,req.status,girl.main_image,req.id as `req_id` from event_requwest req left join girls girl on req.girl_id=girl.id where event_id=? and req.status="accept"',
            [$request->eventid]));
        $reject = collect(DB::select('select girl.id,girl.name,girl.age,req.status,girl.main_image,req.id as `req_id` from event_requwest req left join girls girl on req.girl_id=girl.id where event_id=? and req.status="denide"',
            [$request->eventid]));
        $unredded = collect(DB::select('select girl.id,girl.name,girl.age,req.status,girl.main_image,req.id as `req_id` from event_requwest req left join girls girl on req.girl_id=girl.id where event_id=? and req.status="unredded"',
            [$request->eventid]));


        return response()->json([
            'all' => $list,
            'accepted' => $accepted,
            'reject' => $reject,
            'unredded' => $unredded,
        ]);
    }

    public function accept(Request $request)
    {
        $id = $request->useris;
        //dump($id);
        $action = $request->action;
        //dump($action);
        $eventid = $request->eventid;
        //dump($eventid);
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

}
