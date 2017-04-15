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

use App\Cico;
use App\Programs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
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
Route::get('/login', function() {

    if(!Auth::check()) {

    return view('login');

    } else {

        return Redirect::to('/profile');
    }
});


Route::get('/', function() {

    //Get all users from the table where they have not yet checked out joining with the profiles table
    $volunteers = Cico::where('check_out_timestamp', 'null')
        ->join('profiles', 'volunteer_cico.volunteer_id', '=', 'profiles.id')
        ->select('volunteer_cico.*')
        ->where('active', 1)
        ->orderBy('check_in_timestamp', 'ASC')
        ->paginate(4);

    //Handles all the programs added by staff
    $programs = Programs::where('status', 1)->get();

   return view('cico', compact('volunteers'), compact('programs'));
});


//Handles showing a specific volunteer
Route::get('/volunteer/search', 'SearchController@search');

//Handles searching for volunteers by name
Route::get('/volunteer/find/search', 'SearchController@find');

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
Route::get('/logout', function() { Auth::logout(); return Redirect::to('/'); });

//Handles when a staff member registers a new volunteer
Route::post('/add', 'addController@index');

//Handles adding & deleting a program
Route::post('/program/add', 'ProgramController@add');

Route::post('/program/delete', 'ProgramController@delete');

/*
|------------------------------------------------------------------------
| Routes for Notifications
|------------------------------------------------------------------------
| These routes define the specific GET and POST requests that are required
| for notifications to be sent, deliver, and updated
|
 */
Route::get('/notifications/notify', 'NotificationController@notify');

Route::get('/notification/remove/{id}', 'NotificationController@remove');

Route::get('/notification/clear/all/{id}', 'NotificationController@clearAll');

Route::get('/notification/read/{id}', 'NotificationController@read');

/*
|------------------------------------------------------------------------
| Routes for Excel Exporting
|------------------------------------------------------------------------
| These routes define the specific GET and POST requests that are required
| for volunteer data to be exported to an excel format
|
 */
Route::get('/excel/export', 'ExportController@export');

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

//Handles promoting/demoting staff members and volunteers
Route::post('/settings/rights', 'Profile\SettingsController@rights');

/*
|------------------------------------------------------------------------
| Routes for Donations and Handling Donations
|------------------------------------------------------------------------
| These routes define the specific GET and POST requests that are required
| for a volunteer to make a donation approval request and for staff members
| to approve donations
 */
Route::get('/donation', function() {
    return view('donation.donation');
});

//Handles a donation made by a volunteer
Route::post('/donation', 'DonationController@handleDonation');

//Handles a donation made by a staff member
Route::post('/donation/add', 'DonationController@addDonation');

//Handles approving  donation requests
Route::get('/donation/approve/{id}', 'DonationController@approve');

//Handles denying donation requests
Route::post('/donation/deny/{id}', 'DonationController@deny');

//Handles showing the archives when a staff member access's it
Route::get('/archive', 'ArchiveController@index');

/*
|------------------------------------------------------------------------
| Routes for Testing
|------------------------------------------------------------------------
| These routes define the specific GET and POST requests that are optional
| to test out certain functions methods or code that will not affect
| other portions of the application
|
 */
Route::get('/test', 'Test\TestController@testGet');

Route::post('/test', 'Test\TestController@testPost');


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

//Handles clocking a user out via the checkout form
Route::post('/checkout', 'CicoController@checkOut');

//Handles a staff member clicking the checkout button
Route::get('/checkout', 'CicoController@bulkCheckout');

Route::get('/cico/save', 'CicoController@save');

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

//Gets staff member via id
Route::get('api/v1/staff/{id}', 'REST\RESTController@findStaffById');

Route::get('api/v1/auth/user', function() {
   return Auth::user();
});

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

Route::get('api/v1/events/{group}', 'REST\RESTController@findEventsByGroup');

//Returns event given the event id
Route::get('api/v1/events/{id}', 'REST\RESTController@findEventById');

//Handles creating a new event in the calendar
Route::get('api/v1/events/create/{start}/{end}/{title}/{color}/{group}', 'REST\RESTController@createEvent');

//Deletes an event given the id
Route::get('api/v1/events/delete/{id}', 'REST\RESTController@deleteEventById');

//Re-opens a donation thats been previously approved
Route::get('api/v1/donations/open/{id}', 'REST\RESTController@openDonation');

//Denies a pending donation
Route::get('api/v1/donations/deny/{id}', 'REST\RESTController@denyDonation');

//Approves a pending donation
Route::get('api/v1/donations/approve/{id}', 'REST\RESTController@approveDonation');



//Handles authenticating if a users email and password are correct
Route::post('api/v1/authenticate/', 'REST\RESTController@authenticate');




Route::get('api/v1/hours/', 'REST\RESTController@getAllHours');

//Handles aggregating the volunteers hours
Route::get('/api/v1/hours/{id}', 'REST\RESTController@getHoursById');

//Handles aggregating volunteer hours between given dates
Route::get('/api/v1/hours/{id}/{start}/{end}', 'REST\RESTController@getHoursBetween');

//Handles Aggregating volunteer hours by group
Route::get('/api/v1/hours/group/{group}', 'REST\RESTController@getHoursByGroup');

//Aggregates sum of hours by group between given start and end date
Route::get('/api/v1/hours/group/{group}/{start}/{end}', 'REST\RESTController@getHoursByGroupBetween');

//Aggregates sum of all groups one a specific date
Route::get('/api/v1/hours/date/{date}', 'REST\RESTController@getAllHoursOnDate');

//Aggregates sum of volunteer hours
Route::get('/api/v1/hours/{id}/{group}/{start}/{end}', 'REST\RESTController@getHoursByIdAndGroupBetween');


Route::get('/api/v1/volunteer/hours/{id}/{start}/{end}', 'REST\RESTController@getHoursForVolunteerBetween');




//Handles archiving a volunteer
Route::post('/api/v1/archive/volunteer/{id}', 'REST\RESTController@archiveVolunteer');

//Handles renewing a previously archived volunteered
Route::post('/api/v1/renew/volunteer/{id}', 'REST\RESTController@renewVolunteer');

//Handles renewing a previously archived program
Route::post('/api/v1/renew/program/{id}', 'REST\RESTController@renewProgram');

//Handles archiving an event instead of deleting it
Route::post('/api/v1/archive/event/{id}', 'REST\RESTController@archiveEvent');

//Handles renewing an event that has been previously archived
Route::post('/api/v1/renew/event/{id}', 'REST\RESTController@renewEvent');

//Updates a cico timestamp from an html table
Route::get('/api/v1/cico/update/', 'REST\RESTController@updateTimestamp');
Route::post('/api/v1/cico/update/', 'REST\RESTController@updateTimestamp');

//updates volunteer demographic info from an html table
Route::post('/api/v1/demographics/update', 'REST\RESTController@updateDemographics');

//updates volunteer cico information found through a search
Route::post('/api/v1/cico/search/update', 'REST\RESTController@updateCico');

