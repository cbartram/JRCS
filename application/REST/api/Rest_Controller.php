<?php
require '../../vendor/autoload.php';

/**
 * Created by PhpStorm.
 * User: christianbartram
 * Date: 9/19/16
 * Time: 5:09 PM
 */

//Create and configure Slim app
$config = ['settings' => [
    'addContentLengthHeader' => false,
]];

$app = new \Slim\App($config);

//Slim routes resource URIs to callback functions in response to specific HTTP request methods (e.g. GET, POST, PUT, DELETE)
$app->get('/volunteers', 'getVolunteers');
$app->get('/volunteers/:id',  'getVolunteer');
$app->get('/volunteers/search/:email', 'findByEmail');
$app->post('/volunteers/add', 'addVolunteer');
$app->delete('/volunteers/:id',   'deleteVolunteer');

$app->run();

/**
 * Callback functions slim uses to execute queries on the database
 */
function getVolunteers() {
    try {
        $db = getConnection();

        $stmt = $db->prepare("SELECT volunteer_id, first_name, last_name, 
                                      street_address, city, state, zip_code, email, phone_number, 
                                      volunteer_type, bebco_volunteer, jaco_volunteer, jbc_volunteer, 
                                      background_consent, authentication_level 
                                      FROM volunteer_profile ORDER BY last_name, first_name ASC");
        $stmt->execute();
        $volunteers = $stmt->fetchAll(PDO::FETCH_OBJ);

        echo '{"volunteers": ' . json_encode($volunteers) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

}


function getVolunteer($id) {

    try {
        $db = getConnection();
        $stmt = $db->prepare("SELECT volunteer_id, first_name, last_name, 
                                      street_address, city, state, zip_code, email, phone_number, 
                                      volunteer_type, bebco_volunteer, jaco_volunteer, jbc_volunteer, 
                                      background_consent, authentication_level  FROM volunteer_profile WHERE volunteer_id = :id");
        $stmt->bindParam("id", $id);
        $stmt->execute();

        $volunteer = $stmt->fetchObject();
        $db = null;

        echo json_encode($volunteer);

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


//todo No idea if this works or not will need some testing
function addVolunteer() {
    //Request object makes it easy to access the request’s data e.g. JSON
    $request = Slim::getInstance()->request();

    $json = json_decode($request->getBody());

    $sql = "INSERT INTO volunteer_profile (volunteer_id, first_name, last_name, street_address,
                        city, state, zip_code, email, phone_number, volunteer_type, background_consent, bebco_volunteer, jaco_volunteer, jbc_volunteer, authentication_level, password)
                  VALUES (:id, :firstName, :lastName, :addr, :city, :state, :zip, :email, :phone, :volunteerType, :backgroundConsent, :bebco, :jaco, :jbc,  0, :pass)";
    try {

        $db = getConnection();

        //Prepare the statement
        $stmt = $db->prepare($sql);

        $new_password = password_hash($json->password, PASSWORD_DEFAULT, ['cost' => 12]);

        $json->id = "vol_" . substr($new_password, strlen($new_password) - 8, strlen($new_password));

        //Bind params to the statement
        $stmt->bindParam(":id", $json->id);
        $stmt->bindParam(":firstName", $json->first_name);
        $stmt->bindParam(":lastName", $json->last_name);
        $stmt->bindParam(":addr", $json->address);
        $stmt->bindParam(":city", $json->city);
        $stmt->bindParam(":state", $json->state);
        $stmt->bindParam(":zip", $json->zip_code);
        $stmt->bindParam(":email", $json->email);
        $stmt->bindParam(":phone", $json->phone_number);
        $stmt->bindParam(":volunteerType", $json->volunteer_type);
        $stmt->bindParam(":backgroundConsent", $json->background_consent);
        $stmt->bindParam(":bebco", $json->bebco_volunteer);
        $stmt->bindParam(":jaco", $json->jaco_volunteer);
        $stmt->bindParam(":jbc", $json->jbc_volunteer);
        $stmt->bindParam(":pass", $json->password);

        $stmt->execute();

        $db = null;

        echo json_encode($json);

    } catch(PDOException $e) {

        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


function deleteVolunteer($id) {
    try {
        $db = getConnection();

        $stmt = $db->prepare("DELETE FROM volunteer_profile WHERE volunteer_id =:id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $db = null;

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function findByEmail($email) {
    try {
        $db = getConnection();

        $stmt = $db->prepare("SELECT * FROM volunteer_profile WHERE email = :email");

        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $volunteer = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        echo '{"volunteer": ' . json_encode($volunteer) . '}';

    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
function getConnection() {

    $DB_host = "us-cdbr-iron-east-04.cleardb.net";
    $DB_user = "bd8aa6573fef84";
    $DB_pass = "87956034";
    $DB_name = "heroku_01b6c023d9d5d29";

    try {
        $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}", $DB_user, $DB_pass);
        $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $DB_con;
    }
    catch(PDOException $e) {
        echo $e->getMessage();
    }
}