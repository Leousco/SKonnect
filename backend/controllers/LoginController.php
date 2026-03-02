<?php
require_once '../models/User.php';

class LoginController {

    public function login() {
        // Start session safely
        if (session_status() === PHP_SESSION_NONE) session_start();

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid request method."
            ]);
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            echo json_encode([
                "status" => "error",
                "message" => "Email and password are required."
            ]);
            exit;
        }

        $user = new User();
        $user->email = $email;

        if (!$user->getUserByEmail()) {
            echo json_encode([
                "status" => "error",
                "message" => "Email not found."
            ]);
            exit;
        }

        // Check if account is verified
        if ($user->is_verified != 1) {
            $_SESSION['verify_email'] = $user->email; 
            echo json_encode([
                "status" => "unverified",
                "message" => "Your account is not verified. Redirecting to verification..."
            ]);
            exit;
        }

        // Verify password
        if (!password_verify($password, $user->password)) {
            echo json_encode([
                "status" => "error",
                "message" => "Incorrect password."
            ]);
            exit;
        }

        // Login successful → store user session
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->first_name . ' ' . $user->last_name;

        echo json_encode([
            "status" => "success",
            "message" => "Login successful.",
            "redirect" => "../portal/dashboard.php"
        ]);
        exit;
    }
}
?>