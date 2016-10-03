<?php

namespace App\Http\Controllers;

use App\Cico;
use App\Profile;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CicoController extends Controller
{
    public function checkIn() {

        //Get the first row back from the query
        $q = DB::table('profiles')->where('email', '=', Input::get('email'))->limit(1)->get()->first();

        //The wrong email was sent through the form
        if($q == null) {
            return "email";
        } else {
            //Construct a new query to see if the user has checked out from their previous checkin

            $query = Cico::where('email', '=', Input::get('email'))
                ->where('check_out_timestamp', '=', 'null')
                ->get()
                ->first();
            //if we could not find an entry where their check-out was null
            if($query == null) {
                //insert a new record for the volunteer clocking in
                $cico = new Cico;
                //todo this is a primary key being inserted here which means a volunteer cant check in more than once not good
                $cico->id = Str::random();
                $cico->email = Input::get('email');
                $cico->volunteer_group = $q->bebco_volunteer; //todo get group from their id
                $cico->volunteer_program = Input::get('program');
                $cico->volunteer_type = Input::get('type');
                $cico->check_in_timestamp = date('Y-m-d G:i:s');
                $cico->check_out_timestamp = 'null';

                $cico->save();

                return "true";


            } else {
                //we found a row where they have not yet checked out yet
                return "false";
            }
        }
    }

    public function index() {
        return view('checkout');
    }

    public function checkOut() {
        $volunteer = Cico::where('email', '=', Input::get('email'))->get()->first();
        if($volunteer != null) {
            //check to see if there is a volunteer with check_out_timestamp = null
            if ($volunteer->check_out_timestamp == "null") {
                $timestamp = date('Y-m-d G:i:s');
                $volunteer->check_out_timestamp = $timestamp;
                $volunteer->save();

                Session::flash('alert-success', 'You have been successfully checked out!');
                return Redirect::back();
            } else {
                Session::flash('alert-danger', 'You need to check-in before you can check out!');
                return Redirect::back();
            }
        } else {
            Session::flash('alert-danger', 'The email you entered was incorrect...');
            return Redirect::back();
        }
    }

}
