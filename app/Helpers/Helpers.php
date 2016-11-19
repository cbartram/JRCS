<?php
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 10/3/16
 * Time: 1:08 PM
 */

namespace App\Helpers;


use App\Profile;
use App\StaffProfile;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\String_;

class Helpers
{
    /**
     * Authenticates that a provided email and un-hashed password references
     * a row in the database
     * @param $email Email Address
     * @param $password Un-hashed password
     * @return bool Returns true if the email and password match a row in the database false otherwise
     */
    public static function authenticate($email, $password) {
        $staff = DB::table('staff_profile2')->where('email', $email)->limit(1)->first();

        if($staff == null) {
            return false;
        } else {
            if($staff->email == $email && Hash::check($password, $staff->password)) {
                return true;
            }
        }
        return false;
    }


    /**
     * Converts minutes to hours in the format HH:MM
     * @param minutes integer Int value in minutes
     * @return string Hours in the format HH:MM
     */
    public static function minutesToHours($minutes) {
        $m = $minutes % 60;
        $h = ($minutes - $m) / 60;

        return $h . ":" . ($m < 10 ? "0" : "") . $m;
    }


    /**
     * This function promotes a volunteer to a staff member. It is different from the promote
     * admin function because it provides the flexibility to designate which groups the staff
     * member will have access too. This function can serve as promoteAdmin() if all three groups
     * are true.
     * @param $volunteerID string volunteer's id
     * @param $password string Staff members password
     * @param $bebco boolean Bebco Access
     * @param $jaco boolean Jaco Access
     * @param $jbc boolean jbc access
     * @return boolean True if the staff was successfully copied false otherwise
     */
    public static function promoteToStaff($volunteerID, $password, $bebco, $jaco, $jbc) {
        $volunteer = Profile::find($volunteerID);
        $staff = new StaffProfile();

        //todo possibly could be done much simpler with replicate()->save();

        //check to make sure the volunteer exists
        if($volunteer != null) {
            $staff->id = 'stf_' . str_random(8);
            $staff->email = $volunteer->email;
            $staff->password = Hash::make($password);
            $staff->first_name = $volunteer->first_name;
            $staff->last_name = $volunteer->last_name;
            $staff->address = $volunteer->address;
            $staff->city = $volunteer->city;
            $staff->state = $volunteer->state;
            $staff->zip_code = $volunteer->zip_code;

            //Check staff members access and grant access accordingly
            if($bebco) {
                $staff->bebco_access = 1;
            } else {
                $staff->bebco_access = 0;
            }

            if($jaco) {
                $staff->jaco_access = 1;
            } else {
                $staff->jaco_access = 0;
            }

            if($jbc) {
                $staff->jbc_access = 1;
            } else {
                $staff->jbc_access = 0;
            }

            $staff->volunteer_id = $volunteer->id;
            $staff->save();

            return true;
        } else {
            return false;
        }
    }

    /**
     * Removes staff row from the Staff_profile2 table in the database
     * @param $staffID string Staff members ID
     * @return boolean true if the deletion was successful false otherwise
     */
    public static function demoteFromStaff($staffID) {
        StaffProfile::destroy($staffID);
        return true;
    }

    /**
     * Promotes a staff member to admin.
     * @param $staffID string Staff members ID
     * @return bool True if the operation was successful false otherwise
     */
    public static function promoteToAdmin($staffID) {
        $staff = StaffProfile::find($staffID);

        $staff->bebco_access = 1;
        $staff->jaco_access  = 1;
        $staff->jbc_access   = 1;

        $staff->save();
        return true;
    }

    /**
     * This method simply deletes access from all 3 of their groups but does not however delete their
     * profile from the table use demoteFromStaff() instead
     * @param $staffID
     * @return boolean True if the operation was successful false otherwise
     */
    public static function demoteFromAdmin($staffID) {
        $staff = StaffProfile::find($staffID);

        if($staff != null) {
            $staff->bebco_access = 0;
            $staff->jaco_access  = 0;
            $staff->jbc_access   = 0;

            $staff->save();
            return true;
        } else {
            return false;
        }
    }


    /**
     * Authenticates a user provided a Hashed Password and email
     * @param $email Users email
     * @param $password users password
     * @return bool true if the user is authenticated false otherwise
     */
    public static function authenticateWithHash($email, $password) {
        $staff = DB::table('staff_profile2')->where('email', $email)->limit(1)->first();

        if($staff == null) {
            return false;
        } else {
            if($staff->email == $email && $password == $staff->password) {
                return true;
            }
        }
        return false;
    }


    /**
     * Finds all volunteer profiles in the profiles table
     * @return mixed All volunteers in the profiles table
     */
    public static function getAll() {
        return DB::table('profiles')->get();
    }


