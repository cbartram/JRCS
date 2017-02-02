<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\StaffProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    /**
     * Handles authenticating a user with the system
     * @return mixed
     */
    public function handleLogin()
    {
        $rules = array(
            'email'    => 'required|email',
            'password' => 'required'
        );

        //run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);


        //if the validator fails, redirect back to the form
        if ($validator->fails()) {

            return Redirect::back()
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form

        } else {

            //Get the first row back from the query
           $staff = StaffProfile::where('email', Input::get('email'))->first();

            if($staff == null) {
                //Redirect back home with an incorrect username error
                return Redirect::back()
                    ->withErrors("Username was incorrect!")
                    ->withInput(Input::except('password'));
            }

            if($staff->email == Input::get('email') && Hash::check(Input::get('password'), $staff->password)) {

                Auth::login($staff);

                //If the staff member is also a volunteer add an additional session
                if($staff->volunteer_id != "") {
                    Session::put('volunteer_id', $staff->volunteer_id);
                }

                //Redirect the user
                return Redirect::to('/profile');

            } else {

                //Redirect back home with an incorrect username and password error
                return Redirect::back()
                    ->withErrors("Password was incorrect!")
                    ->withInput(Input::except('password'));
            }

        }
    }

}
