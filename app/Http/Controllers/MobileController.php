<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileController extends Controller
{
    //
    public function index(Request $request)
    {
        $agent = new \Jenssegers\Agent\Agent;


        $result = $agent->isMobile();
        dd($result);

    }
}
