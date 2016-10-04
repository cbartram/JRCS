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

class addController extends Controller
{
    public function index() {
        $rules = array(
            'email'    => 'required|email',
            'password' => 'required',
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

            return Redirect::to('/profile/' . Session::get('id'))
                ->withErrors($validator); // send back all errors to the volunteer add form
        }

            //Create a new volunteer
        $volunteer = new Profile();

        //Creating the new volunteer for the database
        $volunteer->id = 'vol_' . str_random(8);
        $volunteer->password = Hash::make(Input::get('password'));
        $volunteer->first_name = Input::get('first_name');
        $volunteer->last_name = Input::get('last_name');
        $volunteer->address = Input::get('address');
        $volunteer->city = Input::get('city');
        $volunteer->state = Input::get('state');
        $volunteer->zip_code = Input::get('zip');
        $volunteer->email = Input::get('email');
        $volunteer->phone = Input::get('phone');
        $volunteer->volunteer_type = Input::get('volunteer_type');

        /*todo  if all 3 checkboxes are left blank then the volunteer wont be added to any staff members view and will
        "dissapear" because no one will see him/her. Check to make sure at least 1 of the checkboxes is checked */

            if(Input::get('bebco-checkbox') == 'true') {
                $volunteer->bebco_volunteer = 1;
            } else {
                $volunteer->bebco_volunteer = 0;
            }

            if(Input::get('jaco-checkbox') == 'true') {
                $volunteer->jaco_volunteer = 1;
            } else {
                $volunteer->jaco_volunteer = 0;
            }

            if(Input::get('jbc-checkbox') == 'true') {
                $volunteer->jbc_volunteer = 1;
            } else {
                $volunteer->jbc_volunteer = 0;
            }

            //Persist and insert volunteer to the database
            $volunteer->save();

        Session::flash('alert-success', 'New volunteer added successfully!');
        return Redirect::back();
    }
}
