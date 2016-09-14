<?php
require_once '../config/connect.php';
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 9/14/16
 * Time: 3:35 PM
 */
if(isset($_SESSION['user_session'])) {
    echo '<h2>Welcome, ' . $_SESSION['email'] . '</h2>';
    echo '<p>You are now logged in to the volunteer profile view!</p>';
} else {
    echo '<p>Your session has expired</p>';
}


