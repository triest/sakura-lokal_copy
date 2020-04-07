<?php

namespace App\Http\Controllers;

use App\Girl;
use App\SearchSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SeachController extends Controller
{

    private $limit = 16;

    //
    public function seach(Request $request)
    {
        $girls = null;

        //   return view("search.index");

        $userAuth = Auth::user();
        if ($userAuth != null) {
            $girls = $userAuth->girl()->get();
            $girls = $girls[0];
            //  $seachSettings = SearchSettings::select(['id'])
            //     ->where("girl_id", "=", $girls->id)->first();
            $seachSettings = $girls->seachsettings()->first();
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

            $girls = DB::table('girls')->find(3);

            return response()->json($girls);
        } else {
            //    dump($seachSettings);
        }

        $girls = DB::table('girls');
        $girls = $girls->leftJoin('girl_target', 'girls.id', '=',
            'girl_target.girl_id');
        $girls = $girls->leftJoin('girl_interess', 'girls.id', '=',
            'girl_interess.girl_id');

        if ($seachSettings->age_from != null) {
            $girls->where('age', '>=', $seachSettings->age_from);
        }
        //dump($seachSettings);
        if ($seachSettings->age_to != null) {
            $girls->where('age', '<=', $seachSettings->age_to);
        }

        $targets = $seachSettings->target()->get();
        foreach ($targets as $target) {
            //      $girls->where('target_id', $target->id);
        }

        $interest = $seachSettings->interest()->get();
        foreach ($interest as $item) {
            //        $girls->where('interest_id', $item->id);
        }

        //нужно получиь число
        $count = $girls->count();
        $pum_pages = intval($count / $this->limit);


        $girls->select('girls.*')->limit($this->limit);


        if (isset($request->page) && intval($request->page) != 1) {
            $girls->offset($this->limit);
        }

        $girls = $girls->get();

        return response()->json([
            'ankets'    => $girls,
            'count'     => $count,
            'num_pages' => $pum_pages,
        ]);
    }
}
