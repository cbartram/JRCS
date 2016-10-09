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

Route::get('/', 'LoginController@index');

//When the staff member POSTS the login form
Route::post('/', 'LoginController@handleLogin');

//When the person logs in the StaffProfile Controller comes to action to handle the request with the index() function
Route::get('/profile', 'StaffProfileController@index');

Route::get('/switch/{group}', 'SwitchController@index');

Route::get('/logout', 'LogoutController@index');

//Handles clocking a user in/out
Route::get('/cico', 'CicoController@checkIn');

//Handles clocking a user out
Route::post('/checkout', 'CicoController@checkOut');
Route::get('/checkout', 'CicoController@index');

//Handles when a staff member registers a new volunteer
Route::post('/add', 'addController@index');

//Handles account settings for default group
Route::post('/settings', 'SettingsController@defaultGroup');

//Handles account settings for showing self in the volunteer cards
Route::post('/settings/self', 'SettingsController@self');

//Handles resetting the staff members password
Route::post('/password', 'SettingsController@resetPassword');

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
Route::get('api/v1/volunteers', 'RESTController@all');

//Get Volunteer with id
Route::get('api/v1/volunteers/id/{id}', 'RESTController@findById');

//Get Volunteer with email
Route::get('api/v1/volunteers/email/{email}', 'RESTController@findByEmail');

//Deletes a volunteer from the db with specified id
Route::delete('api/v1/volunteers/id/{id}', 'RESTController@deleteById');

//Deletes a volunteer from the db with specified email
Route::delete('api/v1/volunteers/email/{email}', 'RESTController@deleteByEmail');

//Updates a volunteer with the specified id
Route::patch('api/v1/volunteers/id/{id}/{columnToUpdate}/{newValue}', 'RESTController@updateById');

//Updates a volunteer with the specified email
Route::patch('api/v1/volunteers/email/{email}/{columnToUpdate}/{newValue}', 'RESTController@updateByEmail');




