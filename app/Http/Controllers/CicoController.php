<?php

namespace App\Http\Controllers;

use App\Cico;
use App\Helpers\Helpers;
use App\Profile;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CicoController extends Controller
{

    /**
     * Handles checking a user in via there email
     * @return string Return status
     */
    public function checkIn() {
       $email = Input::get('email');
       $date = date('Y-m-d');

        //Get the first row back from the query
        $q = Profile::where('email', $email)->limit(1)->first();

        //The wrong email was sent through the form
        if($q == null) {
            return "email";

        } else {
            //Construct a new query to see if the user has checked out from their previous check-in
            $query = Cico::where('email', $email)
                ->where('check_out_timestamp', 'null')
                ->get()
                ->first();

            //if we could not find an entry where their check-out was null
            if($query == null) {

                //Find the correct group for the staff member
                $groups = ['BEBCO', 'JACO', 'JBC'];
                $volunteer_group = "";
                for($i = 0; $i < 3; $i++) {
                    if(Helpers::isMemberOf($groups[$i], $q->id)) {
                        $volunteer_group .= ($groups[$i] . ",");
                    }
                }
                
                //insert a new record for the volunteer clocking in
                $cico = new Cico;
                $cico->id = $q->id;
                $cico->email = $email;
                $cico->volunteer_group = $volunteer_group;
                $cico->volunteer_program = Input::get('program');
                $cico->volunteer_type = Input::get('type');
                $cico->check_in_timestamp = $date . ' ' . Carbon::now()->format('g:i A');
                $cico->check_out_timestamp = 'null';

                $cico->save();

                return "true";

            } else {
                //We found a row where they have not yet checked out yet
                return "false";
            }
        }
    }

    /**
     * Handles checking out a volunteer based on their email
     * @return mixed
     */
    public function checkOut() {

        $volunteer = Cico::where('email', Input::get('email'))->where('check_out_timestamp', 'null')->first();

        if($volunteer != null) {

            //check to see if there is a volunteer with check_out_timestamp = null
            if ($volunteer->check_out_timestamp == "null") {

                $date = date('Y-m-d');

                $volunteer->check_out_timestamp = $date . ' ' . Carbon::now()->format('g:i A');
                $volunteer->minutes_volunteered = $volunteer->created_at->diffInMinutes();

                $volunteer->save();

                Session::flash('alert-success', 'You have been successfully checked out!');
                return Redirect::back();
            }

        } else {
            Session::flash('alert-danger', 'Incorrect email or volunteer has not been checked in!');
            return Redirect::back();
        }
    }


    /**
     * Handles showing the bulk checkout view when
     * the checkout link in the navbar is clicked
     */
    public function bulkCheckout() {
        $volunteers = Profile::join('volunteer_cico', 'profiles.id', '=', 'volunteer_cico.id')
            ->where('check_out_timestamp', 'null')
            ->get();

        return view('checkout', compact('volunteers'));
    }

}
