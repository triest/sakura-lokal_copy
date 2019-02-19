<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use Storage;
use DateTime;
use App\User;
use App\Girl;

class GirlsController extends Controller
{
    //
    function index()
    {
        if (Auth::check()) {
            $user = Auth::user();  // и если админ
            if ($user->isAdmin == 1) {
                $girls = Girl::select(['id', 'name', 'login', 'email', 'phone', 'main_image', 'description', 'banned'])
                        ->orderBy('created_at', 'DESC')->simplePaginate(9);
            } else {
                $girls = Girl::select(['id', 'name', 'login', 'email', 'phone', 'main_image', 'description', 'sex'])
                        ->where('banned', '=', '0')
                        ->orderBy('created_at', 'DESC')
                        ->Paginate(9);
            }
        } else {
            $girls = Girl::select(['id', 'name', 'login', 'email', 'phone', 'main_image', 'description', 'sex'])
                    ->where('banned', '=', '0')
                    ->orderBy('created_at', 'DESC')
                    ->Paginate(9);
        }
        $user = Auth::user();


        return view('index')->with(['girls' => $girls]);
    }


}
