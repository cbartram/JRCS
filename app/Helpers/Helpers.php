<?php
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 10/3/16
 * Time: 1:08 PM
 */

namespace App\Helpers;


use App\Profile;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;

class Helpers
{

    /**
     * This function will parse and return elapsed time given start and end dates in UTC format 11-21-15, 12-24-15
     * @param $start Start date in UTC with the format mm-dd-yy
     * @param $end End date in UTC with the format mm-dd-yy
     */
    public static function getElapsedDate($start, $end) {

    }

    /**
     * This function will parse and return elapsed time given the start time and end time in 12 hour format
     * e.g. 12:30 PM and 1:08 AM
     * @param $start Start time in utc time hh:ss AM/PM
     * @param $end End time in utc time hh:ss AM/PM
     */
    public static function getElapsedTime($start, $end) {

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
     * @param $group Group to check BEBCO, JACO, or JBC
     * @param $id id of the volunteer to check
     * @return bool
     */
    public static function isMemberOf($group, $id) {
        $volunteer = DB::table('profiles')->where('id', '=', $id)->limit(1)->get()->first();

        if($volunteer == null) {
            return false;
        }

        switch($group) {
            case 'BEBCO':
                if($volunteer->bebco_volunteer == 1) {
                    return true;
                } else {
                    return false;
                }
                break;
            case 'JACO':
                if($volunteer->jaco_volunteer == 1) {
                    return true;
                } else {
                    return false;
                }
                break;
            case 'JBC':
                if($volunteer->jbc_volunteer == 1) {
                    return true;
                } else {
                    return false;
                }
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
        $volunteer = DB::table('profiles')->where('email', '=', $email)->limit(1)->get()->first();

        if($volunteer == null) {
            return false;
        }

        switch($group) {
            case 'BEBCO':
                if($volunteer->bebco_volunteer == 1) {
                    return true;
                } else {
                    return false;
                }
                break;
            case 'JACO':
                if($volunteer->jaco_volunteer == 1) {
                    return true;
                } else {
                    return false;
                }
                break;
            case 'JBC':
                if($volunteer->jbc_volunteer == 1) {
                    return true;
                } else {
                    return false;
                }
                break;
            default:
                return false;
        }
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