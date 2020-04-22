<?php

namespace App\Http\Controllers;

use App\SeachSettingsType;
use App\SearchSettings;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use File;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use  \App\Application;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Storage;

use DateTime;
use App\User;
use App\Girl;
use App\Myevent;
use App\EventStatys;
use App\EventPhoto;
use App\Photo;
use App\Aperance;
use App\Relationh;
use App\Children;
use App\Smoking;
use GuzzleHttp\Client;
use Symfony\Component\Filesystem\Exception\IOException;


class GirlsController extends Controller
{

    function index(Request $request)
    {
        /*
         *логика перенаправления на карусель лайков
         *
         * 1) Смотрим Cookie
         * 2) Если нет то ставим
         * 3) И перенаправляем
         *
         * */

        if (!isset($_COOKIE["causel"])) {
            Cookie::queue("causel", AnketController::randomString(), 10);

            return redirect('/like-carusel');
        }


        return view('index2');
    }


    public function showGirl($id, Request $request)
    {

        $girl = Girl::select([
            'name',
            'id',
            'description',
            'main_image',
            'sex',
            'meet',
            'weight',
            'height',
            'age',
            'country_id',
            'region_id',
            'city_id',
            'status',
            'banned',
            'user_id',
            'phone',
            'phone_settings',
            'status',
            'views_all',
            'last_login',
            'from_age',
            'to_age',
            'apperance_id',
            'relation_id',
            'children_id',
            'smoking_id',
        ])->where('id', $id)->first();

        if ($girl == null) {
            return view('anket.404');
        }
        $images = $girl->photos()->get();

        $AythUser = Auth::user();

        $privatephoto = null;

        $targets = $girl->target()->get();
        if (count($targets) == 0) {
            $targets = null;
        }


        //интересы
        $interes = $girl->interest()->get();

        //счетчик просмотров
        $views = $girl->views_all;
        $views = $views + 1;
        $girl->views_all = $views;

        $girl->save();
        $utm_source = null;
        $girl->saveView();
        $phone_settings = $girl->getPhoneSettings();

        if (count($interes) == 0) {
            $interes = null;
        }

        //авв сшен
        if ($girl->city_id != null) {
            $city = $girl->city()->first();
            $region = null;
        } else {
            $city = null;
            $region = null;
        }
        $aperance = $girl->aperance()->first();
        if (empty ($aperance)) {
            $aperance = null;
        }

        $relation = $girl->relation()->first();
        if (empty ($relation)) {
            $relation = null;
        }

        $children = $girl->children()->first();
        if (empty ($children)) {
            $children = null;
        }

        $smoking = Smoking::select(['id', 'name'])
            ->where('id', $girl->smoking_id)->first();
        if (empty ($smoking)) {
            $smoking = null;
        }

        $last_login = $girl->lastLoginFormat();


        $url = $request->header('referer');

        return view('anket.view2')->with([
            'girl'           => $girl,
            'images'         => $images,
            'privatephotos'  => $privatephoto,
            'targets'        => $targets,
            'city'           => $city,
            'region'         => $region,
            'interes'        => $interes,
            'phone_settings' => $phone_settings,
            'phone'          => $girl->phone,
            'last_login'     => $last_login,
            'views'          => $views,
            'aperance'       => $aperance,
            'relation'       => $relation,
            'children'       => $children,
            'smoking'        => $smoking,
            'prevesion_page' => $url,
        ]);

    }


    public function inputPhone(
        Request $request
    ) {
        $validatedData = $request->validate([
            'phone' => 'required|numeric|min:11',
        ]);

        $phone = $request->phone;
        $user = collect(DB::select('select * from users where phone like ?',
            [$phone]))->first();
        if ($user != null and $user->phone_confirmed == 1) {
            return response()->json(['result' => 'alredy']);
        }
        $user = Auth::user();
        //если найден,то
        //1)генерируем проль для отправки
        $user->phone = $phone;
        $activeCode = rand(1000, 9999);
        $user->active_code = $activeCode;
        $user->save();
        //2) отправляем его в смс
        // App::call('App\Http\Controllers\GirlsController@sendSMS', [$phone, $activeCode]);
        //  $this->sendSMS($phone, $activeCode);

        return response()->json(['result' => 'ok']);
    }


    public function inputCode(
        Request $request
    ) {
        $validatedData = $request->validate([
            'code' => 'required|numeric|min:11',
        ]);

        $inputCode = $request->code;
        $user = Auth::user();
        if ($user->active_code == $inputCode) {
            $user->phone_confirmed = 1;
            $user->save();

            return response()->json(['result' => 'ok']);
        } else {
            return response()->json(['result' => 'wrongCode']);
        }
    }

    public static function SendSMS(
        $phone,
        $text
    ) {
        $src
            = '<?xml version="1.0" encoding="UTF-8"?>
        <SMS>
            <operations>
            <operation>SEND</operation>
            </operations>
            <authentification>
            <username>aaaaaaaaaa</username>
            <password>aaaa@aaa.ru</password>
            </authentification>
            <message>
            <sender>SMS</sender>
            <text>'.$text.'</text>
            </message>
            <numbers>
            <number messageID="msg11">'.$phone.'</number>
            </numbers>
        </SMS>';
        $Curl = curl_init();
        $CurlOptions = array(
            CURLOPT_URL            => 'http://api.atompark.com/members/sms/xml.php',
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_POST           => true,
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT        => 100,
            CURLOPT_POSTFIELDS     => array('XML' => $src),
        );
        curl_setopt_array($Curl, $CurlOptions);
        if (false === ($Result = curl_exec($Curl))) {
            throw new Exception('Http request failed');
        }
        curl_close($Curl);
    }


    public function filter_enable(Request $request)
    {
        $AythUser = Auth::user();
        if ($AythUser == null) {
            $cookie = Cookie::get('seachSettings');

            if ($cookie != null) {

                $seachSettings = SearchSettings::select([
                    'id',
                    'girl_id',
                    'meet',
                    'age_from',
                    'age_to',
                    'children',
                ])->where('cookie', $cookie)
                    ->first();
                if ($seachSettings == null) {
                    $seachSettings = new SearchSettings();
                    $seachSettings->cookie = $cookie;
                    $seachSettings->save();
                }
                if ($request->filter == "true") {
                    $seachSettings->enable = 1;
                } else {
                    $seachSettings->enable = 0;
                }
                $seachSettings->save();

            } else {
                $seachSettings = new SearchSettings();
                $cookie = sha1(time());
                Cookie::queue('seachSettings', $cookie, 1000);
                $seachSettings->cookie = $cookie;
                if ($request->filter == "true") {
                    $seachSettings->enable = 1;
                } else {
                    $seachSettings->enable = 0;
                }
                $seachSettings->save();
            }
        } else {
            $ayth_girl = Girl::select('id', 'user_id')
                ->where('user_id', $AythUser->id)->first();

            if ($ayth_girl == null) {
                return null;
            }
            $ayth_girl->filter_enable = 1;
            $ayth_girl->save();
        }

        return "true";
    }


}
