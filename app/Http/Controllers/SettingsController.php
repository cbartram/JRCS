<?php

namespace App\Http\Controllers;

use App\StaffProfile;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
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


    public function self() {
        //The user has checked the checkbox
        if(Input::get('self-checkbox') == 'true') {
            //Set the session variable
            Session::put('show-self', true);
            Session::flash('alert-success', 'Your settings have been saved!');
            return Redirect::back();
        } else {
            //Unset the session variable if the user does not want to see their card.
            Session::forget('show-self');
            Session::flash('alert-success', 'Your settings have been saved!');
            return Redirect::back();
        }
    }
}
