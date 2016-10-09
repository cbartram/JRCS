<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function index() {
        //Remove all sessions
        Session::flush();

        //Redirect user back
        return Redirect::to('/');
    }
}
