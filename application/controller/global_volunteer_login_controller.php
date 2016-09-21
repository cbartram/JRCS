<?php
require_once '../config/connect.php';
/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 9/21/16
 * Time: 1:54 PM
 */

if(isset($_POST['email'])) {

    //Search the db for this user if they exist return true else return false
    $stmt = $DB_con->prepare("SELECT * FROM  volunteer_profile  WHERE  email = :email");
    $stmt->execute(array(":email" => $_POST['email']));

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //Echo true so that JS can read the result
    if($stmt->rowCount() > 0) {
        echo true;
    } else {
        echo false;
    }

}