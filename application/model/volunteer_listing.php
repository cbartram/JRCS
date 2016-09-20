<?php
require_once '../config/connect.php';
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 9/16/16
 * Time: 11:57 PM
 *
 * Note: We pull the data from the volunteer_profile table instead of the login table because it contains
 * the first name, and last name data
 */

$group = $_SESSION['user_group'];
$id = $_SESSION['user_session'];

if($group == "ADMIN") {
    //No Where clause is necessary because the admin gets a high level view of all 3 groups
    $stmt = $DB_con->prepare("SELECT first_name, last_name, volunteer_id FROM volunteer_profile ORDER BY first_name, last_name ASC");
    $stmt->execute();
} else {

    //This statement acts as a filter to only get the volunteers of a particular group
    $stmt = $DB_con->prepare("SELECT first_name, last_name, volunteer_id FROM volunteer_profile WHERE " . format_user_group($group) . " = 1 ORDER BY first_name, last_name ASC");
    $stmt->execute();
}

//todo KBDYNAMIC-38 takes place here
//iterate over each element in the array after getting the result set as an array
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    //Prevents logged in user from seeing him/herself in the list of volunteers enabled by default but can be disabled in the Account Settings panel
    if($row['volunteer_id'] != $id) {
        echo '<div class="col-lg-4">
                            <div class="well cart-item cart-script">
                                <h4 class="user-name">' . $row["first_name"] . ' ' . $row["last_name"] . '</h4>
                                <div class="descr">
                                    <div class="pull-left icon-script icon-script-combat"></div><span class="vol-id">Volunteer with the ID: ' . $row["volunteer_id"] . '</span></div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="cart-add btn btn-success" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-info-sign"></span> See more</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
    }
}

/**
 * Formats the normal user group to sql safe format to be used in queries
 * @param $group the group that the user is in (bebco, jaco, or jbc)
 * @return returns the formatted group for sql
 */
function format_user_group($group) {
    switch($group) {
        case "BEBCO":
            $group = 'bebco_volunteer';
            break;
        case "JACO":
            $group = 'jaco_volunteer';
            break;
        case "JBC":
            $group = 'jbc_volunteer';
            break;
    }
    return $group;
}