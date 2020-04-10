<?php

namespace App\Http\Controllers\Auth;


use App\City;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/anket';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        if (is_numeric($request->get('email'))) {
            return [
                'phone'    => $request->get('email'),
                'password' => $request->get('password'),
            ];
        }

        return $request->only($this->username(), 'password');
    }

    function authenticated(Request $request, $user)
    {
        //тут когда последний раз заходил
        $id = $user->get_girl_id();
        if ($id != null) {
            DB::table('girls')
                ->where('id', $id)
                ->update(['last_login' => Carbon::now()->toDateTimeString()]);

            $city = City::GetCurrentCity();
            $anket = $user->anketisExsis();
            if ($anket != null && $city != null) {
                $anket->city_id = $city->id;
                $anket->save();
            }
        }

    }

}
