<?php
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 10/3/16
 * Time: 1:08 PM
 */

namespace App\Helpers;


use Illuminate\Support\Facades\DB;

class Helpers
{

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
}