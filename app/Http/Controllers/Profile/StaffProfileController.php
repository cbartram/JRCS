<?php

namespace App\Http\Controllers\Profile;

use App\Donations;
use App\EventLog;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Profile;
use App\Programs;
use App\StaffProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class StaffProfileController extends Controller
{

    public function index()
    {
            //Searches the DB for staff profile with the $id = id submitted by the login form
            $staff = DB::table('staff_profile2')->where('id', Session::get('id'))->limit(1)->get()->first();

            //Finds the volunteers that relate to the staff members "default" group
            if(Session::has('group')) {
                //AKA the user switched his/her group
                if(Session::get('group') == "ADMIN") {
                    //No Where clause get all the Volunteers in the system
                    $volunteers = Profile::where('active', 1)->paginate(9);
                    $defaultGroup = Session::get('group');
                } else {
                    //get only volunteers who belong to the group that has been switched too
                    $volunteers = Profile::where($this->getGroupNameFromTruncated(Session::get('group')),  1)
                        ->where('active', 1)
                        ->paginate(9);

                    $defaultGroup = Session::get('group');
                }

            } else {
                //check to see if the staff member has set a default group in the default group column
                if($staff != null && ($staff->default_group != null || $staff->default_group != '')) {
                    $volunteers = Profile::where($this->getGroupNameFromTruncated($staff->default_group),  1)
                        ->where('active', 1)
                        ->paginate(9);
                    $defaultGroup = $staff->default_group;
                } else {
                    try {
                        //the user has not switched groups yet nor have they set a default group in the settings give them the default group
                        $volunteers = Profile::where($this->getDefaultGroupFromId(Session::get('id')), 1)
                            ->where('active', 1)
                            ->paginate(9);
                        //Default group the user will be logged in as
                        $defaultGroup = $this->getTruncatedGroupName($this->getDefaultGroupFromId(Session::get('id')));

                    } catch (\Exception $e) {
                        //If the user tries to access the /profile URI Directly
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
            $all = Profile::all();

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
                $log = EventLog::join('calendar_events', 'event_log.event_id', '=', 'calendar_events.id')
                    ->orderBy('start', 'ASC')
                    ->paginate(5);

                $allStaff = StaffProfile::all();
            } else {

                //Events on the calendar and events in the event log where the group is the staff members current group
                $log = EventLog::where('event_log.group', $defaultGroup)
                    ->join('calendar_events', 'event_log.event_id', '=', 'calendar_events.id')
                    ->orderBy('start', 'ASC')
                    ->paginate(5);


                //Get all staff members who match the current group
                $allStaff = StaffProfile::where($this->getAttributeName($defaultGroup), 1)->get();
            }

            //return the view and attach staff & volunteer objects to be accessed by blade templating engine
             return view('profile', compact('staff'), compact('volunteers'))
                ->with('allStaff', $allStaff)
                ->with('defaultGroup', $defaultGroup)
                ->with('gravEmail', $gravEmail)
                ->with('groups', $groups)
                ->with('donations', $donations)
                ->with('all', $all)
                ->with('log', $log)
                ->with('programs', $programs);
    }

    public function isMemberOf($user)
    {
        $access = [];
        //todo This works locally but gives a string to array error in dev... not sure why
//        $groups = ['bebco_access', 'jaco_access', 'jbc_access'];
//        $truncatedName = ['BEBCO', 'JACO', 'JBC'];
//
//        for($i = 0; $i < 3; $i++) {
//            if($user->$groups[$i] == 1) {
//                $access[$truncatedName[$i]] = true;
//            } else {
//                $access[$truncatedName[$i]] = false;
//            }
//        }
        if($user->bebco_access == 1) {
            $access['BEBCO'] = true;
        } else {
            $access['BEBCO'] = false;
        }
        if($user->jaco_access == 1) {
            $access['JACO'] = true;
        } else {
            $access['JACO'] = false;
        }
        if($user->jbc_access == 1) {
            $access['JBC'] = true;
        } else {
            $access['JBC'] = false;
        }

        //Staff member is a part of all 3 groups
        if($access['BEBCO'] == true && $access['JACO'] == true && $access['JBC'] == true) {
            $access['ADMIN']= true;
        } else {
            $access['ADMIN'] = false;
        }
        return $access;
    }

    /**
     * Returns the first group that the staff member has access to in no particular order.
     * @param $id String staff members ID
     * @return null|string
     */
    public function getDefaultGroupFromId($id)
    {
            $row = DB::table('staff_profile2')->where('id', '=', $id)->get()->first();

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
        $group = '';

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
        $group = '';

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
            default:
                $group = 'error';
        }
        return $group;
    }
}
