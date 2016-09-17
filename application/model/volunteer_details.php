<?php
require_once '../config/connect.php';
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 9/17/16
 * Time: 3:56 PM
 */

//The id of the user that was selected passed as a JS parameter
$id = $_GET['id'];

//This statement acts as a filter to only get the volunteers of a particular group
$stmt = $DB_con->prepare("SELECT * FROM volunteer_profile WHERE volunteer_id = :id");
$stmt->execute(array(":id" => $id));

//get the result set as an array and echo the html table with values populated by PHP
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<tr>';
        echo '<td>' . $row['first_name'] . '</td>';
        echo '<td>' . $row['last_name'] . '</td>';
        echo '<td>' . $row['volunteer_id'] . '</td>';
        echo '<td>' . $row['street_address'] . '</td>';
        echo '<td>' . $row['city'] . '</td>';
        echo '<td>' . $row['state'] . '</td>';
        echo '<td>' . $row['zip_code'] . '</td>';
    echo '<tr>';
}


