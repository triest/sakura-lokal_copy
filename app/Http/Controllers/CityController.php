<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    //

    public static function GetCurrentCity()
    {
        $city = City::GetCurrentCity();
        dump($city);
    }
}
