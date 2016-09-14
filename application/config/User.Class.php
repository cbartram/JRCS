<?php
class USER
{
    private $db;
 
    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
	
	function generateToken()
	{
    $token = password_hash(base64_encode(hash('sha256', openssl_random_pseudo_bytes(20), true)), PASSWORD_DEFAULT);
	return $token; 	
	}

    public function register_staff($first_name, $last_name, $address, $city, $state, $zip, $email, $password) {
       //todo this hasnt been tested
        try {
            $new_password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

            $id = "staff_" . substr($new_password, strlen($new_password) - 8, strlen($new_password));

            $stmt = $this->db->prepare("INSERT INTO staff_profile (staff_id, email, authentication_level, password, last_name, first_name, zip_code, state, city, street_address) 
            VALUES (:id, :email, :authentication, :pass, :lastName, :firstName, :zip, :state, :city, :addr)");

            $stmt->execute(array(":id" => $id, ":authentication" => 2, ":firstName" => $first_name, ":lastName" => $last_name, ":addr" => $address,
                ":city" => $city, ":state" => $state, ":zip" => $zip, ":email" => $email, ":pass" => $new_password));

            return $stmt;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
 
    public function register($first_name, $last_name, $address, $city, $state, $zip, $email, $phone, $volunteer_type, $consent, $password) {
       //todo this hasnt been tested
        try {
           $new_password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

           $id = "vol_" . substr($new_password, strlen($new_password) - 8, strlen($new_password));
   
           $stmt = $this->db->prepare("INSERT INTO volunteer_profile (volunteer_id, first_name, last_name, street_address,
                                      city, state, zip_code, email, phone_number, volunteer_type, background_consent, authentication_level, password)
                                VALUES (:id, :firstName, :lastName, :addr, :city, :state, :zip, :email, :phone, :volunteerType, :backgroundConsent, 0, :pass)");
           $stmt->execute(array(":id" => $id, ":firstName" => $first_name, ":lastName" => $last_name, ":addr" => $address,
                                ":city" => $city, ":state" => $state, ":zip" => $zip, ":email" => $email, ":phone" => $phone,
                                ":volunteerType" => $volunteer_type, ":backgroundConsent" => $consent, ":pass" => $new_password));
           return $stmt; 
       }
       catch(PDOException $e) {
           echo $e->getMessage();
       }    
    }


    public function login_JACO($email, $password) {
       try {
           //Staff can login with either their staff_id or their email and a volunteer can login with either their volunteer_id or their email
          $stmt = $this->db->prepare("SELECT * FROM JACO_login WHERE email = :email OR volunteer_id = :email LIMIT 1");

          $stmt->execute(array(':email' => $email));

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if($stmt->rowCount() > 0) {
             if(password_verify($password, $row['password'])) {
                $_SESSION['user_session'] = $row['volunteer_id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['user_group'] = 'JACO';

                return true;
             } else {
                return false;
             }
          }
       }
       catch(PDOException $e) {
           echo $e->getMessage();
       }
   }
    
    
    public function login_JBC($email, $password) {
        try {
            //Staff can login with either their staff_id or their email and a volunteer can login with either their volunteer_id or their email
            $stmt = $this->db->prepare("SELECT * FROM JBC_login WHERE email = :email OR volunteer_id = :email LIMIT 1");

            $stmt->execute(array(':email' => $email));

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($stmt->rowCount() > 0) {
                if(password_verify($password, $row['password'])) {
                    $_SESSION['user_session'] = $row['volunteer_id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['user_group'] = 'JBC';

                    return true;
                } else {
                    return false;
                }
            }
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function login_BEBCO($email, $password) {
        try {
            //Staff can login with either their staff_id or their email and a volunteer can login with either their volunteer_id or their email
            $stmt = $this->db->prepare("SELECT * FROM BEBCO_login WHERE email = :email OR volunteer_id = :email LIMIT 1");

            $stmt->execute(array(':email' => $email));

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($stmt->rowCount() > 0) {
                if(password_verify($password, $row['password'])) {
                    $_SESSION['user_session'] = $row['volunteer_id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['user_group'] = 'BEBCO';

                    return true;
                } else {
                    return false;
                }
            }
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

   public function is_staff($email) {
       $stmt = $this->db->prepare("SELECT email FROM staff_profile WHERE email = :email LIMIT 1");
       $stmt->execute(array(":email" => $email));
       if($stmt->rowCount() > 0) {
           return true;
       }
       return false;
   }
	
   public function is_loggedin() {
      if(isset($_SESSION['user_session']))
      {
         return true;
      }
   }
    
   public function redirect($url) {
       header("Location: $url");
   }
 
   public function logout() {
	   	   
        session_destroy();
        unset($_SESSION['user_session']);
	    unset($_SESSION['email']);
	  
        return true;
   }
}