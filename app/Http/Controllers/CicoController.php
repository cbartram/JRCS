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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Kamaln7\Toastr\Facades\Toastr;

class CicoController extends Controller
{

    public function __construct()
    {
        //This middleware is different because checkin/checkout must be accessed before logging in by volunteers
        $this->middleware('auth', ['only' => ['bulkCheckout']]); //Bulk checkout is accessed after logging in so we must require auth middleware
    }

    /**
     * Handles checking a user in via there email
     * @return string Return status
     */
    public function checkIn() {

       //Get elements from the form POST request Note: email could be a phone number
       $email = Input::get('email');
       $date = date('Y-m-d');
       $forGroup = Input::get('forGroup');

        //Get the first row back from the query
        $volunteer = Profile::where('email', $email)
            ->orWhere('phone', $email)
            ->where('active', 1)
            ->first();

        //The wrong email was sent through the form
        if($volunteer == null)
        {

            Toastr::error('The email or phone you entered could not be found.', $title = 'Information Not Found');
            return Redirect::back();

        } else {
            //Construct a new query to see if the user has checked out from their previous check-in
            $query = Cico::where('email', $email)
                ->where('check_out_timestamp', 'null')
                ->first();

            //if we could not find an entry where their check-out was null
            if($query == null) {

                //insert a new record for the volunteer clocking in
                $cico = new Cico();

                $groups = ['BEBCO', 'JACO', 'JBC', 'JRCS'];

                foreach($groups as $group) {

                    $col = Helpers::getForGroupNameFromTruncated($group);
                    $columnName = Helpers::getGroupNameFromTruncated($group);

                    //If the group we are iterating over is the group they are volunteering as
                    if($forGroup == $group) {
                        $cico->$col = 1;
                    } else {
                        $cico->$col = 0;
                    }

                    if(Helpers::isMemberOf($group, $volunteer->id)) {
                        $cico->$columnName = 1;
                    } else {
                        $cico->$columnName = 0;
                    }
                }

                //Assign the rest of the values for the row
                $cico->id = 'cico_' . str_random(10);
                $cico->volunteer_id = $volunteer->id;
                $cico->email = $volunteer->email;

                $cico->volunteer_program = Input::get('program');
                $cico->volunteer_type = Input::get('type');
                $cico->check_in_date = $date;
                $cico->check_in_timestamp = Carbon::now()->subHours(5)->format('Y-m-d g:i A');
                $cico->check_out_timestamp = 'null';

                $cico->save();

                Toastr::success(Helpers::getName($volunteer->id) . " has been checked in successfully!");

                return Redirect::back();

            } else {
                //We found a row where they have not yet checked out yet
                Toastr::error('You haven\'t checked out yet with the email yet!');
                return Redirect::back();
            }
        }
    }

    /**
     * Handles checking out a volunteer based on their email
     * @return mixed
     */
    public function checkOut() {

        $volunteer = Cico::where('id', Input::get('id'))->first();

        if(!is_null($volunteer)) {

            $date = date('Y-m-d');

            $volunteer->check_out_timestamp = Carbon::now()->subHours(5)->format('Y-m-d g:i A');
            $volunteer->check_out_date = $date;

            //convert the check_in_timestamp to a carbon object in case the field was updated before the volunteer checked out
            $checkInDate = Carbon::createFromFormat('Y-m-d g:i A', $volunteer->check_in_timestamp);

            //todo for some weird reason it adds an additional 300 minutes to the correct time it probably has to do with UTC Time
            $volunteer->minutes_volunteered = $checkInDate->diffInMinutes() - 300;

            $volunteer->save();

            return "true";

        } else {
            //checkout failed
            return "false";
        }

    }


    /**
     * Handles showing the bulk checkout view when
     * the checkout link in the navbar is clicked
     */
    public function bulkCheckout() {
        $volunteers = Profile::join('volunteer_cico', 'profiles.id', '=', 'volunteer_cico.volunteer_id')
            ->where('check_out_timestamp', 'null')
            ->get();

        return view('checkout', compact('volunteers'))
            ->with('defaultGroup', Session::get('group'));
    }

}
