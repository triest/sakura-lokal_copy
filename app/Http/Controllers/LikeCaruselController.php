<?php

namespace App\Http\Controllers;

use App\City;
use App\Girl;
use App\Like;
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

        //   return view("search.index");

        $userAuth = Auth::user();
        if ($userAuth != null) {
            $Autchgirls = $userAuth->girl()->first();

            if ($Autchgirls != null) {
                //  $seachSettings = SearchSettings::select(['id'])
                //     ->where("girl_id", "=", $girls->id)->first();
                $seachSettings = $Autchgirls->seachsettings()->first();
            }
        } else {

            if (isset($_COOKIE["laravel_session"])) {
                $cookie = $_COOKIE["laravel_session"];
                if ($cookie != null) {
                    $seachSettings = SearchSettings::select(['*'])
                        ->where("cookie", "=", $cookie)
                        ->orderBy('updated_at', 'desc')
                        ->first();
                }
            }

        }

        if (!isset($seachSettings) || $seachSettings == null) {

            $girls = DB::table('girls');
            if (isset($Autchgirls) && $Autchgirls != null) {
                $girls->where('city_id', '=', $Autchgirls->city_id);
                //$girls->where('id', '<>', $Autchgirls->id);
            }

            $city = City::GetCurrentCity();

            if ($city != null) {
                $girls->where('city_id', $city->id);
            }
            $girls = $girls->orderByDesc('created_at')->get();
            $count = $girls->count();
            $num_pages = intval($count / $this->limit);

            return response()->json([
                'ankets'    => $girls,
                'count'     => $count,
                'num_pages' => $num_pages,
            ]);

        }

        $girls = DB::table('girls');


        $girls = $girls->leftJoin('like_caruse', 'girls.id', '=',
            'like_caruse.who_id');

        /*
        $girls = $girls->leftJoin('girl_interess', 'girls.id', '=',
            'girl_interess.girl_id');
*/
        $targets = $seachSettings->target()->get();
        foreach ($targets as $target) {
            //      $girls->where('target_id', $target->id);
        }

        $interest = $seachSettings->interest()->get();
        foreach ($interest as $item) {
            //        $girls->where('interest_id', $item->id);
        }

        if ($seachSettings->children != null) {

            /*custom seach for shildren */
            $girls->where('children_id', '=', $seachSettings->children);
        }

        $city = City::GetCurrentCity();

        if ($city != null) {
            //              $girls->where('city_id', $city->id);
        }

        if ($seachSettings->age_from != null) {
            $girls->where('age', '>=', $seachSettings->age_from);
        }

        if ($seachSettings->age_to != null) {
            $girls->where('age', '<=', $seachSettings->age_to);
        }

        if (isset($Autchgirls) && $Autchgirls != null) {
            $girls->where('girls.id', '!=', $Autchgirls->id);
        }

        $count = $girls->count();
        $num_pages = intval($count / $this->limit);

        $girls->select('girls.*')->limit($this->limit);

        if (isset($request->page) && $request->page != null
            && intval($request->page) != 1
        ) {
            $offset = $this->limit * (intval($request->page) - 1);
            $girls->offset($offset);
        }

        //  $girls->orderByDesc('created_at');

        $girls = $girls->get();

        return response()->json([
            'ankets'    => $girls,
            'count'     => $count,
            'num_pages' => $num_pages,
        ]);
    }

    public function newLike(Request $request)
    {
        $userAuth = Auth::user();
        if ($userAuth == null) {
            return redirect('login');
        }
        $authGirl = $userAuth->anketisExsis();
        $like = new Like();
        $like->who_id = $authGirl->id;
        $like->target_id = $request->anket_id;
        $like->save();

        return response()->json(['ok']);
    }
}
