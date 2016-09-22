<?php
require_once '../config/connect.php';
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 9/21/16
 * Time: 6:18 PM
 */

//Get all POST Params
$email = $_POST['email'];
$program = $_POST['program'];
$type = $_POST['type'];
$clock_in = $_POST['timestamp'];
$id = $user->get_volunteer_id($email);

//$organization = $user->get_group_from_id($id);

$bool = true;

//Verify that the user clocked out last time
$stmt = $DB_con->prepare("SELECT * FROM volunteer_cico WHERE volunteer_id = :id AND check_out_timestamp = 'null'");
$stmt->execute(array(":id" => $id));

if($stmt->rowCount() > 0){
    //user has not checked out last time we found a row that has not been checked out yet
    echo false;
    $bool = false;
}


if($bool) {
    try {
        $stmt = $DB_con->prepare("INSERT INTO volunteer_cico (volunteer_id, volunteer_email, volunteer_organization, volunteer_program, check_in_timestamp, check_out_timestamp, volunteer_type)
                          VALUES (:id, :email, :volunteer_org, :volunteer_program, :check_in, :check_out, :volunteer_type)");
        $stmt->execute(array(":id" => $id, ":email" => $email, ":volunteer_org" => "JACO", ":volunteer_program" => $program, ":check_in" => $clock_in, ":check_out" => "null", ":volunteer_type" => $type));
        echo true;

    } catch (PDOException $e) {
        $e->getMessage();
        echo false;
    }
}
