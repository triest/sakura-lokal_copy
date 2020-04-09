<?php

namespace App;

use App\Http\Controllers\GirlsController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class City extends Model
{
    //
    protected $table = "cityes_api";

    public static function GetCurrentCity()
    {
        $ip = GirlsController::getIpStatic();
        $response = file_get_contents("http://api.sypexgeo.net/json/"
            .$ip); //запрашиваем местоположение
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
            dump($response);
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
        }

        return $city;
    }
}
