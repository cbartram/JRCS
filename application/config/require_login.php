<?php
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 9/20/16
 * Time: 11:29 AM
 *
 * This file can be included in any page under the View directory
 * to require that a user must be authenticated with the system before
 * being granted access to the page.
 */
if(!$user->is_loggedin()) {
    $user->redirect("global_login.php");
}