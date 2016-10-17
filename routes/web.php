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
use Illuminate\Support\Facades\Route;

/*
|------------------------------------------------------------------------
| Routes for Core Application
|------------------------------------------------------------------------
| These routes define the specific GET and POST requests that are required
| for the Core of the application to function appropriately
|
 */
//Handles showing the user the root page
Route::get('/', 'Auth\LoginController@index');

//Handles verifying the form data and authenticating the user
Route::post('/', 'Auth\LoginController@handleLogin');

//Handles the user after they have been authenticated
Route::get('/profile', 'Profile\StaffProfileController@index');

//Handles switching a users group (Bebco, Jaco, Jbc)
Route::get('/switch/{group}', 'Profile\SwitchController@index');

//Logs a user out safely
Route::get('/logout', 'Auth\LogoutController@index');

//Handles when a staff member registers a new volunteer
Route::post('/add', 'addController@index');

//Handles account settings for default group
Route::post('/settings', 'Profile\SettingsController@defaultGroup');

//Handles account settings for showing self in the volunteer cards
Route::post('/settings/self', 'Profile\SettingsController@self');


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
Route::get('/password/reset', 'Auth\LoginController@resetPassword');

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




