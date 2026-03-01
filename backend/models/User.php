<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $first_name;
    public $last_name;
    public $middle_name;
    public $gender;
    public $birth_date;
    public $age;
    public $email;
    public $password;
    public $is_verified;
    public $otp_code;
    public $otp_expires;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Create new user (unverified)
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    first_name = :first_name,
                    last_name = :last_name,
                    middle_name = :middle_name,
                    gender = :gender,
                    birth_date = :birth_date,
                    age = :age,
                    email = :email,
                    password = :password,
                    otp_code = :otp_code,
                    otp_expires = :otp_expires,
                    is_verified = 0";

        $stmt = $this->conn->prepare($query);

        // Hash the password
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        // Bind parameters
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":middle_name", $this->middle_name);
        $stmt->bindParam(":gender", $this->gender);
        $stmt->bindParam(":birth_date", $this->birth_date);
        $stmt->bindParam(":age", $this->age);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":otp_code", $this->otp_code);
        $stmt->bindParam(":otp_expires", $this->otp_expires);

        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // Verify user (set is_verified = 1)
    public function verifyUser() {
        $query = "UPDATE " . $this->table_name . "
                SET is_verified = 1, 
                    verified_at = NOW(),
                    otp_code = NULL,
                    otp_expires = NULL
                WHERE email = :email AND otp_code = :otp_code AND otp_expires > NOW()";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":otp_code", $this->otp_code);
        
        if($stmt->execute()) {
            return $stmt->rowCount() > 0;
        }
        return false;
    }

    // Get user by email
    public function getUserByEmail() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->id = $row['id'];
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->middle_name = $row['middle_name'];
            $this->gender = $row['gender'];
            $this->birth_date = $row['birth_date'];
            $this->age = $row['age'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->is_verified = $row['is_verified'];
            $this->otp_code = $row['otp_code'];
            $this->otp_expires = $row['otp_expires'];
            return true;
        }
        return false;
    }

    // Check if email exists
    public function emailExists() {
        $query = "SELECT id, is_verified FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return [
                'exists' => true,
                'is_verified' => $row['is_verified']
            ];
        }
        return ['exists' => false];
    }

    // Update OTP for existing user
    public function updateOTP() {
        $query = "UPDATE " . $this->table_name . "
                SET otp_code = :otp_code,
                    otp_expires = :otp_expires
                WHERE email = :email AND is_verified = 0";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":otp_code", $this->otp_code);
        $stmt->bindParam(":otp_expires", $this->otp_expires);
        $stmt->bindParam(":email", $this->email);

        return $stmt->execute();
    }

    // Delete unverified user (optional - for cleanup)
    public function deleteUnverified() {
        $query = "DELETE FROM " . $this->table_name . " 
                  WHERE email = :email AND is_verified = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        return $stmt->execute();
    }
}
?>