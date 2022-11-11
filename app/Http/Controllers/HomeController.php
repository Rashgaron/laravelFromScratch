<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function home()
    {
        Auth::id();
        return view('home.index');
    }

    public function contact()
    {
        return view('home.contact');
    }
}

// an action is a controller method bound to a route