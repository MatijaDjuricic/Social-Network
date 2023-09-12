<?php
class User {
    public $profile_image = 'default.png';
    protected $conn;
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }
    public function create($username, $email, $password) {
        $hashed_password = hash_password($password);
        $sql = "INSERT INTO users (username, email, password, profile_image) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $this->profile_image);
        $result = $stmt->execute();
        if($result) {
            $_SESSION['user_id'] = $result->insert_id;
            return true; 
        }
        return false;
    }
    public function read() {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function update_username($username) {
        $sql = "UPDATE users SET username = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $username, $_SESSION['user_id']);
        $stmt->execute();
    }
    public function update_email($email) {
        $sql = "UPDATE users SET email = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $email, $_SESSION['user_id']);
        $stmt->execute();
    }
    public function update_password($password) {
        $hashed_password = hash_password($password);
        $sql = "UPDATE users SET password = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $_SESSION['user_id']);
        $stmt->execute();
    }
    public function update_image() {
        $sql = "UPDATE users SET profile_image = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $this->profile_image, $_SESSION['user_id']);
        $stmt->execute();
    }
    public function delete() {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();   
        unset($_SESSION['user_id']);
    }
    public function login($username, $email, $password) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $results = $stmt->get_result();
        if ($results->num_rows == 1) {
            $result = $results->fetch_assoc();
            if ($email == $result['email']) {
                if (password_verify($password, $result['password'])) {
                    $_SESSION['user_id'] = $result['user_id'];
                    return true;
                }
            }
        }
        return false;
    }
    public function sign_out() {
        unset($_SESSION['user_id']);
    }
}