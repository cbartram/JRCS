<?php
require_once '../config/connect.php';
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 9/14/16
 * Time: 1:04 PM
 */

$login_type = $_POST['login_type'];
$email = $_POST['email'];
$password = $_POST['password'];
$remember_me = $_POST['remember_me'];


if($remember_me) {
    setcookie("remember_me_email", $email, time() + (86400 * 90), "/"); // 1 month
    setcookie("remember_me_password", $password, time() + (86400 * 90), "/"); // 1 month
}

//if the post request has been made to this page
if(isset($login_type)) {
   switch ($login_type) {
       case 'JACO':
           if($user->login_JACO($email, $password)) {
               $user->redirect("../view/volunteer_profile.php");
           } else {
               echo false;
           }
           break;
       case 'BEBCO':
           if($user->login_BEBCO($email, $password)) {
               $user->redirect("../view/volunteer_profile.php");
           } else {
               echo false;
           }
           break;
       case 'JBC':
           if($user->login_JBC($email, $password)) {
               $user->redirect("../view/volunteer_profile.php");
           } else {
               echo false;
           }
           break;
       case 'ADMIN':
           if($user->login_admin($email, $password)) {
               $user->redirect("../view/volunteer_profile.php");
           } else {
               echo false;
           }
       default:
           //todo return an error message? 
           break;
   } 
}