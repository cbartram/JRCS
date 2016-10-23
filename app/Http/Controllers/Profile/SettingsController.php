<?php

namespace App\Http\Controllers\Profile;

use App\Helpers\Settings;
use App\Http\Controllers\Controller;
use App\StaffProfile;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Handles setting the staff members default group
     * @return mixed
     */
    public function defaultGroup() {
        $defaultGroup = Input::get('group-radio');

        $staff = StaffProfile::find(Session::get('id'));

        //The staff member could be found
        if($staff != null) {
            $staff->default_group = $defaultGroup;

            //Persist information to the database
            $staff->save();
        } else {
            Session::flash('alert-danger', 'Could not update your default group please try again...');
            return Redirect::back();
        }
        Session::flash('alert-success', 'Your default group has been updated to: ' . $defaultGroup);
        return Redirect::back();
    }


    /**
     * Handles the show self checkbox
     * @return mixed
     */
    public function self() {
        $staff = StaffProfile::find(Session::get('id'));

        //The user has checked the checkbox
        if(Input::get('self-checkbox') == 'true') {

            //The staff member could be found
            if($staff != null) {
                $staff->show_self = true;

                $staff->save();
                //Set the session variable
                Session::put('show-self', true);
                Session::flash('alert-success', 'Your settings have been saved!');
                return Redirect::back();
            } else {
                Session::flash('alert-danger', 'Could not update your preferences please try again...');
                return Redirect::back();
            }

        } else {
            $staff->show_self = false;
            $staff->save();

            Session::forget('show-self');
            Session::flash('alert-success', 'Showing yourself in the volunteer cards has been turned off.');
            return Redirect::back();
        }
    }

    public function resetPassword() {
        $rules = array(
            'password-text'    => 'required',
            'password-confirm' => 'required'
        );

        //run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        //if the validator fails, redirect back to the form
        if ($validator->fails()) {

            Session::flash('alert-danger', 'You must fill out both fields to reset your password!');
            return Redirect::back();

        } else {
            //Check to ensure the passwords match
            if(Input::get('password-text') == Input::get('password-confirm')) {
                //Hash the passwords and update the database
                $password = Hash::make(Input::get('password-text'));
                $staff = StaffProfile::find(Session::get('id'));

                if($staff != null) {
                    $staff->password = $password;
                    $staff->save();
                    Session::flash('alert-success', 'Your password has been successfully updated!');
                    return Redirect::back();
                }

            } else {
                Session::flash('alert-danger', 'Your password fields must match...');
                return Redirect::back();
            }
        }
    }
}
