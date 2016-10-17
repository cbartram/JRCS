<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SwitchController extends Controller
{
    public function index($group) {
        //The new group is the group required to switch too
        Session::put('group', $group);

        return Redirect::to('/profile');
    }
}
