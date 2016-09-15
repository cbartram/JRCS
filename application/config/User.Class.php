<?php
class USER
{
    private $db;
 
    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }

    /**
     * Creates a random token which can be used for password resets
     * @return bool|string
     */
	function generateToken()
	{
    $token = password_hash(base64_encode(hash('sha256', openssl_random_pseudo_bytes(20), true)), PASSWORD_DEFAULT);
	return $token; 	
	}

    /**
     * Creates a new staff memeber in the staff table
     * @param $first_name
     * @param $last_name
     * @param $address
     * @param $city
     * @param $state
     * @param $zip
     * @param $email
     * @param $password
     * @return mixed
     */
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

    /**
     * Returns the users first name and last name separated by a space character
     * @param $email the users email
     * @return string The users first and last name concatenated by a space
     */
    public function get_name($email) {
        if($this->is_staff($email)) {
            //Select from the staff profile table
            $stmt = $this->db->prepare("SELECT first_name, last_name FROM staff_profile WHERE email = :email");
            $stmt->execute(array(':email' => $email));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['first_name'] . ' ' . $row['last_name'];

        } else {
            //select from the volunteer profile table
            $stmt = $this->db->prepare("SELECT first_name, last_name FROM volunteer_profile WHERE email = :email");
            $stmt->execute(array(':email' => $email));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return ucwords($row['first_name']) . ' ' . ucwords($row['last_name']);
        }
    }

    /**
     * Creates a new volunteer entry in the volunteer_profile table
     * @param $first_name
     * @param $last_name
     * @param $address
     * @param $city
     * @param $state
     * @param $zip
     * @param $email
     * @param $phone
     * @param $volunteer_type
     * @param $consent
     * @param $password
     * @return mixed
     */
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


    /**
     * Logs a user into the Jaco group of volunteers
     * @param $email users email
     * @param $password users password
     * @return bool
     */
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

    /**
     * Logs a user into the JBC group of volunteers
     * @param $email users email
     * @param $password users password
     * @return bool
     */
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

    /**
     * Logs a user into the BEBCO group of volunteers
     * @param $email users email
     * @param $password users password
     * @return bool
     */
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

    /**
     * Returns true if the volunteer is also a staff member false otherwise
     * @param $email users email
     * @return bool
     */
   public function is_staff($email) {
       $stmt = $this->db->prepare("SELECT email FROM staff_profile WHERE email = :email LIMIT 1");
       $stmt->execute(array(":email" => $email));
       if($stmt->rowCount() > 0) {
           return true;
       }
       return false;
   }

    /**
     * Returns true if the user is currently logged into ANY user group
     * @return bool
     */
   public function is_loggedin() {
      if(isset($_SESSION['user_session']))
      {
         return true;
      }
   }

    /**
     * Redirects a user to a new url or relative path
     * @param $url
     */
   public function redirect($url) {
       header("Location: $url");
   }

    /**
     * logs a user out of their volunteer profile
     * @return bool
     */
   public function logout() {
	   	   
        session_destroy();
        unset($_SESSION['user_session']);
	    unset($_SESSION['email']);
        unset($_SESSION['user_group']);
	  
        return true;
   }
}