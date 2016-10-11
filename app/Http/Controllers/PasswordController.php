<?php

namespace App\Http\Controllers;

use App\StaffProfile;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PasswordController extends Controller
{
    //Sends the password reset email and generates the link
    public function index() {

        $staff = StaffProfile::where('email', Input::get('email'))->first();

        if($staff != null) {
            $token = str_random(20);
            $staff->remember_token = $token;
            $staff->save();

            $title = 'JRCS Password Reset';
            //todo this will need to be changed eventually
            $content = 'http://jrcs.herokuapp.com/password/reset/' . $token;
            $gravatar = md5(strtolower($staff->email));

            Mail::send('email', ['title' => $title, 'token' => $content, 'gravatar' => $gravatar], function ($message) use ($staff)
            {
                //Uses default $from set in the config
                $message->to($staff->email);

            });

            Session::flash('alert-success', 'A password reset link has been sent to the email provided');
            return Redirect::back();

        } else {
            Session::flash('alert-danger', 'Your email could not be matched with a staff member!');
            return Redirect::back();
        }
    }

    //Handles the link that is clicked in the email
    public function reset($token) {
        $staff = StaffProfile::where('remember_token', $token)->first();
        if($staff != null) {

            return view('password')
                ->with('email', $staff->email)
                ->with('token', $staff->remember_token);
        } else {
            //token was forged or invalid
            Session::flash('alert-danger', 'The link you followed to reset your password is invalid, or has expired.');
            return Redirect::to('/password/reset');
        }
    }

    //Handles updating the database with the users new password
    public function change() {
        $email = Input::get('email');
        $password = Input::get('password');

        $staff = StaffProfile::where('email', $email)->first();
        $staff->password = Hash::make($password);

        $staff->save();

        Session::flash('alert-success', 'Your password has been reset successfully, you can log in with your new password!');
        return Redirect::to('/password/reset');
    }
}
