<?php

namespace App\Http\Controllers;

use App\City;
use App\Girl;
use App\Like;
use App\SearchSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikeCaruselController extends Controller
{

    //
    public function index()
    {
        return view('likeCarusel');
    }

    public function getAnket()
    {
        $girls = null;
        $userAuth = Auth::user();
        if ($userAuth != null) {
            $Autchgirls = $userAuth->girl()->first();
        }

        if (isset($Autchgirls) && $Autchgirls != null) {
            $girls = collect(DB::select('select girls.id  from girls girls
where girls.id not in (
select likes.target_id from likes where likes.who_id=?
)
order by rand()
limit 1', [$Autchgirls->id]))->first();
        } else {
            $city = City::GetCurrentCity();
            if ($city == null) {
                return null;
            }
            $girls = collect(DB::select('select girls.id  from girls girls
where girls.id not in (
select likes.target_id from likes 
)
order by rand()
limit 1'))->first();
        }


        $girls = Girl::get($girls->id);
        $city = null;
        if ($girls->city_id != null) {
            $city = City::get($girls->city_id);
        }
        $targets = $girls->target()->get();
        $interets = $girls->interest()->get();

        $online = $girls->isOnline();
        $last_login = $girls->lastLoginFormat();

        return response()->json([
            'ankets'     => $girls,
            'online'     => $online,
            'city'       => $city,
            'targets'    => $targets,
            'interets'   => $interets,
            'last_login' => $last_login,
        ]);
    }

    public function newLike(Request $request)
    {
        $girl = Girl::get($request->anket_id);
        $girl->newLike();

        return response()->json(['ok']);
    }
}
