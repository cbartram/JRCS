<?php

namespace App\Http\Controllers\Profile;

use App\Donations;
use App\EventLog;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Profile;
use App\Programs;
use App\StaffProfile;
use Illuminate\Foundation\Auth\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class StaffProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
            $staff = StaffProfile::find(Auth::user()->id);

            //Finds the volunteers that relate to the staff members "default" group
            if(Session::has('group')) {
                //AKA the user switched his/her group
                if(Session::get('group') == "ADMIN" || Session::get('group') == "JRCS") {

                    //No Where clause get all the Volunteers in the system
                    $volunteers = Profile::where('active', 1)->orderBy('first_name')->paginate(9);
                    $defaultGroup = Session::get('group');

                } else {
                    //get only volunteers who belong to the group that has been switched too
                    $volunteers = Profile::where($this->getGroupNameFromTruncated(Session::get('group')),  1)
                        ->where('active', 1)
                        ->orderBy('first_name')
                        ->paginate(9);

                    $defaultGroup = Session::get('group');
                }

            } else {
                //check to see if the staff member has set a default group in the default group column
                if($staff != null && ($staff->default_group != null || $staff->default_group != '')) {

                    $volunteers = Profile::where($this->getGroupNameFromTruncated($staff->default_group),  1)
                        ->where('active', 1)
                        ->orderBy('first_name')
                        ->paginate(9);

                    $defaultGroup = $staff->default_group;

                    //Set default group
                    Session::set('group', $defaultGroup);

                } else {
                    try {
                        //the user has not switched groups yet nor have they set a default group in the settings give them the default group
                        $volunteers = Profile::where($this->getDefaultGroupFromId(Auth::user()->id), 1)
                            ->where('active', 1)
                            ->orderBy('first_name')
                            ->paginate(9);
                        //Default group the user will be logged in as
                        $defaultGroup = $this->getTruncatedGroupName($this->getDefaultGroupFromId(Auth::user()->id));

                    } catch (\Exception $e) {

                        //If the user tries to access the /profile URI Directly (will already be caught by middleware)
                        return Redirect::to('/');
                    }

                }
            }

            //Iterate through each volunteer searching for a staff member who is also a volunteer
            foreach($volunteers as $volunteer) {
                if(($staff->volunteer_id == $volunteer->id) && $staff->show_self == 0) {
                    $volunteers = $volunteers->keyBy('id');
                    $volunteers->forget($volunteer->id);
                }
            }

            //Handles getting all volunteers used for switching volunteer groups
            $all = Profile::where('active', 1)->get();

            //Handles getting the donation data from the database
            $donations = Donations::where('status', 'pending')
                ->where('group_name', $defaultGroup)
                ->join('profiles', 'donations.volunteer_id', '=', 'profiles.id')
                ->get();

            //Staff members gravatar email
            $gravEmail = md5(strtolower($staff->email));

            //The groups the staff member has access to
            $groups = $this->isMemberOf($staff);

            //Programs for the delete-program modal
            $programs = Programs::where('status', 1)->get();

            //If the user is browsing the admin group show all events
            if($defaultGroup == "ADMIN") {

                //Events that can be logged
                $log = EventLog::join('calendar_events', 'event_log.event_id', '=', 'calendar_events.id')
                    ->where('event_log.active', 1)
                    ->where('calendar_events.active', 1)
                    ->orderBy('start', 'ASC')
                    ->paginate(5);

                //Events that can be deleted (non paginated events)
                $removableEvents = EventLog::join('calendar_events', 'event_log.event_id', '=', 'calendar_events.id')
                    ->where('event_log.active', 1)
                    ->where('calendar_events.active', 1)
                    ->orderBy('start', 'ASC')
                    ->get();

                $allStaff = Cache::remember('allStaff', 60, function() {
                   return StaffProfile::all();
                });


            } else {

                //Events on the calendar and events in the event log where the group is the staff members current group
                $log = EventLog::where('event_log.group', $defaultGroup)
                    ->join('calendar_events', 'event_log.event_id', '=', 'calendar_events.id')
                    ->where('event_log.active', 1)
                    ->where('calendar_events.active', 1)
                    ->orderBy('start', 'ASC')
                    ->paginate(5);

                $removableEvents = EventLog::where('event_log.group', $defaultGroup)
                    ->join('calendar_events', 'event_log.event_id', '=', 'calendar_events.id')
                    ->where('event_log.active', 1)
                    ->where('calendar_events.active', 1)
                    ->orderBy('start', 'ASC')
                    ->get();

                $name = $this->getAttributeName($defaultGroup);

                //Get all staff members who match the current group
                $allStaff = Cache::remember('allStaffNoAdmin', 60, function() use ($name) {
                    return StaffProfile::where($name, 1)->get();
                });
            }


            //Stuff for notifications
            $notificationCount = Notification::where('to', Auth::user()->id)
                ->where('unread', 1)
                ->where('active', 1)
                ->count();

            $notifications = Notification::where('to', Auth::user()->id)
                ->where('active', 1)
                ->orderBy('unread', 'DESC')
                ->get();

            //Allstaff except for yourself because you cant send a notification to yourself
            $notificationStaff = StaffProfile::all()->except(Auth::user()->id);

            //return the view and attach staff & volunteer objects to be accessed by blade templating engine
             return view('profile', compact('staff'), compact('volunteers'))
                ->with('allStaff', $allStaff)
                ->with('defaultGroup', $defaultGroup)
                ->with('gravEmail', $gravEmail)
                ->with('groups', $groups)
                ->with('donations', $donations)
                ->with('all', $all)
                ->with('log', $log)
                ->with('removableEvents', $removableEvents)
                ->with('programs', $programs)
                ->with('notificationCount', $notificationCount)
                ->with('notifications', $notifications)
                ->with('notificationStaff', $notificationStaff);
    }

    /**
     * Returns an array of Groups the currently logged in user has access to
     *
     * @param $user User
     * @return array
     */
    public function isMemberOf($user)
    {
        //Array to hold the results and groups as a key value pair
        $access = [];
        $groupNames = ['BEBCO' => '#b40a30', 'JACO' => '#e7984e', 'JBC' => '#4880d1', 'JRCS' => '#6abb62'];

        //Instantiate the Group object
        foreach($groupNames as $k => $v) {
          array_push($access, new Group($k, $v,  Helpers::hasAccessTo($k, $user->id)));
        }

        //Push admin access onto the stack
        array_push($access, new Group('ADMIN', 'black', Helpers::isAdmin($user->id)));

        return $access;
    }

    /**
     * Returns the first group that the staff member has access to in no particular order.
     * @param $id String staff members ID
     * @return null|string
     */
    public function getDefaultGroupFromId($id)
    {
            $row = StaffProfile::find($id);


            //todo could be replaced with a for loop
            if($row->bebco_access == 1) {
                return "bebco_volunteer";
            }
            if($row->jaco_access == 1) {
                return "jaco_volunteer";
            }
            if($row->jbc_access == 1) {
               return "jbc_volunteer";
            }
            if($row->jrcs_access == 1) {
                return "jrcs_volunteer";
            }

            return null;
    }

    /**
     * Gets a plain text version of the staffs default group instead of the database columns name
     * @param $column string database column's name
     * @return string group name as plain text
     */
    public function getTruncatedGroupName($column) {
        switch($column) {
            case "bebco_volunteer":
                $group = "BEBCO";
                break;
            case "jaco_volunteer":
                $group = "JACO";
                break;
            case "jbc_volunteer":
                $group = "JBC";
                break;
            case "jrcs_volunteer":
                $group = "JRCS";
                break;
            default:
                $group = "NULL";

        }
        return $group;
    }

    /**
     * Returns the column name for a group passed as the parameter (opposite of the getTruncatedGroupName function)
     * @param $truncated string shortened (truncated) group name
     * @return string A String tht matches the column in the database for this respective group
     */
    public function getGroupNameFromTruncated($truncated) {
        switch($truncated) {
            case "BEBCO":
                $group = 'bebco_volunteer';
                break;
            case "JACO":
                $group = 'jaco_volunteer';
                break;
            case "JBC":
                $group = 'jbc_volunteer';
                break;
            case "JRCS":
                $group = 'jrcs_volunteer';
                break;
            default:
                $group = 'error';
        }
        return $group;
    }

    /**
     * Returns the column name for a group passed as the parameter (opposite of the getTruncatedGroupName function)
     * @param $truncated string shortened (truncated) group name
     * @return string A String tht matches the column in the database for this respective group
     */
    public function getAttributeName($truncated) {
        switch($truncated) {
            case "BEBCO":
                $group = 'bebco_access';
                break;
            case "JACO":
                $group = 'jaco_access';
                break;
            case "JBC":
                $group = 'jbc_access';
                break;
            case "JRCS":
                $group = 'jrcs_access';
                break;
            default:
                $group = 'error';
        }
        return $group;
    }
}
