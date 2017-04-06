<?php

namespace App\Http\Controllers;

use App\EmergencyContact;
use App\Profile;
use App\VolunteerInformation;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Kamaln7\Toastr\Facades\Toastr;

class addController extends Controller
{
    public function index() {

        define('ID', 'vol_' . str_random(8));

        $rules = array(
            'email'    => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required|numeric|max:6',
            'phone' => 'required',
            'nationality' => 'required',
            'volunteer_type' => 'required',
            'skills' => 'required',
            'degree' => 'required',
            'languages' => 'required',
            'previous' => 'required',
            'criminal' => 'required',
            'e-first_name' => 'required',
            'e-last_name' => 'required',
            'e-address' => 'required',
            'e-city' => 'required',
            'e-state' => 'required',
            'e-zip' => 'required|numeric|max:6',
            'e-phone' => 'required',
            'e-email' => 'required|email'
        );

        //run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        //if the validator fails, redirect back to the form
        if ($validator->fails()) {
            Toastr::error('You must fill out all the fields and the email must be a valid email', $title = 'Error creating volunteer', $options = []);

            return Redirect::back()
                ->withInput();
        }

        //Create a new volunteer
        $volunteer = new Profile();
        $additionalInformation = new VolunteerInformation();
        $emergencyContact = new EmergencyContact();

        $emergencyContactId = 'emr_' . str_random(8);
        $input = Input::all();

        //Creating the new volunteer for the database
        $volunteer->id = ID;
        $volunteer->first_name = Input::get('first_name');
        $volunteer->last_name = Input::get('last_name');
        $volunteer->address = Input::get('address');
        $volunteer->nationality = Input::get('nationality');
        $volunteer->city = Input::get('city');
        $volunteer->state = Input::get('state');
        $volunteer->zip_code = Input::get('zip');
        $volunteer->email = Input::get('email');
        $volunteer->phone = Input::get('phone');
        $volunteer->volunteer_type = Input::get('volunteer_type');
        $volunteer->active = 1;


        //Add the Data for Volunteer Information
        $additionalInformation->volunteer_id = ID;


        //Find the Interests & Availability from the input recieved
        $days = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"];
        $potentialInterests = ["transportation", "tanf", "esol", "lawn", "sat", "career", "fundraising", "event", "other"];

        $availability = "";
        $interests = "";

        //Find the days the volunteer is available and insert as CSV
        foreach($input as $key => $value) {
            if(in_array($key, $days)) {
               $availability .= $key . ",";
            }

            if(in_array($key, $potentialInterests)) {
                $interests .= $key . ",";
            }
        }

        $additionalInformation->availability = $availability;
        $additionalInformation->interests = $interests;
        $additionalInformation->special_skills = $input['skills'];
        $additionalInformation->degree = $input['degree'];
        Input::get('has-transportation') == 'true' ? $additionalInformation->transportation = 1 : $additionalInformation->transportation = 0;
        $additionalInformation->languages_spoken = $input['languages'];
        $additionalInformation->previous_volunteer_work = $input['previous'];
        $additionalInformation->criminal_convictions = $input['criminal'];
        $additionalInformation->nationality = $input['nationality'];
        $additionalInformation->emergency_contact = $emergencyContactId;


        //Save the emergency contact information
        $emergencyContact->volunteer_id = ID;
        $emergencyContact->emergency_contact_id = $emergencyContactId;
        $emergencyContact->first_name = $input['e-first_name'];
        $emergencyContact->last_name = $input['e-last_name'];
        $emergencyContact->address = $input['e-address'];
        $emergencyContact->city = $input['e-city'];
        $emergencyContact->state = $input['e-state'];
        $emergencyContact->zip= $input['e-zip'];
        $emergencyContact->phone = $input['e-phone'];
        $emergencyContact->email = $input['e-email'];


            //ensure at least one checkbox is selected so the volunteer doesn't disappear in the db
            if(Input::get('bebco-checkbox') != 'true' && Input::get('jaco-checkbox') != 'true' && Input::get('jbc-checkbox') != 'true') {
                Toastr::error('You must add the volunteer to at least one group.', $title = 'Error', $options = []);

                return Redirect::back();
             }

            //Handles giving the volunteer access to certain groups
            Input::get('bebco-checkbox')  == 'true' ? $volunteer->bebco_volunteer = 1 : $volunteer->bebco_volunteer = 0;
            Input::get('jaco-checkbox') == 'true' ? $volunteer->jaco_volunteer = 1 : $volunteer->jaco_volunteer = 0;
            Input::get('jbc-checkbox')  == 'true' ? $volunteer->jbc_volunteer = 1 : $volunteer->jbc_volunteer = 0;
            Input::get('jrcs-checkbox')  == 'true' ? $volunteer->jrcs_volunteer = 1 : $volunteer->jrcs_volunteer = 0;

            //Persist and insert volunteer to the database
            $volunteer->save();
            $additionalInformation->save();
            $emergencyContact->save();

        Toastr::success('Volunteer created successfully!', $title = 'Success', $options = []);
        return Redirect::back();
    }
}
