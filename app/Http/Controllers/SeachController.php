<?php

    namespace App\Http\Controllers;

    use App\Aperance;
    use App\Children;
    use App\City;
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

            $userAuth = Auth::user();
            if ($userAuth != null) {
                $Autchgirls = $userAuth->girl()->first();

                if ($Autchgirls != null) {
                    $seachSettings = $Autchgirls->seachsettings()->first();
                }
            } else {

                if (isset($_COOKIE["seachSettings"])) {
                    $cookie = $_COOKIE["seachSettings"];
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
                }

                $city = City::GetCurrentCity();

                if ($city != null) {
                    $girls->where('city_id', $city->id);
                }
                $count = $girls->count();
                if (isset($_GET['page']) && intval($_GET['page']) > 1) {
                    $page = intval($_GET['page']);
                    $offset = $this->limit * ($page);
                    $girls->offset($offset);
                }

                $num_pages = intval($count / $this->limit);
                $girls->limit($this->limit);
                $girls->orderByDesc('created_at')->get();
                $girls = $girls->get();

                return response()->json([
                        'ankets' => $girls,
                        'count' => $count,
                        'num_pages' => $num_pages,
                ]);

            }

            $girls = DB::table('girls');

            $interest = $seachSettings->interest()->get();


            if ($interest->isNotEmpty()) {
                $girls->leftJoin('girl_interess', 'girl_interess.girl_id', '=',
                        'girls.id');
                // надо плдучить массив id штеукуыщцж
                $interest_array = array();
                foreach ($interest as $item) {
                    array_push($interest_array, $item->id);
                }

                $girls->whereIn('girl_interess.interest_id', $interest_array);
            }

            $targets = $seachSettings->target()->get();

            if ($targets->isNotEmpty()) {
                $girls->leftJoin('girl_target', 'girl_target.girl_id', '=',
                        'girls.id');
                // надо плдучить массив id штеукуыщцж
                $interest_array = array();
                foreach ($targets as $item) {
                    array_push($interest_array, $item->id);
                }

                $girls->whereIn('girl_target.target_id', $interest_array);
            }


            if ($seachSettings->children != null || $seachSettings->children != 0) {
                $girls->where('children_id', '=', $seachSettings->children);
            }

            $city = City::GetCurrentCity();

            if ($city != null) {
                $girls->where('city_id', $city->id);
            }


            if ($seachSettings->age_from != null) {
                $girls->where('age', '>=', $seachSettings->age_from);
            }


            if ($seachSettings->age_to != null) {
                $girls->where('age', '<=', $seachSettings->age_to);
            }

            if ($seachSettings->meet != null
                    && $seachSettings->meet != "nomatter"
            ) {
                $girls->where('sex', '=', $seachSettings->meet);
            }

            if (isset($seachSettings) && $seachSettings->relation != 0) {
                $girls->where('relation_id', '=', $seachSettings->relation);
            }

            if (isset($Autchgirls) && $Autchgirls != null) {
                $girls->where('girls.id', '!=', $Autchgirls->id);
            }

            $count = $girls->count();
            $num_pages = intval($count / $this->limit);

            $girls->select('girls.*')->limit($this->limit);


            if (isset($_GET['page']) && intval($_GET['page']) > 1) {

                $page = intval($_GET['page']);
                $offset = $this->limit * ($page);

                $girls->offset($offset);
            }

            $girls->orderByDesc('created_at');

            $girls = $girls->get();

            return response()->json([
                    'ankets' => $girls,
                    'count' => $count,
                    'num_pages' => $num_pages,
            ]);
        }


        public function getSettings(Request $request)
        {


            /*
             * ������ ��� �������� ����
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
                if (isset($_COOKIE["seachSettings"])) {
                    $cookie = $_COOKIE["seachSettings"];
                } else {
                    $cookie = null;
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

            //��� �������� ������������� ���������.
            if (isset($sechSettings) && $sechSettings != null) {
                $interest_array_temp = $sechSettings->interest()->get();

                $interest_array = array();
                foreach ($interest_array_temp as $item) {
                    $interest_array[] = $item->id;
                }


                $targets_array_temp = $sechSettings->target()->get();

                $targets_array = array();
                foreach ($targets_array_temp as $item) {
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


            $seachSettingsArray = array();
            if (!empty($sechSettings)) {
                $seachSettingsArray['id'] = $sechSettings->id;
                $seachSettingsArray['girl_id'] = $sechSettings->girl_id;
                $seachSettingsArray['meet'] = $sechSettings->meet;
                $seachSettingsArray['age_from'] = $sechSettings->age_from;
                $seachSettingsArray['age_to'] = $sechSettings->age_to;
                $seachSettingsArray['children'] = $sechSettings->children;
            }

            return \response()->json([
                    "anket" => $anket,
                    "targets" => $targets,
                    "selectedTargets" => $targets_array,
                    "interests" => $interests,
                    "selectedInterest" => $interest_array,
                    "apperance" => $apperance,
                    "relations" => $relations,
                    "chidren" => $chidren,
                    "sechSettings" => $seachSettingsArray,
                    "smoking" => $smoking,

            ]);

        }

        public function saveSettings(Request $request)
        {
            $seachSettings = SearchSettings::getSeachSettings();


            if ($seachSettings == null) {
                return null;
            }

            if (isset($request->children)) {
                $seachSettings->children = $request->children;
            }

            if (isset($request->from)) {
                $seachSettings->age_from = $request->from;
            }

            if (isset($request->to)) {
                $seachSettings->age_to = $request->to;
            }

            if (isset($request->meet)) {
                $seachSettings->meet = $request->meet;
            }

            if (isset($request->relation) && !empty($request->relation)) {
                $seachSettings->relation = $request->relation;
            }

            $seachSettings->save();

            $seachSettings->target()->detach();
            $selectedTargets = $request->targets;
            foreach ($selectedTargets as $item) {
                $target = Target::select(['id', 'name'])->where('id', $item)
                        ->first();
                if ($target != null) {
                    $seachSettings->target()->save($target);
                }
            }
            $seachSettings->interest()->detach();
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

        public function changeFilter(Request $request)
        {
            $userAuth = Auth::user();
            if ($userAuth == null) {
                return false;
            }
            $user = User::select(['id', 'name'])
                    ->where('id', $userAuth->id)->first();
            if ($user == null) {
                return false;
            }
            $anket = Girl::select(['id', 'name', 'filter_enable'])
                    ->where('user_id', $user->id)
                    ->first();
            if ($anket == null) {
                return false;
            }


            if ($anket->filter_enable == 0) {
                Girl::where('user_id', $user->id)
                        ->update(['filter_enable' => 1]);

                DB::table('girls')->where('user_id', $user->id)
                        ->update(['filter_enable' => 1]);
            } else {
                DB::table('girls')->where('user_id', $user->id)
                        ->update(['filter_enable' => 0]);
            }


            return response()->json(['ok']);
        }
    }
