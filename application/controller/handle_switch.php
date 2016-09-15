<?php
require_once '../config/connect.php';
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 9/15/16
 * Time: 6:28 PM
 */

$group = $_GET['group'];

switch($group) {
    case "JACO":
        $user->switch_JACO($_SESSION['email']);
        $user->redirect("../view/volunteer_profile.php");
        break;
    case "BEBCO":
        $user->switch_BEBCO($_SESSION['email']);
        $user->redirect("../view/volunteer_profile.php");
        break;
    case "JBC":
        $user->switch_JBC($_SESSION['email']);
        $user->redirect("../view/volunteer_profile.php");
        break;
}