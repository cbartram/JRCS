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
        //Remove out sessions
        Session::forget('is_logged_in');
        Session::forget('id');
        Session::forget('email');
        Session::forget('user');
        Session::forget('group');

        //Redirect user back
        return Redirect::to('/');
    }
}