    /**
     * Fetches one volunteer profile given the volunteers id.
     * @param $id The id of the volunteer to search for
     * @return null Returns the volunteer with the given id if none is found returns null
     */
    public static function getVolunteerById($id) {
       $volunteer = DB::table('profiles')->where('id', '=', $id)->limit(1)->get()->first();
        if($volunteer != null) {
            return $volunteer;
        } else {
            return null;
        }
    }

    /**
     * Fetches one volunteer profile given the volunteers email.
     * @param $email The email of the volunteer to search for
     * @return null Returns the volunteer with the given email if none is found returns null
     */
    public static function getVolunteerByEmail($email) {
        $volunteer = DB::table('profiles')->where('email', '=', $email)->limit(1)->get()->first();
        if($volunteer != null) {
            return $volunteer;
        } else {
            return null;
        }
    }

    /**
     * Fetches one volunteer from the specified table where the volunteers id is given.
     * @param $table Table to search for the volunteer through
     * @param $id Id of the volunteer to find
     * @return null Returns the volunteer with the given id if none is found returns null
     */
    public static function getVolunteerFromById($table, $id) {
        $volunteer = DB::table($table)->where('id', '=', $id)->limit(1)->get()->first();
        if($volunteer != null) {
            return $volunteer;
        } else {
            return null;
        }
    }

    /**
     * Returns true if volunteer with the given id is a member of the given group. It will return false if they are not part of that group
     * @param $group string Group to check BEBCO, JACO, or JBC
     * @param $id string id of the volunteer to check
     * @return bool
     */
    public static function isMemberOf($group, $id) {
        $volunteer = DB::table('profiles')->where('id', '=', $id)->first();

        if($volunteer == null) {
            return false;
        }

        switch($group) {
            case 'BEBCO':
                if($volunteer->bebco_volunteer == 1) {return true;} else {return false;}
                break;
            case 'JACO':
                if($volunteer->jaco_volunteer == 1) {return true;} else {return false;}
                break;
            case 'JBC':
                if($volunteer->jbc_volunteer == 1) {return true;} else {return false;}
                break;
            default:
                return false;
        }
    }

    /**
     * Returns true if volunteer with the given email is a member of the given group. It will return false if they are not part of that group
     * @param $group Group to check BEBCO, JACO, or JBC
     * @param $email email of the volunteer to check
     * @return bool
     */
    public static function isMemberOfByEmail($group, $email) {
        $volunteer = DB::table('profiles')->where('email', $email)->limit(1)->get()->first();

        if($volunteer == null) {
            return false;
        }

        switch($group) {
            case 'BEBCO':
                $volunteer->bebco_volunteer == 1 ? true : false;
                break;
            case 'JACO':
                $volunteer->jaco_volunteer == 1 ? true : false;
                break;
            case 'JBC':
                $volunteer->jbc_volunteer == 1 ? true :  false;
                break;
            default:
                return false;
        }
    }


