<?php

namespace App\Http\Controllers;

use App\Aperance;
use App\Children;
use App\Girl;
use App\Interest;
use App\Relationh;
use App\SearchSettings;
use App\Smoking;
use App\Target;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

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
            $Autchgirls = $girls[0];
            //  $seachSettings = SearchSettings::select(['id'])
            //     ->where("girl_id", "=", $girls->id)->first();
            $seachSettings = $Autchgirls->seachsettings()->first();
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
                $girls->where('id', '<>', $Autchgirls->id);
            }
            $girls = $girls->orderByDesc('created_at')->get();
            $count = $girls->count();
            $num_pages = intval($count / $this->limit);

            return response()->json([
                'ankets'    => $girls,
                'count'     => $count,
                'num_pages' => $num_pages,
            ]);

        } else {

        }

        $girls = DB::table('girls');
        /*
        $girls = $girls->leftJoin('girl_target', 'girls.id', '=',
            'girl_target.girl_id');
        $girls = $girls->leftJoin('girl_interess', 'girls.id', '=',
            'girl_interess.girl_id');
*/
        if ($seachSettings->age_from != null) {
            $girls->where('age', '>=', $seachSettings->age_from);
        }

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
        $num_pages = intval($count / $this->limit);


        $girls->select('girls.*')->limit($this->limit);


        if (isset($request->page) && $request->page != null
            && intval($request->page) != 1
        ) {
            $offset = $this->limit * (intval($request->page) - 1);
            $girls->offset($offset);
        }

        $girls->orderByDesc('created_at');

        $girls = $girls->get();

        return response()->json([
            'ankets'    => $girls,
            'count'     => $count,
            'num_pages' => $num_pages,
        ]);
    }


    public function getSettings(Request $request)
    {


        /*
         * теперь над получать цели
         * */


        $targets = Target::select(['id', 'name'])->get();
        $interests = Interest::select(['id', 'name'])->get();
        $aperance_array = array();
        $apperance = Aperance::select(['id', 'name'])->get();
        $relations = Relationh::select(['id', 'name'])->get();
        $chidren = Children::select(['id', 'name'])->get();
        $smoking = Smoking::select(['id', 'name'])->get();

        foreach ($apperance as $item) {
            $aperance_array[] = $item->id;
        }


        $userAuth = Auth::user();
        if ($userAuth != null) {
            $user = User::select(['id', 'name'])
                ->where('id', $userAuth->id)->first();
            $anket = $user->girl()->first();

            $selectedTargets = $anket->target(['id', 'name'])->get();
            $targets_array = array();
            foreach ($selectedTargets as $item) {
                $targets_array[] = $item->id;
            }


            $selectedInteres = $anket->interest(['id', 'name'])->get();
            $interest_array = array();
            foreach ($selectedInteres as $item) {
                $interest_array[] = $item->id;
            }

            //;jcnftv j,obt yfcnhjqrb
            $sechSettings = SearchSettings::select([
                'id',
                'girl_id',
                'meet',
                'age_from',
                'age_to',
                'children',
            ])->where('girl_id', $anket->id)->first();
        } else {
            $cookie = Cookie::get('seachSettings');
            if (isset($_COOKIE["seachSettings"])) {
                $cookie = $_COOKIE["seachSettings"];
            }

            if ($cookie != null) {
                $sechSettings = SearchSettings::select([
                    'id',
                    'girl_id',
                    'meet',
                    'age_from',
                    'age_to',
                    'children',
                ])
                    ->where('cookie', $cookie)->first();
            }
        }

        //тут получаем установленные настройки.
        if (isset($sechSettings) && $sechSettings != null) {
            $interest_array_temp = $sechSettings->interest()->get();

            $interest_array = array();
            foreach ($interest_array_temp as $item) {
                $interest_array[] = $item->id;
            }


            $targets_array_temp = $sechSettings->target()->get();
            $targets_array = array();
            foreach ($targets_array_temp as $item) {
                //     array_push($targets_array, $item->id);
                $targets_array[] = $item->id;
            }

        }

        if (!isset($anket)) {
            $anket = null;
        }
        if (!isset($targets_array)) {
            $targets_array = array();
        }
        if (!isset($interest_array)) {
            $interest_array = array();
        }
        if (!isset($sechSettings)) {
            $sechSettings = array();
        }

        return \response()->json([
            "anket"            => $anket,
            "targets"          => $targets,
            "selectedTargets"  => $targets_array,
            "interests"        => $interests,
            "selectedInterest" => $interest_array,
            "apperance"        => $apperance,
            "relations"        => $relations,
            "chidren"          => $chidren,
            "sechSettings"     => $sechSettings,
            "smoking"          => $smoking,

        ]);

    }

    public function saveSettings(Request $request)
    {

        /*
              $cookie = null;
              $userAuth = Auth::user();
              if ($userAuth != null) {
                  $user = User::select(['id', 'name'])
                      ->where('id', $userAuth->id)->first();
                  //сли не авторизован, то смотрим по кукам.
                  if ($user != null) {
                      $anket = Girl::select(['id', 'name'])
                          ->where('user_id', $user->id)
                          ->first();
                      if ($anket == null) {
                          return false;
                      }
                      $seachSettings = $anket->seachsettings()->first();
                  } else {
                      $cookie = Cookie::get('seachSettings');
                      $seachSettings = SearchSettings::select(['*'])
                          ->where("cookie", "=", $cookie)->first();
                  }
              } else {
                  $cookie = Cookie::get('seachSettings');
                  if ($cookie != null) {
                      $seachSettings = SearchSettings::select(['*'])
                          ->where("cookie", "=", $cookie)->first();
                  }
              }

              if (isset($seachSettings) && $seachSettings == null) {
                  $seachSettings = new SearchSettings();
                  $seachSettings->girl_id = $anket->id;
                  $seachSettings->save();
              } elseif (isset($cookie) && $cookie != null && isset($seachSettings)
                  && $seachSettings == null
              ) {
                  $seachSettings = new SearchSettings();
                  $seachSettings->cookie = $cookie;
                  $seachSettings->save();
              } elseif (!isset($seachSettings) && $cookie == null) {
                  $seachSettings = new SearchSettings();
                  $seachSettings->meet = $request->meet;
                  $seachSettings->age_from = $request->from;
                  $seachSettings->age_to = $request->to;
                  $seachSettings->children = $request->children;
                  // тут генерируем куку
                  $value = $this->randomString();
                  $seachSettings->cookie = $value;
                  Cookie::queue(Cookie::make('seachSettings', $value, 1140));
                  $seachSettings->save();
                  if ($userAuth != null) {
                      $user = User::select(['id', 'name'])
                          ->where('id', $userAuth->id)->first();
                      //сли не авторизован, то смотрим по кукам.
                      if ($user != null) {
                          $anket = Girl::select(['id', 'name'])
                              ->where('user_id', $user->id)
                              ->first();
                          if ($anket == null) {
                              return false;
                          }
                          $seachSettings->girl_id = $anket->id;
                      } else {
                          $cookie = Cookie::get('seachSettings');

                      }
                  } else {
                      $cookie = Cookie::get('seachSettings');
                      if ($cookie != null) {
                          $seachSettings = SearchSettings::select([])
                              ->where("cookie", $cookie)->first();
                      }
                  }
              }

              if (isset($seachSettings) && $seachSettings != null) {
                  $seachSettings->meet = $request->meet;
                  $seachSettings->age_from = $request->from;
                  $seachSettings->age_to = $request->to;
                  $seachSettings->children = $request->children;
                  $seachSettings->save();
              }
              //теперь настройки поиска
              dump($seachSettings);
              $selectedTargets = $request->select_target;
              dump($request);

              foreach ($selectedTargets as $target) {
                  $setting = new SeachSettingsInterest();
                  $setting->settings_id = $seachSettings->id;
                  $setting->setting_name = "target";
                  $setting->sett_id = $target;
                  $setting->save();
              }
      */
        $seachSettings = SearchSettings::getSeachSettings();
        if ($seachSettings == null) {
            return null;
        }
        $userAuth = Auth::user();


        $selectedTargets = $request->targets;
        foreach ($selectedTargets as $item) {
            $target = Target::select(['id', 'name'])->where('id', $item)
                ->first();
            if ($target != null) {
                $seachSettings->target()->save($target);
            }
        }

        $selectedTargets = $request->interests;
        foreach ($selectedTargets as $item) {
            $target = Interest::select(['id', 'name'])->where('id', $item)
                ->first();
            if ($target != null) {
                $seachSettings->interest()->save($target);
            }
        }

        return response()->json(['ok']);
    }
}
