<?php
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 9/13/16
 * Time: 2:53 PM
 */
session_start();

//$DB_host = "localhost";
//$DB_user = "jrcs";
//$DB_pass = "jrcs";
//$DB_name = "JRCS";

$DB_host = "us-cdbr-iron-east-04.cleardb.net";
$DB_user = "bd8aa6573fef84";
$DB_pass = "87956034";
$DB_name = "heroku_01b6c023d9d5d29";

try
{
    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}", $DB_user, $DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo $e->getMessage();
}

//Include the necessary files
include_once 'gravatar.php';
include_once 'User.Class.php';
include_once 'util/SQL.php';

//Create global instances of the Class's
$user = new USER($DB_con);
$query = new SQL($DB_con);

