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
    private $limit = 1;

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

        $girls = $girl = Girl::select([
            'name',
            'id',
            'age',
            'main_image',
        ])->where('id', $girls->id)->first();

        return response()->json([
            'ankets' => $girls,
        ]);
    }

    public function newLike(Request $request)
    {
        $userAuth = Auth::user();
        if ($userAuth != null) {
            $authGirl = $userAuth->anketisExsis();
        }
        $like = new Like();
        if (isset($authGirl) && $authGirl != null) {
            $like->who_id = $authGirl->id;
        }
        $like->target_id = $request->anket_id;
        if (isset($request->action) && $request->action == "like") {
            $like->action = 'like';
            $like->save();
        } elseif (isset($request->action) && $request->action == "dislike") {
            $like->action = 'dislike';
            $like->save();
        } elseif (isset($request->action) && $request->action == "skip") {
            $like->action = 'skip';
            $like->save();
        }


        return response()->json(['ok']);
    }
}
