<?php

namespace App\Http\Controllers;

use App\Cico;
use App\Profile;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

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
                $cico->id = $q->id;
                $cico->email = Input::get('email');
                $cico->volunteer_group = $q->bebco_volunteer; //todo get group from their id
                $cico->volunteer_program = Input::get('program');
                $cico->volunteer_type = Input::get('type');
                $cico->check_in_timestamp = Input::get('timestamp');
                $cico->check_out_timestamp = 'null';

                $cico->save();

                return "true";


            } else {
                //we found a row where they have not yet checked out yet
                return "false";
            }
        }

        return "true";
    }

}
