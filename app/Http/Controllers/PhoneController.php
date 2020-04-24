<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhoneController extends Controller
{
    //

    public function sendCode(Request $request)
    {
        $code = Input::get('code');
        $user = Auth::user();
        if ($user->phone_conferd == 1) {
            return response()->json(['result' => 'alredy']);
        }
        if ($code == $user->actice_code) {
            $user->phone_conferd = 1;
            $user->save();

            return response()->json(['answer' => 'ok']);
        } else {
            return response()->json(['result' => 'fail']);
        }
    }

    public function sendSms2(Request $request)
    {
        $phone = Input::get('phone');
        $user = collect(DB::select('select * from users where phone like ?',
            [$phone]))->first();
        //   dump($user);
        if ($user != null and $user->phone_conferd == 1) {
            //echo 'Phone alredy exist!';
            return response()->json(['result' => 'alredy']);
        }
        $user = Auth::user();
        //если найден,то
        //1)генерируем проль для отправки
        $user->phone = $phone;
        $activeCode = rand(1000, 9999);
        $user->actice_code = $activeCode;
        $user->save();
        //2) отправляем его в смс
        App::call('App\Http\Controllers\GirlsController@sendSMS',
            [$phone, $activeCode]);

        return response()->json(['result' => 'ok']);
    }
}
