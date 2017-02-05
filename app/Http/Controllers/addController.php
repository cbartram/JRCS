<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Kamaln7\Toastr\Facades\Toastr;

class addController extends Controller
{
    public function index() {
        $rules = array(
            'email'    => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'phone' => 'required',
            'volunteer_type' => 'required'
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

        //Creating the new volunteer for the database
        $volunteer->id = 'vol_' . str_random(8);
        $volunteer->first_name = Input::get('first_name');
        $volunteer->last_name = Input::get('last_name');
        $volunteer->address = Input::get('address');
        //todo static needs to be dynamic
        $volunteer->nationality = 'Burmese';
        $volunteer->city = Input::get('city');
        $volunteer->state = Input::get('state');
        $volunteer->zip_code = Input::get('zip');
        $volunteer->email = Input::get('email');
        $volunteer->phone = Input::get('phone');
        $volunteer->volunteer_type = Input::get('volunteer_type');
        $volunteer->active = 1;

            //ensure at least one checkbox is selected so the volunteer doesn't disappear in the db
            if(Input::get('bebco-checkbox') != 'true' && Input::get('jaco-checkbox') != 'true' && Input::get('jbc-checkbox') != 'true') {
                Toastr::error('You must add the volunteer to at least one group.', $title = 'Error', $options = []);

                return Redirect::back();
             }

            //Handles giving the volunteer access to certain groups
            Input::get('bebco-checkbox') == 'true' ? $volunteer->bebco_volunteer = 1 : $volunteer->bebco_volunteer = 0;
            Input::get('jaco-checkbox') == 'true' ? $volunteer->jaco_volunteer = 1 : $volunteer->jaco_volunteer = 0;
            Input::get('jbc-checkbox') == 'true' ? $volunteer->jbc_volunteer = 1 : $volunteer->jbc_volunteer = 0;
            Input::get('jrcs-checkbox') == 'true' ? $volunteer->jrcs_volunteer = 1 : $volunteer->jrcs_volunteer = 0;

            //Persist and insert volunteer to the database
            $volunteer->save();

        Toastr::success('Volunteer created successfully!', $title = 'Success', $options = []);
        return Redirect::back();
    }
}
