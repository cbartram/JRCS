<?php
require_once '../config/connect.php';
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 9/16/16
 * Time: 11:57 PM
 */

$group = $_SESSION['user_group'];

//This statement acts as a filter to only get the volunteers of a particular group
$stmt = $DB_con->prepare("SELECT p.first_name, p.last_name, p.volunteer_id FROM volunteer_profile AS p WHERE " . format_user_group($group) .  " = 1");
$stmt->execute();

//get the result set as an array
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//iterate over each element in the array
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<div class="col-lg-4">
                            <div class="well cart-item cart-script">
                                <h4 class="user-name">' . $row["first_name"] . ' ' . $row["last_name"] . '</h4>
                                <div class="descr">
                                    <div class="pull-left icon-script icon-script-combat"></div><span class="vol-id">Volunteer with the ID: ' . $row["volunteer_id"] . '</span>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="cart-add btn btn-success" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-info-sign"></span> See more</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
}

/**
 * Formats the normal user group to sql safe format to be used in queries
 * @param $group the group that the user is in (bebco, jaco, or jbc)
 * @return $group returns the formatted group for sql
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