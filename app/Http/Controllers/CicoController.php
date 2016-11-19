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
        $q = Profile::where('email', $email)
            ->where('active', 1)
            ->limit(1)->first();

        //The wrong email was sent through the form
        if($q == null) {
            return "email";

        } else {
            //Construct a new query to see if the user has checked out from their previous check-in
            $query = Cico::where('email', $email)
                ->where('check_out_timestamp', 'null')
                ->first();

            //if we could not find an entry where their check-out was null
            if($query == null) {

                //insert a new record for the volunteer clocking in
                $cico = new Cico();

                $groups = ['BEBCO', 'JACO', 'JBC'];
                foreach($groups as $group) {

                    $columnName = Helpers::getGroupNameFromTruncated($group);

                    if(Helpers::isMemberOf($group, $q->id)) {
                        $cico->$columnName = 1;
                    } else {
                        $cico->$columnName = 0;
                    }
                }

                //Assign the rest of the values for the row
                $cico->id = 'cico_' . str_random(10);
                $cico->volunteer_id = $q->id;
                $cico->email = $email;

                $cico->volunteer_program = Input::get('program');
                $cico->volunteer_type = Input::get('type');
                $cico->check_in_date = $date;
                $cico->check_in_timestamp = $date . ' ' . Carbon::now()->subHours(5)->format('g:i A');
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

        $volunteer = Cico::where('id', Input::get('id'))->limit(1)->first();

        if(!is_null($volunteer)) {

            $date = date('Y-m-d');

            $volunteer->check_out_timestamp = $date . ' ' . Carbon::now()->subHours(5)->format('g:i A');
            $volunteer->check_out_date = $date;
            $volunteer->minutes_volunteered = $volunteer->created_at->diffInMinutes();

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

        return view('checkout', compact('volunteers'));
    }

}
