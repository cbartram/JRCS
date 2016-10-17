<?php

namespace App\Http\Controllers\Auth;

use App\Cico;
use App\Http\Controllers\Controller;
use App\Profile;
use App\StaffProfile;

use App\Http\Requests;
use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Validator;

class LoginController extends Controller
{
    /**
     * Handles Providing data used by blade and showing the default view when a user
     * first visits the website
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //Get all users from the table where they have not yet checked out joining with the profiles table
        $volunteers = Cico::where('check_out_timestamp', 'null')
            ->join('profiles', 'volunteer_cico.id', '=', 'profiles.id')
            ->get();

        return view('login', compact('volunteers'));
    }


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

            return Redirect::to('/')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form

        } else {

            //Get the first row back from the query
           $staff = DB::table('staff_profile2')->where('email', Input::get('email'))->limit(1)->first();

            if($staff == null) {
                //Redirect back home with an incorrect username error
                return Redirect::to('/')
                    ->withErrors("Username was incorrect!")
                    ->withInput(Input::except('password'));
            }

            if($staff->email == Input::get('email') && Hash::check(Input::get('password'), $staff->password)) {

                //Add Sessions
                Session::put('is_logged_in', true);
                Session::put('id', $staff->id);
                Session::put('user', $staff);

                //If the staff member is also a volunteer add an additional session
                if($staff->volunteer_id != "") {
                    Session::put('volunteer_id', $staff->volunteer_id);
                }

                //Redirect the user
                return Redirect::to('/profile');

            } else {

                //Redirect back home with an incorrect username and password error
                return Redirect::to('/')
                    ->withErrors("Password was incorrect!")
                    ->withInput(Input::except('password'));
            }

        }
    }

    /**
     * Handles showing the view for a user to reset their password
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetPassword() {
        return view('reset');
    }
}
