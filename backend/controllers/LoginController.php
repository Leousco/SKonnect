<?php
require_once '../models/User.php';

class LoginController {

    private $roleRedirects = [
        'resident'   => '../portal/dashboard.php',
        'moderator'  => '../management/moderator/mod_dashboard.php',
        'sk_officer' => '../management/officer/officer_dashboard.php',
        'admin'      => '../management/admin/admin_dashboard.php',
    ];

    public function login() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
            exit;
        }

        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$email || !$password) {
            echo json_encode(['status' => 'error', 'message' => 'Email and password are required.']);
            exit;
        }

        $user        = new User();
        $user->email = $email;

        if (!$user->getUserByEmail() || $user->is_deleted) {
            echo json_encode(['status' => 'error', 'message' => 'Email not found.']);
            exit;
        }

        if ($user->is_banned) {
            echo json_encode([
                'status'  => 'banned',
                'message' => 'Your account has been restricted.',
                'reason'  => $user->banned_reason ?: 'No reason provided.',
            ]);
            exit;
        }

        if ($user->is_verified != 1) {
            $_SESSION['verify_email'] = $user->email;
            echo json_encode([
                'status'  => 'unverified',
                'message' => 'Your account is not verified. Redirecting to verification...',
            ]);
            exit;
        }

        if (!password_verify($password, $user->password)) {
            echo json_encode(['status' => 'error', 'message' => 'Incorrect password.']);
            exit;
        }

        $_SESSION['user_id']    = $user->id;
        $_SESSION['user_name']  = $user->first_name . ' ' . $user->last_name;
        $_SESSION['user_role']  = $user->role;
        $_SESSION['user_email'] = $user->email;

        $redirect = $this->roleRedirects[$user->role] ?? $this->roleRedirects['resident'];

        echo json_encode([
            'status'   => 'success',
            'message'  => 'Login successful.',
            'role'     => $user->role,
            'redirect' => $redirect,
        ]);
        exit;
    }
}