<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\EventLog;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Kamaln7\Toastr\Facades\Toastr;

class EventController extends Controller
{
    /**
     * Removes the event from the calendar given the event id
     */
    public function remove() {
        $id = Input::get('id');

        if(Calendar::find($id) != null) {
           Calendar::destroy($id);
           EventLog::destroy($id);

           Toastr::success('Successfully removed calendar event!', $title = 'Event Deleted!', $options = []);
           return Redirect::back();
        } else {
            Toastr::error('Could not find the calendar event.', $title = 'Invalid Event ID: ' . $id, $options = []);
            return Redirect::back();
        }
    }


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

            Toastr::error('There were some error with your input. Ensure all the fields are filled out', $title = 'Error logging event', $options = []);
            return Redirect::to('/profile')
                ->withInput();
        }


        $event = EventLog::where('event_id' , Input::get('event-id'))->first();

        //Couldnt find the event
        if($event == null) {
            Toastr::error('Event with that Id could not be located.', $title = 'Event ID not found', $options = []);
            return Redirect::to('/profile');
        }
        //Insert based on what the staff inputted
        $event->attendee_count = Input::get('attendee_count');
        $event->event_description = Input::get('event_description');
        $event->volunteer_count = Input::get('volunteer_count');
        $event->total_volunteer_hours = Input::get('volunteer_hours');
        $event->donation_amount = Input::get('donation_amount');

        //Update the status so that the event has now been logged
        $event->log_status = 1;

        $event->save();

        Toastr::success('Successfully logged and saved event information!', $title = 'Success', $options = []);
        return Redirect::to('/profile');
    }
}
