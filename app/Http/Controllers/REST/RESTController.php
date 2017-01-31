<?php

namespace App\Http\Controllers\REST;

use App\Calendar;
use App\Cico;
use App\Donations;
use App\EventLog;
use App\Helpers\Helpers;
use App\Profile;
use App\Http\Requests;
use App\Programs;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
        return Calendar::where('active', 1)
            ->get();
    }

    public function findEventById($id) {
        return Calendar::where('id', $id)
            ->where('active', 1)
            ->get();
    }

    /**
     * This method is tricky because it queries eventlog for all the events with the proper group
     * we then use those event id's to look up the calendar_events to end up with calendar safe events
     * for the specific group given
     * @param $group
     * @return Collection
     */
    public function findEventsByGroup($group) {
        $events =  EventLog::where('group', $group)
            ->where('active', 1)
            ->get();

        //Create a new collection to house the objects
        $result = new Collection();

        //Iterate over each item in the events collection adding to the result collection
        foreach($events as $event) {
            if($event != null) {
                $result->add(Calendar::find($event->event_id));
            }
        }
        return $result;
    }

    public function createEvent($start, $end, $title, $color, $group) {
        $id = 'evt_' . str_random(10);

        if($end == null || $end == "" ) {
            $end = $start;
        }

        $event = new Calendar();
        $event->id = $id;
        $event->start = $start;
        $event->end = $end;
        $event->title = str_replace('_', ' ', $title);
        $event->color = $color;
        $event->active = 1;

        //Insert dummy row into event log with the same pk id as the event we just created
        $event_log = new EventLog();
        $event_log->event_id = $id;
        $event_log->attendee_count = 0;
        $event_log->event_description = "";
        $event_log->volunteer_count = 0;
        $event_log->total_volunteer_hours = 0;
        $event_log->donation_amount = 0;
        $event_log->group = $group;

        //The event is unlogged by default
        $event_log->log_status = 0;
        $event_log->active     = 1;

        $event_log->save();
        $event->save();
    }

    public function deleteEventById($id) {
         $calendar = Calendar::find($id);
         $eventLog = EventLog::find($id);

         if($calendar != null && $eventLog != null) {
             $calendar->active = 0;
             $eventLog->active = 0;

             $calendar->save();
             $eventLog->save();

             return "true";
         } else {
             return "false";
         }
    }


    public function openDonation($id) {
        $donations = Donations::find($id);

        if($donations == null) {
            return "false";
        } else {
            $donations->status = 'pending';
            $donations->action_by = Session::get('id');
            $donations->save();
            return "true";
        }
    }

    public function denyDonation($id) {
        $donations = Donations::find($id);

        if($donations == null) {
            return "false";
        } else {
            $donations->status = 'Denied';
            $donations->action_by = Session::get('id');
            $donations->save();
            return "true";
        }
    }

    public function approveDonation($id) {
        $donations = Donations::find($id);

        if($donations == null) {
            return "false";
        } else {
            $donations->status = 'Approved';
            $donations->action_by = Session::get('id');
            $donations->save();
            return "true";
        }
    }

    /**
     * Authenticates that a provided email and un-hashed password references
     * a row in the database
     * @param $email Email Address
     * @param $password Un-hashed password
     * @return bool Returns true if the email and password match a row in the database false otherwise
     */
    public function authenticate() {
        $staff = DB::table('staff_profile2')->where('email', Input::get('email'))->limit(1)->first();
        if($staff != null) {
            if($staff->email == Input::get('email') && Hash::check(Input::get('password'), $staff->password)) {
                return "true";
            } else {
                return "false";
            }
        } else {
            return "false";
        }
    }

    /**
     * Gets all hours volunteered for all three organizations
     * @return array JSON String
     */
    public function getAllHours() {
        $hours = Cico::sum('minutes_volunteered');

        return ['group' => 'all', 'hours' => Helpers::minutesToHours($hours), 'minutes' => intval($hours)];
    }


    public function getAllHoursOnDate($date) {
        $result = Cico::where('check_in_date', '>=', $date)
            ->where('check_out_date', '<=', $date)
            ->sum('minutes_volunteered');

        return ['group' => 'all', 'hours' => Helpers::minutesToHours($result), 'minutes' => intval($result)];
    }


    /**
     * Aggregates the sum of the volunteers hours with a given id from epoc till now.
     * @param $id string volunteer Id
     * @return String total hours volunteered in the format HH:MM
     */
    public function getHoursById($id) {
        $minutes = Cico::where('volunteer_id', $id)->sum('minutes_volunteered');

        if($minutes != null) {

            return ['id' => $id, 'hours' =>  Helpers::minutesToHours($minutes), 'minutes' => intval($minutes)];

        } else {
            return "0:00";
        }
    }


    public function getHoursByIdAndGroupBetween($id, $group, $start, $end) {

        $group = ['bebco', 'jaco', 'jbc'];
        $response = ['bebco' => null, 'jaco' => null, 'jbc' => null];

        foreach($group as $k => $v) {
            $min = Cico::where('volunteer_id', $id)
                ->where('for_' . $v, 1)
                ->where('check_in_date', '>=', $start)
                ->where('check_out_date', '<=', $end)
                ->sum('minutes_volunteered');
            $response[$v] = Helpers::minutesToHours($min);
        }

        $all = Cico::where('volunteer_id', $id)
            ->where('check_in_date', '>=', $start)
            ->where('check_out_date', '<=', $end)
            ->sum('minutes_volunteered');

        //Append several KV elements to the response
        $response['all'] = Helpers::minutesToHours($all);
        $response['id']  = $id;

        return $response;

    }


    /**
     * Aggregates the sum of the volunteers hours between the start date and
     * the end date given the id
     * @param $start string Start date in the format yyyy-mm-dd
     * @param $end string end date in the format yyyy-mm-dd
     * @param $id string volunteers id
     * @return mixed Collection object
     */
    public function getHoursBetween($id, $start, $end) {
        //Get objects between the given dates
        $resultSet = Cico::where('volunteer_id', $id)
            ->where('check_in_date', '>=', $start)
            ->where('check_out_date', '<=', $end)
            ->sum('minutes_volunteered');

        return ['id' => $id, 'hours' => Helpers::minutesToHours($resultSet), 'minutes' => intval($resultSet)];
    }

    /**
     * This is very similar the the getHoursBetween() method except that it will return
     * the sum of the volunteers hours on every day between the start date and the end date
     *
     * @param $id string volunteer id
     * @param $start string date in the format Y-m-d
     * @param $end string date in the format Y-m-d
     * @return array $data
     */
    public function getHoursForVolunteerBetween($id, $start, $end) {

        $ranges = Helpers::generateDateRange(Carbon::createFromFormat('Y-m-d', Carbon::now()->subDays(5)->format('Y-m-d')),
            Carbon::createFromFormat('Y-m-d', Carbon::now()->format('Y-m-d')));

        $data = [];

        foreach($ranges as $range) {
            $value = Cico::where('volunteer_id', $id)
                ->where('check_in_date', '>=', $range)
                ->where('check_out_date', '<=', $range)
                ->sum('minutes_volunteered');

            array_push($data, intval($value));
        }

        return [$data, $ranges];

    }

    /**
     * Gets the sum of all hours volunteered for the group given
     * @param $group string Group Name BEBCO,JACO,JBC
     * @return array JSON String
     */
    public function getHoursByGroup($group) {
        $groupName = Helpers::getGroupNameFromTruncated($group);

        $result = Cico::where($groupName, 1)
            ->sum('minutes_volunteered');

        return ['group' => $group, 'hours' => Helpers::minutesToHours($result), 'minutes' => intval($result)];
    }

    /**
     * Gets the sum of all hours volunteered for the given group
     * between the given start date and end date
     * @param $group string group BEBCO, JACO, JBC
     * @param $start string Start date in the format yyyy-mm-dd
     * @param $end string End date in the format yyyy-mm-dd
     * @return array JSON String
     */
    public function getHoursByGroupBetween($group, $start, $end) {
        //Default days to show is 7
        $days = 7;

        //If the user has specified a specific number of days to show
        if(Input::get('days')) {
            $days = intval(Input::get('days'));
        }

        $groupName = Helpers::getGroupNameFromTruncated($group);

        $ranges = Helpers::generateDateRange(Carbon::createFromFormat('Y-m-d', Carbon::now()->subDays($days)->format('Y-m-d')),
            Carbon::createFromFormat('Y-m-d', Carbon::now()->format('Y-m-d')));

        $data = [];

        if($group == "ADMIN") {
            foreach($ranges as $range) {
                $result = Cico::where('check_in_date', '>=', $range)
                    ->where('check_out_date', '<=', $range)
                    ->sum('minutes_volunteered');

                array_push($data, intval($result));
            }
        } else {

            foreach($ranges as $range) {
                $result = Cico::where($groupName, 1)
                    ->where('check_in_date', '>=', $range)
                    ->where('check_out_date', '<=', $range)
                    ->sum('minutes_volunteered');

                array_push($data, intval($result));
            }
        }

        return ['group' => $group, $data, $ranges];
    }

    /**
     * Updates the volunteer profile to archive status
     * @param $id string volunteer id
     * @return string true if the operation is successful false otherwise
     */
    public function archiveVolunteer($id) {
        $volunteer = Profile::find($id);

        if($volunteer != null) {
            $volunteer->active = 0;
            $volunteer->save();

            return "true";
        } else {
            return "false";
        }
    }

    /**
     * Updates the volunteer profile to active status
     * @param $id string volunteer id
     * @return string  if the operation is successful false otherwise
     */
    public function renewVolunteer($id) {
        $volunteer = Profile::find($id);

        if($volunteer != null) {
            $volunteer->active = 1;
            $volunteer->save();

            return "true";
        } else {
            return "false";
        }
    }


    /**
     * Renews the volunteer program to active
     * @param $id string id
     * @return string true if the operation is successful false otherwise
     */
    public function renewProgram($id) {
        $program = Programs::find($id);

        if($program != null) {
            $program->status = 1;
            $program->save();

            return "true";
        } else {
            return "false";
        }
    }


    /**
     * Archives an event hiding it from being shown from the calendar
     * and on the event log
     * @param $id string event id
     * @return string true if the operation is successful false otherwise
     */
    public function archiveEvent($id) {
        $eventLog = EventLog::find($id);
        $calendarEvent = Calendar::find($id);

        if($eventLog != null && $calendarEvent != null) {
            $eventLog->active = 0;
            $calendarEvent->active = 0;

            $eventLog->save();
            $calendarEvent->save();

            return "true";
        } else {
            return "false";
        }
    }

    /**
     * Handles renewing an event after it has been archived
     * @param $id string event id
     * @return string true if the operation is successful false otherwise
     */
    public function renewEvent($id) {
        $eventLog = EventLog::find($id);
        $calendarEvent = Calendar::find($id);

        if($eventLog != null && $calendarEvent != null) {
            $eventLog->active = 1;
            $calendarEvent->active = 1;

            $eventLog->save();
            $calendarEvent->save();

            return "true";
        } else {
            return "false";
        }
    }

    /**
     * Updates a Check in timestamp in the /checkout page via an ajax
     * request made over the input to an HTML table
     * @return string true if the operation was successful false otherwise
     */
    public function updateTimestamp() {
        try {

            $timestamp = Input::get('timestamp');

            if (Carbon::createFromFormat('Y-m-d g:i A', $timestamp) != false) {
                //valid timestamp
                $row = Cico::find(Input::get('id'));
                $row->check_in_timestamp = $timestamp;
                $row->check_in_date = substr($timestamp, 0, strpos($timestamp, ' '));

                $row->save();


                return "true";
            }
        } catch(Exception $e) {
            Log::error($e);
            //Exception thrown cannot create format insufficient data
            return "false";
        }
        return "false";
    }

    /**
     * Updates the demographic information for a volunteer via an ajax
     * request made over the input to an HTML table
     * @return string true if the operation was successful false otherwise
     */
    public function updateDemographics() {
        //Iterate through input finding the key column to update & value column
        $key = [];
        $value = [];
        foreach(Input::all() as $k => $v) {
            array_push($key, $k);
            array_push($value, $v);
        }

        array_map("strval", $value);
        array_map("strval", $key);

        $k = $key[1];
        $v = $value[1];

        $volunteer = Profile::find(Input::get('id'));
        $volunteer->$k = $v;

        $volunteer->save();

        return "true";
    }

    /**
     * Updates cico information for a volunteer who has been found through a search
     * the request is made over the input to an HTML table
     */
    public function updateCico() {
        try {

            $key = [];
            $value = [];

            foreach(Input::all() as $k => $v) {
                array_push($key, $k);
                array_push($value, $v);
            }

             //to avoid an array to string conversion error
             array_map("strval", $value);
             array_map("strval", $key);

             $timestamp = $value[1];

            if (Carbon::createFromFormat('Y-m-d g:i A', $timestamp) != false) {
                //valid timestamp
                $row = Cico::find($value[0]);


                if($key[1] == 'check_in_timestamp') {
                    $row->check_in_timestamp = $timestamp;
                    $row->check_in_date = substr($timestamp, 0, strpos($timestamp, ' '));

                    //Recalculate the new minutes volunteered
                    $checkInDate = Carbon::createFromFormat('Y-m-d g:i A', $timestamp);
                    $checkOutDate = Carbon::createFromFormat('Y-m-d g:i A', $row->check_out_timestamp);
                    Log::info('Checkin in edited: ' . $checkInDate);


                    $row->minutes_volunteered = $checkInDate->diffInMinutes($checkOutDate);

                } else {
                    $row->check_out_timestamp = $timestamp;
                    $row->check_out_date = substr($timestamp, 0, strpos($timestamp, ' '));

                    //Recalculate the new minutes volunteered
                    $checkOutDate = Carbon::createFromFormat('Y-m-d g:i A', $timestamp);
                    $checkInDate = Carbon::createFromFormat('Y-m-d g:i A', $row->check_in_timestamp);

                    $row->minutes_volunteered = $checkInDate->diffInMinutes($checkOutDate);

                }

                $row->save();

                return "true";
            }
        } catch(Exception $e) {
            Log::error($e);

            //Exception thrown cannot create format insufficient data
            return "false";
        }
    }


}
