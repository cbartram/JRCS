<?php

namespace App\Http\Controllers\REST;

use App\Calendar;
use App\EventLog;
use App\Profile;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RESTController extends Controller
{
    public function all() {
        return Profile::all();
    }

    public function findById($id) {
        return Profile::find($id);
    }

    public function findByEmail($email) {
        return DB::table('profiles')->where('email', '=', $email)->limit(1)->get();
    }

    public function deleteById($id) {
        return DB::table('profiles')->where('id', '=', $id)->delete();
    }

    public function deleteByEmail($email) {
        return DB::table('profiles')->where('email', '=', $email)->delete();
    }

    public function updateById($id, $columnToUpdate, $newValue) {
        $volunteer = Profile::find($id);
        $volunteer->$columnToUpdate = $newValue;

        $volunteer->save();
    }

    public function updateByEmail($email, $columnToUpdate, $newValue) {
        $volunteer = Profile::where('email', '=', $email)->limit(1)->first();
        $volunteer->$columnToUpdate = $newValue;

        $volunteer->save();
    }

    public function findAllEvents() {
        return Calendar::all();
    }

    public function findEventById($id) {
        return Calendar::find($id);
    }

    public function createEvent($start, $end, $title, $color) {
        $id = 'evt_' . str_random(10);

        $event = new Calendar();
        $event->id = $id;
        $event->start = $start;
        $event->end = $end;
        $event->title = str_replace('_', ' ', $title) . " - " . $id;
        $event->color = $color;

        //Insert dummy row into event log with the same pk id as the event we just created
        $event_log = new EventLog();
        $event_log->event_id = $id;
        $event_log->attendee_count = 0;
        $event_log->event_description = "";
        $event_log->volunteer_count = 0;
        $event_log->total_volunteer_hours = 0;
        $event_log->donation_amount = 0;

        $event_log->save();
        $event->save();
    }

    public function deleteEventById($id) {
        return Calendar::where('id', $id)->delete();
    }


}
