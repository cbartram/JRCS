<?php

namespace App\Http\Controllers\REST;

use App\Calendar;
use App\Cico;
use App\Donations;
use App\EventLog;
use App\Helpers\Helpers;
use App\Profile;
use App\Http\Requests;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
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
        return Calendar::all();
    }

    public function findEventById($id) {
        return Calendar::find($id);
    }

    /**
     * This method is tricky because it queries eventlog for all the events with the proper group
     * we then use those event id's to look up the calendar_events to end up with calendar safe events
     * for the specific group given
     * @param $group
     * @return Collection
     */
    public function findEventsByGroup($group) {
        $events =  EventLog::where('group', $group)->get();

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

        $event_log->save();
        $event->save();
    }

    public function deleteEventById($id) {
        return Calendar::where('id', $id)->delete();
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
        $groupName = Helpers::getGroupNameFromTruncated($group);

        $result = Cico::where($groupName, 1)
            ->where('check_in_date', '>=', $start)
            ->where('check_out_date', '<=', $end)
            ->sum('minutes_volunteered');

        return ['group' => $group, 'hours' => Helpers::minutesToHours($result), 'minutes' => intval($result)];
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


}
