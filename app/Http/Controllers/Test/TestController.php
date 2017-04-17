<?php

namespace App\Http\Controllers\Test;

use App\Cico;
use App\Events\TestEvent;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\StaffProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Vinkla\Pusher\Facades\Pusher;
use Vinkla\Pusher\PusherManager;

class TestController extends Controller
{
    /**
     * A place to test methods or functions using a get request
     * this function is tied to the route 'http://localhost:8000/test'
     *
     * By default this returns a test view which can be located in views/test/test.blade.php
     */
    public function testGet()
    {
       //
    }

    /**
     * A place to test methods or functions using a post request
     * this function is also tied to the route 'http://localhost:8000/test'
     */
    public function testPost()
    {
      //
    }

}
