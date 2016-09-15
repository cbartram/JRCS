<?php
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 9/14/16
 * Time: 9:06 PM
 */
$email = $_SESSION['email'];//if user didnt sign in with email then this will always show the default picture
$default = "http://aeroscripts.x10host.com/images/default.jpg";
$size = 350;
$grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default) . "&s=" . $size;
