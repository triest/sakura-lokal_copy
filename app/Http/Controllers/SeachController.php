<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeachController extends Controller
{
    //
    public function index()
    {
        return view("search.index");
    }
}
