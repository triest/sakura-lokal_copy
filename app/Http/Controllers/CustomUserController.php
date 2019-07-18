<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Comment;
use App\Jobs\SendMessageAboutEvent;

use Response;
use Symfony\Component\Filesystem\Exception\IOException;

use Auth;

use App\Repositories\ImageRepository;

use App\User;


use settype;
use Hash;


class CustomUserController extends Controller
{
    //
    function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->phone_confirmed == 1) {
                return redirect('anket');
            } else {
                return view('custom.resetSMS');
            }
        }

        return view('custom.registration');
    }

    public function join(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'you' => 'required',
            'kogo' => 'required',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;

        /* $user->you = $request->you;
         $user->kogo = $request->kogo;*/
        $user->password = bcrypt($request->password);

        //генерируем код
        do {
            $token = str_random(40);;
            $code = 'EN'.$token.substr(strftime("%Y", time()), 2);
            $user_code = User::where('account', $code)->get();
        } while (!$user_code->isEmpty());
        $user->account = $user_code;

        $user->save();
        Auth::loginUsingId($user->id);
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $file = 'send_mail_log.txt';
        try {
            SendMessageAboutEvent::dispatch("New User ".$user->name, 'triest21@gmail.com', $user->name, "new user");
            $file = 'send_mail_log.txt';
            $text = $user->name.$date;
            file_put_contents($file, $text);
        } catch (IOException $e) {
            $file = 'send_mail_error_log.txt';

            $text = $user->name.":".$date.":";
            file_put_contents($file, $text);
        }

        return view('custom.resetSMS2');
    }
}
