<?php
require_once '../config/connect.php';
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 9/14/16
 * Time: 9:11 PM
 */

$user->logout();
$user->redirect("../view/global_login.php?response=You%20have%20been%20successfully%20logged%20out!");