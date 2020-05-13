<?php

    namespace App;

    use App\Http\Controllers\GirlsController;
    use http\Env\Request;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;
    use Symfony\Component\Filesystem\Exception\IOException;

    class City extends Model
    {
        //
        protected $table = "cityes_api";

        public static function GetCurrentCity()
        {
            $ip = User::getIpStatic();
            $response = file_get_contents("http://api.sypexgeo.net/json/" . $ip);
            $response = json_decode($response);
            $okato = $response->city->okato;
            $city = City::select([
                    'id',
                    'name',
                    'OKATO',
            ])->where('OKATO', '=', intval($okato))->first();


            if ($city == null) {
                $name = $response->city->name_ru;
                $response
                        = file_get_contents("https://kladr-api.ru/api.php?contentType=city&withParent=1&limit=10&query=$name");
                $response = json_decode($response);
                $result = $response->result;
                $city = City::select([
                        'id',
                        'name',
                        'OKATO',
                ])->where('OKATO', $okato)->first();
                if ($city == null) {
                    $city = new  City();
                    $city->name = $result[1]->name;
                    $city->OKATO = substr($result[1]->okato, 0, 8);
                    $city->PARANTS_OKATO = $result[1]->parents[0]->okato;
                    $city->save();
                }

                return $city;
            } else {
                return $city;
            }
        }

        public static function get($id)
        {
            $city = City::select(['*'])->where('id', $id)->first();

            return $city;
        }

        public function girl()
        {
            return $this->belongsTo('App\Girl', 'city_id');
        }


        public function newCity(
                Request $request
        ) {
            $validatedData = $request->validate([
                    'city' => 'required',
            ]);

            $city = $request->city;

            if ($city == null) {
                return redirect('/anket');
            } else {
                $request->session()->put('city', $request->city);

                return redirect('/anket');
            }

        }

        public static function checkCity()
        {
            if (Auth::user()) {
                $user = Auth::user()->first();

                $girl = $user->anketisExsis();
                $girl = Girl::select(['id'])->where('user_id', $user->id)->first();

                if ($girl == null) {
                    return null;
                } else {
                    $city = $girl->city_id;
                    $city = DB::table('cities')->where('id_city', $city)->first();

                    return $city;
                }

            }


            $city = session()->get('city');
            if ($city != null) {//
                //dump($city);
                $city = Session::get('city');
                try {
                    $city = DB::table('cities')->where('id_city', $city)->first();
                    if ($city == null) {
                        $girlcController = new GirlsController();

                        return $girlcController->getCityByIpAndRedirect2();
                    }
                } catch (IOException $e) {
                    return null;
                }
                $events = Myevent::select('id', 'name', 'city_id', 'begin', 'end',
                        'place')->where('city_id',
                        $city->id_city)->get();

                return $city;
            } else {
                $girlcController = new GirlsController();

                return $girlcController->getCityByIpAndRedirect2();
            }
        }

        public static function getCityByIpAndRedirect2()
        {
            $ip = User::getIpStatic();
            $response = file_get_contents("http://api.sypexgeo.net/json/"
                    . $ip); //запрашиваем местоположение
            $response = json_decode($response);
            $name = $response->city->name_ru;

            $cities = DB::table('cities')->where('name', 'like', $name . '%')
                    ->first();
            $response = file_get_contents("http://api.sypexgeo.net/json/"
                    . $ip); //запрашиваем местоположение
            $response = json_decode($response);

            return view('confurmCity')->with(['city' => $response]);
        }

        public function getCityByIpAndRedirect()
        {
            $ip = User::getIpStatic();
            $response = file_get_contents("http://api.sypexgeo.net/json/"
                    . $ip); //запрашиваем местоположение
            $response = json_decode($response);
            $name = $response->city->name_ru;

            $cities = DB::table('cities')->where('name', 'like', $name . '%')
                    ->first();
            $response = file_get_contents("http://api.sypexgeo.net/json/"
                    . $ip); //запрашиваем местоположение
            $response = json_decode($response);

            return view('confurmCity')->with(['city' => $response]);
        }

        public function changeCity()
        {
            $city = Session::get('city');
            $city = DB::table('cities')->where('id_city', $city)->first();

            return view('changeCity')->with(['city' => $city]);
        }

        public static function findcity($name)
        {
            //echo $name;
            $cities = DB::table('cities')->where('name', 'like', $name . '%')->get();

            return response()->json([$cities]);
        }

        public static function findcity2($name)
        {
            /*
             * 1) Ищим по имени в таблице
             *
             * 2) Если нет, то шлем запрос на api
             *
             * 3) Добавляем в таблицу
            */
            $cities = DB::table('cityes_api')->where('name', 'like', '%' . $name . '%')
                    ->get();


            if ($cities->isEmpty()) {
                $response
                        = file_get_contents("https://kladr-api.ru/api.php?contentType=city&withParent=1&limit=10&query=$name");
                $response = json_decode($response);
                $result = $response->result;

                $cities = DB::table('cityes_api')
                        ->where('OKATO', 'like', '%' . $result[1]->oktmo . '%')
                        ->get();
                dump($cities);

                if ($cities->isEmpty()) {
                    DB::table('cityes_api')->insert(
                            [
                                    'name' => $result[1]->name,
                                    'OKATO' => $result[1]->oktmo,
                                    'PARANTS_OKATO' => $result[1]->parents[0]->okato,
                            ]
                    );
                    $cities = DB::table('cityes_api')
                            ->where('name', 'like', $name . '%')
                            ->get();
                }
            }

            return response()->json($cities);
        }


    }