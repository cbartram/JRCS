<?php

namespace App\Http\Controllers;

use App\EventLog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Validates data and logs an event the the database
     */
    public function log() {
        $rules = array(
            'event-id'          => 'required',
            'attendee_count'    => 'required|numeric',
            'event_description' => 'required',
            'volunteer_count' => 'required|numeric',
            'volunteer_hours' => 'required|numeric',
            'donation_amount' => 'required',
        );

        //run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        //if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('/profile')
                ->withErrors($validator); // send back all errors to the volunteer add form
        }

        $event = EventLog::where('event_id' , Input::get('event-id'))->get();

        //Couldnt find the event
        if($event == null) {
            return Redirect::to('/profile')
                ->withErrors('Event with that Id could not be located.');
        }

        //Insert based on what the staff inputted
        $event->attendee_count = Input::get('attendee_count');
        $event->event_description = Input::get('event_description');
        $event->volunteer_count = Input::get('volunteer_count');
        $event->total_volunteer_hours = Input::get('volunteer_hours');
        $event->donation_amount = Input::get('donation_amount');

        $event->save();

        return Redirect::to('/profile')
            ->with('alert-success', 'Successfully Logged Event!');
    }
}