    /**
     * Returns the column name for a group passed as the parameter (opposite of the getTruncatedGroupName function)
     * @param $truncated string shortened (truncated) group name
     * @return string A String tht matches the column in the database for this respective group
     */
    public static function getGroupNameFromTruncated($truncated) {
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
     * Returns the volunteers first name and last name given their id
     * @param $id Volunteer ID
     * @return string
     */
    public static function getName($id) {
        $volunteer = DB::table('profiles')->where('id', '=', $id)->limit(1)->get()->first();

        if($volunteer == null) {
            return 'Invalid volunteer Id';
        }

        return $volunteer->first_name . " " . $volunteer->last_name;
    }


    /**
     * Returns a volunteers ID given their email. If the volunteer cant be found returns null
     * @param $email volunteers email
     * @return string
     */
    public static function getId($email) {
        $volunteer = DB::table('profiles')->where('email', '=', $email)->limit(1)->get()->first();

        if($volunteer == null) {
            return null;
        }

        return $volunteer->id;
    }

    /**
     * Returns a volunteers email given their id. If the volunteer cant be found returns null
     * @param $id volunteers id
     * @return null
     */
    public static function getEmail($id) {
        $volunteer = DB::table('profiles')->where('id', '=', $id)->limit(1)->get()->first();

        if($volunteer == null) {
            return null;
        }

        return $volunteer->email;
    }

    /**
     * Returns true if the staff member with the given id is also an administrator and false otherwise
     * If a staff member with the id could not be found returns null.
     * @param $id Staff members id
     * @return bool
     */
    public static function isAdmin($id) {
        $volunteer = DB::table('staff_profile2')->where('id', '=', $id)->limit(1)->get()->first();

        if($volunteer == null) {
            return null;
        }

        if($volunteer->bebco_access == 1 && $volunteer->jaco_access == 1 && $volunteer->jbc_access == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns staff members first and last name given their id
     * @param $id String staff id
     * @return null|string Firstname concatenated by a space then the staff members last name
     */
    public static function getStaffName($id) {
        $staff = DB::table('staff_profile2')->where('id', '=', $id)->first();

        if($staff == null) {
            return null;
        }

        return $staff->first_name . " " . $staff->last_name;
    }

    /**
     * Returns a staff object from the database given the ID. If no staff member can be found null is returned
     * @param $id The staff members id
     * @return null
     */
    public static function getStaffById($id) {
        $staff = DB::table('staff_profile2')->where('id', '=', $id)->limit(1)->get()->first();

        if($staff == null) {
            return null;
        }

        return $staff;
    }


    /**
     * Returns a staff object from the database given the email. If no staff member can be found null is returned
     * @param $email The staff members email
     * @return null
     */
    public static function getStaffByEmail($email) {
        $staff = DB::table('staff_profile2')->where('email', '=', $email)->limit(1)->get()->first();

        if($staff == null) {
            return null;
        }

        return $staff;
    }


    /**
     * Returns true if the staff member has access to the group specified false otherwise.
     * Use isAdmin() if you are checking if they are an admin or not
     * @param $group Group i.e BEBCO, JACO or JBC
     * @param $staffId
     * @return bool|null
     */
    public static function hasAccessTo($group, $staffId) {
        $staff = DB::table('staff_profile2')->where('id', '=', $staffId)->limit(1)->get()->first();
        $truncatedGroup = "";

        if($staff == null) {
            return null;
        }
        switch($group) {
            case "BEBCO":
                $truncatedGroup = 'bebco_access';
                break;
            case 'JACO':
                $truncatedGroup = 'jaco_access';
                break;
            case 'JBC':
                $truncatedGroup = 'jbc_access';
                break;
        }

        if($staff->$truncatedGroup == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the number of groups a staff member has access to
     * e.g Cbartram - 3 (JACO, BEBCO, JBC) Joe Schmo - 1 (JACO)
     * @param $staffId Staff id string
     * @return int Number of groups the staff member has access to
     */
    public static function getAccessCount($staffId) {
        $groups = ["JACO", "BEBCO", "JBC"];
        $count = 0;

        foreach($groups as $group) {
            if(self::hasAccessTo($group, $staffId)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Returns a List of groups the volunteer is a member of separated by commas
     * @param $id string volunteer id
     * @return string String of groups separated by commas
     * @throws \Exception
     */
    public static function getGroups($id) {
        $groups = ['BEBCO', 'JACO', 'JBC'];

        $result = "";

        foreach($groups as $group) {
            if(self::isMemberOf($group, $id)) {
                $result .= $group  . ',';
            }
        }

        return rtrim($result , ',');

    }

    /**
     * Get an element from an array.
     *
     * @param  array  $data
     * @param  string $key     Specify a nested element by separating keys with full stops.
     * @param  mixed  $default If the element is not found, return this.
     *
     * @return mixed
     */
    public static function get(array $data, $key, $default = null)
    {
        if ($key === null) {
            return $data;
        }
        if (is_array($key)) {
            return static::getArray($data, $key, $default);
        }
        foreach (explode('.', $key) as $segment) {
            if (!is_array($data)) {
                return $default;
            }
            if (!array_key_exists($segment, $data)) {
                return $default;
            }
            $data = $data[$segment];
        }
        return $data;
    }


    protected static function getArray(array $input, $keys, $default = null)
    {
        $output = array();
        foreach ($keys as $key) {
            static::set($output, $key, static::get($input, $key, $default));
        }
        return $output;
    }
    /**
     * Determine if an array has a given key.
     *
     * @param  array   $data
     * @param  string  $key
     *
     * @return boolean
     */
    public static function has(array $data, $key)
    {
        foreach (explode('.', $key) as $segment) {
            if (!is_array($data)) {
                return false;
            }
            if (!array_key_exists($segment, $data)) {
                return false;
            }
            $data = $data[$segment];
        }
        return true;
    }
    /**
     * Set an element of an array.
     *
     * @param array  $data
     * @param string $key   Specify a nested element by separating keys with full stops.
     * @param mixed  $value
     */
    public static function set(array &$data, $key, $value)
    {
        $segments = explode('.', $key);
        $key = array_pop($segments);
        // iterate through all of $segments except the last one
        foreach ($segments as $segment) {
            if (!array_key_exists($segment, $data)) {
                $data[$segment] = array();
            } else if (!is_array($data[$segment])) {
                throw new \UnexpectedValueException('Non-array segment encountered');
            }
            $data =& $data[$segment];
        }
        $data[$key] = $value;
    }
    /**
     * Unset an element from an array.
     *
     * @param  array  &$data
     * @param  string $key   Specify a nested element by separating keys with full stops.
     */
    public static function forget(array &$data, $key)
    {
        $segments = explode('.', $key);
        $key = array_pop($segments);
        // iterate through all of $segments except the last one
        foreach ($segments as $segment) {
            if (!array_key_exists($segment, $data)) {
                return;
            } else if (!is_array($data[$segment])) {
                throw new \UnexpectedValueException('Non-array segment encountered');
            }
            $data =& $data[$segment];
        }
        unset($data[$key]);
    }
}