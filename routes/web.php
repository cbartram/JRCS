<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//when the user first visits the site the default view 'login' in shown aka login.blade.php
use App\Cico;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|------------------------------------------------------------------------
| Routes for Core Application
|------------------------------------------------------------------------
| These routes define the specific GET and POST requests that are required
| for the Core of the application to function appropriately
|
 */
//Handles showing the user the root page
Route::get('/login', function() { return view('login'); });

Route::get('/', function() {
    //Get all users from the table where they have not yet checked out joining with the profiles table
    $volunteers = Cico::where('check_out_timestamp', 'null')
        ->join('profiles', 'volunteer_cico.id', '=', 'profiles.id')
        ->get();

   return view('cico', compact('volunteers'));
});

//Handles verifying the form data and authenticating the user
Route::post('/', 'Auth\LoginController@handleLogin');

//Handles the user after they have been authenticated
Route::get('/profile', 'Profile\StaffProfileController@index');

//Handles switching a users group (Bebco, Jaco, Jbc)
Route::get('/switch/{group}', function($group) {
    //The new group is the group required to switch too
    Session::put('group', $group);

    return Redirect::to('/profile');
});

//Logs a user out safely
Route::get('/logout', function() { Session::flush(); return Redirect::to('/'); });

//Handles when a staff member registers a new volunteer
Route::post('/add', 'addController@index');



/*
|------------------------------------------------------------------------
| Routes for Events
|------------------------------------------------------------------------
| These routes define the specific GET and POST requests that are required
| for events to be added to the calendar, removed, and logged.
|
 */

//Handles staff logging the event
Route::post('/event', 'EventController@log');

//Handles Removing an event given the event id
Route::get('/event/remove', 'EventController@remove');

/*
|------------------------------------------------------------------------
| Routes for Settings
|------------------------------------------------------------------------
| These routes define the specific GET and POST requests that are required
| for the account settings in the staff profile page to function correctly.
|
 */
//Handles account settings for default group
Route::post('/settings', 'Profile\SettingsController@defaultGroup');

//Handles account settings for showing self in the volunteer cards
Route::post('/settings/self', 'Profile\SettingsController@self');

//Handles showing/hiding drag and drop feature for all groups not just admin
Route::post('/settings/drop', 'Profile\SettingsController@drop');


/*
|------------------------------------------------------------------------
| Routes for Donations and Handling Donations
|------------------------------------------------------------------------
| These routes define the specific GET and POST requests that are required
| for a volunteer to make a donation approval request and for staff members
| to approve donations
 */
Route::get('/donation', function() {
    return view('donation');
});

Route::post('/donation', 'DonationController@handleDonation');

//Handles approving or denying donation requests
Route::get('/donation/approve/{id}', 'DonationController@approve');
Route::get('/donation/deny/{id}', 'DonationController@deny');


/*
|------------------------------------------------------------------------
| Routes for Checking in and Checking out
|------------------------------------------------------------------------
| These routes define the specific GET and POST requests that are required
| for a user to be able to clock in and clock out
|
 */
//Handles clocking a user in/out
Route::post('/cico', 'CicoController@checkIn');

//Handles clocking a user out
Route::post('/checkout', 'CicoController@checkOut');

/*
|------------------------------------------------------------------------
| Routes for Password Resetting
|------------------------------------------------------------------------
| These routes define the specific GET and POST requests that are required
| for a user to be able to update or reset their password both before
| and after being authenticated (logged in)
|
 */
//Handles resetting the staff members password from the settings modal
Route::post('/password', 'Profile\SettingsController@resetPassword');

//Handles resetting the password from outside the authentication layer
Route::get('/password/reset', function() {
    return view('reset');
});

//Handles sending the password reset link
Route::post('/password/send', 'PasswordController@index');

//Handles what happens when the user clicks the reset link
Route::get('/password/reset/{token}', 'PasswordController@reset');

Route::post('/change', 'PasswordController@change');


/*
|------------------------------------------------------------------------
| Routes for JS REST API
|------------------------------------------------------------------------
| These routes define the specific GET, POST, UPDATE, And Delete (CRUD) functions
| that are executable via ajax requests on the frontend from jquery
| Patch updates a single resource without having to insert an entire new column saving bandwith
|
 */
//Get all volunteers
Route::get('api/v1/volunteers', 'REST\RESTController@all');

//Get Volunteer with id
Route::get('api/v1/volunteers/id/{id}', 'REST\RESTController@findById');

//Get Volunteer with email
Route::get('api/v1/volunteers/email/{email}', 'REST\RESTController@findByEmail');

//Deletes a volunteer from the db with specified id
Route::delete('api/v1/volunteers/id/{id}', 'REST\RESTController@deleteById');

//Deletes a volunteer from the db with specified email
Route::delete('api/v1/volunteers/email/{email}', 'REST\RESTController@deleteByEmail');

//Updates a volunteer with the specified id
Route::patch('api/v1/volunteers/id/{id}/{columnToUpdate}/{newValue}', 'REST\RESTController@updateById');

//Updates a volunteer with the specified email
Route::patch('api/v1/volunteers/email/{email}/{columnToUpdate}/{newValue}', 'REST\RESTController@updateByEmail');

//Handles finding all calendar events
Route::get('api/v1/events/', 'REST\RESTController@findAllEvents');

//Returns event given the event id
Route::get('api/v1/events/{id}', 'REST\RESTController@findEventById');

//Handles creating a new event in the calendar
Route::get('api/v1/events/create/{start}/{end}/{title}/{color}', 'REST\RESTController@createEvent');

//Deletes an event given the id
Route::get('api/v1/events/delete/{id}', 'REST\RESTController@deleteEventById');




