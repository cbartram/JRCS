<?php
require_once '../config/connect.php';
/**
 * Created by PhpStorm.
 * User: christian bartram
 * Date: 9/15/16
 * Time: 10:39 AM
 */
$groups = array('BEBCO', 'JACO', 'JBC', "ADMIN");

//Iterate through the array creating a new html link for the view for each group the volunteer is a member of
for($i = 0; $i < sizeof($groups); $i++) {
    if($user->is_member_of($_SESSION['email'], $groups[$i])) {

        //If the group presented is the users currently logged in group add a disabled link (users cant switch to their current group)
        if($groups[$i] == $_SESSION['user_group']) {
            echo  '<li class="disabled"><a href="#">' . $groups[$i] . ' - Current Organization</a></li>';
        } else {
            echo '<li><a href="../controller/handle_switch.php?group=' . $groups[$i] . '">' . $groups[$i] . '</a></li>';
        }
    } 
}




