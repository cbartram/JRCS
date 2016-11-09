<?php

namespace App\Http\Controllers\Profile;

use App\Helpers\Helpers;
use App\Helpers\Settings;
use App\Http\Controllers\Controller;
use App\Profile;
use App\StaffProfile;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Kamaln7\Toastr\Facades\Toastr;

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
            Toastr::error('Could not update your default group please try again...', $title = 'Error', $options = []);
            return Redirect::back();
        }
        Toastr::success('Your default group has been updated to: ' . $defaultGroup, $title = 'Success', $options = []);
        return Redirect::back();
    }

    /**
     * Handles showing/hiding drag & drop features for all groups or just while viewing the admin group
     */
    public function drop() {
        $checkbox = Input::get('drop-checkbox');

        //Place a session
        if($checkbox == true) {
            //Session::put('drop', true);
            Redis::set('drop', true);

            Toastr::success('Drag and Drop view has been turned on!', $title = 'Success', $options = []);
            return Redirect::back();
        } else {
            //Session::forget('drop');
            Redis::del('drop');
            Toastr::success('Drag and Drop view has been turned off!', $title = 'Success', $options = []);

            return Redirect::back();
        }
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
                Toastr::success('Your settings have been saved successfully!', $title = 'Success', $options = []);
                return Redirect::back();
            } else {
                Toastr::error('Failed to update your account settings', $title = 'Error', $options = []);
                return Redirect::back();
            }

        } else {
            $staff->show_self = false;
            $staff->save();

            Session::forget('show-self');
            Toastr::success('Showing yourself in the volunteer cards has been turned off', $title = 'Success', $options = []);
            return Redirect::back();
        }
    }

    /**
     * Handles reseting the password from inside the application
     * @return mixed
     */
    public function resetPassword() {
        $rules = array(
            'password-text'    => 'required',
            'password-confirm' => 'required'
        );

        //run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        //if the validator fails, redirect back to the form
        if ($validator->fails()) {

            Toastr::error('You must fill out both fields to reset your password!', $title = 'Error', $options = []);
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
                    Toastr::success('Your password has been updated successfully!', $title = 'Success', $options = []);
                    return Redirect::back();
                }

            } else {
                Toastr::error('Your password fields must match!', $title = 'Error', $options = []);
                return Redirect::back();
            }
        }
    }

    /**
     * Handles staff rights & promoting and demoting
     * a staff member or volunteer
     */
    public function rights() {
        $input = Input::all();

        //groups the new staff member will have access to, false by default
        $groups = ['bebco' => false,
                   'jaco'  => false,
                   'jbc'   => false
                  ];

        //iterate over the Input results and update the groups array accordingly
        foreach($input as $k => $v){
            if($k == 'bebco') {
                $groups['bebco'] = true;
            }

            if($k == 'jaco') {
                $groups['jaco'] = true;
            }

            if($k == 'jbc') {
                $groups['jbc'] = true;
            }
        }

        $rules = [
          'password' => 'required'
        ];

        if(Input::get('rights') == "promote") {

            //run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            //if the validator fails, redirect back to the form
            if ($validator->fails()) {
                Toastr::error('You must fill out all the fields to promote a volunteer', $title = 'Promotion Failed', $options = []);
                return Redirect::to('/profile')
                    ->withInput();
            }

            Helpers::promoteToStaff(Input::get('volunteers'),
                Input::get('password'),
                $groups['bebco'],
                $groups['jaco'],
                $groups['jbc']);

            Toastr::success('Volunteer has been promoted to a staff member successfully', $title = 'Promotion Succeeded', $options = []);
            return Redirect::back();

        } else {
            //Handle demoting
            Helpers::demoteFromStaff(Input::get('staff'));
            Toastr::success('Volunteer has been demoted successfully', $title = 'Demotion Succeeded', $options = []);
            return Redirect::back();
        }
    }
}
