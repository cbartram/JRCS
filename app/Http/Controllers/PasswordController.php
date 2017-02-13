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
    /**
     * The password reset form that generates the unique token
     * @return mixed
     */
    public function index() {

        $staff = StaffProfile::where('email', Input::get('email'))->first();

        if($staff != null) {

            //create a unique token
            $token = str_random(20);
            $staff->remember_token = $token;
            $staff->save();

            $title = 'JRCS Password Reset';

            //todo this will need to be changed eventually
            $content = 'https://jrcs.herokuapp.com/password/reset/' . $token . '?email=' . $staff->email;
            $gravatar = md5(strtolower($staff->email));

            //Send the email and pass the blade view as parameters
            Mail::send('email', ['title' => $title, 'token' => $content, 'gravatar' => $gravatar], function ($message) use ($staff)
            {
                //Uses default $from set in the config
                $message->subject('JRCS Password Reset');
                $message->to($staff->email);

            });

            Session::flash('alert-success', 'A password reset link has been sent to the email provided check your inbox for more information.');
            return Redirect::back();

        } else {
            Session::flash('alert-danger', 'Your email was incorrect and could not be matched with a staff member!');
            return Redirect::back();
        }
    }

    /**
     * Handles the link that is clicked in the email
     * @param $token string unique password reset token
     * @return $this
     */
    public function reset($token) {
        $staff = StaffProfile::where('remember_token', $token)->first();
        if($staff != null) {

            //Update the token so that they cannot use the link twice
            $staff->remember_token = '';
            $staff->save();

            return view('password', compact('staff'));

        } else {
            //Token was forged or invalid
            Session::flash('alert-danger', 'The link you followed to reset your password is invalid, or has expired.');
            return Redirect::to('/password/reset');
        }
    }

    /**
     * Handles updating the database with the new password
     * @return mixed
     */
    public function change() {

        //Get Input from Form Submit
        $email = Input::get('email');
        $password = Input::get('password');
        $passwordConfirm = Input::get('password-confirm');

        if($password != $passwordConfirm) {
            Session::flash('alert-danger', 'Your passwords did not match!');
            return Redirect::to('/password/reset');
        }

        $staff = StaffProfile::where('email', $email)->first();
        $staff->password = Hash::make($password);

        $staff->save();

        Session::flash('alert-success', 'Your password has been reset successfully, you can log in with your new password!');
        return Redirect::to('/password/reset');
    }
}
