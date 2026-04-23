<?php
/**
 * settings_action.php
 * Handles load/save for admin settings and password change.
 * Place at: /backend/routes/settings_action.php
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../middleware/RoleMiddleware.php';
require_once __DIR__ . '/../config/database.php';

RoleMiddleware::requireAdmin();

$db     = new Database();
$conn   = $db->getConnection();
$userId = $_SESSION['user_id'] ?? 0;
$action = $_GET['action'] ?? '';

/* ══════════════════════════════════════════════════════════
   GET actions
   ══════════════════════════════════════════════════════════ */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    /* ── Load admin profile ─────────────────────────── */
    if ($action === 'load') {
        try {
            $stmt = $conn->prepare("
                SELECT id, first_name, last_name, middle_name, email, role, created_at
                FROM users WHERE id = :id
            ");
            $stmt->execute([':id' => $userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'User not found.']);
                exit;
            }

            echo json_encode(['status' => 'success', 'data' => $user]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    /* ── Load all site/system settings ─────────────── */
    if ($action === 'load-settings') {
        try {
            $stmt = $conn->query("SELECT `key`, `value` FROM settings");
            $rows = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // ['sys_name' => 'SKonnect', ...]
            echo json_encode(['status' => 'success', 'data' => $rows]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }
}

/* ══════════════════════════════════════════════════════════
   POST actions (JSON body)
   ══════════════════════════════════════════════════════════ */
$input  = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $action ?: ($input['action'] ?? '');

/* Helper: upsert one key-value pair into settings */
function upsertSetting(PDO $conn, string $key, string $value): void
{
    $stmt = $conn->prepare("
        INSERT INTO settings (`key`, `value`)
        VALUES (:k, :v)
        ON DUPLICATE KEY UPDATE `value` = :v2
    ");
    $stmt->execute([':k' => $key, ':v' => $value, ':v2' => $value]);
}

try {
    switch ($action) {

        /* ── Save admin profile ─────────────────────────── */
        case 'save-profile':
            $firstName = trim($input['first_name'] ?? '');
            $lastName  = trim($input['last_name']  ?? '');
            $email     = trim($input['email']      ?? '');

            if (!$firstName || !$lastName || !$email) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'First name, last name, and email are required.']);
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Invalid email address.']);
                exit;
            }

            // Check email not taken by another user
            $check = $conn->prepare("SELECT id FROM users WHERE email = :email AND id != :id");
            $check->execute([':email' => $email, ':id' => $userId]);
            if ($check->fetch()) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Email is already in use by another account.']);
                exit;
            }

            $stmt = $conn->prepare("
                UPDATE users
                SET first_name = :fn, last_name = :ln, email = :email
                WHERE id = :id
            ");
            $stmt->execute([
                ':fn'    => $firstName,
                ':ln'    => $lastName,
                ':email' => $email,
                ':id'    => $userId,
            ]);

            // Update session name
            $_SESSION['user_name'] = $firstName . ' ' . $lastName;

            echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully.']);
            break;

        /* ── Change password ────────────────────────────── */
        case 'change-password':
            $current   = $input['current_password'] ?? '';
            $newPw     = $input['new_password']     ?? '';
            $confirmPw = $input['confirm_password'] ?? '';

            if (!$current || !$newPw || !$confirmPw) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'All password fields are required.']);
                exit;
            }

            if ($newPw !== $confirmPw) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'New passwords do not match.']);
                exit;
            }

            if (strlen($newPw) < 8) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters.']);
                exit;
            }

            // Verify current password
            $stmt = $conn->prepare("SELECT password FROM users WHERE id = :id");
            $stmt->execute([':id' => $userId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row || !password_verify($current, $row['password'])) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
                exit;
            }

            $hashed = password_hash($newPw, PASSWORD_DEFAULT);
            $conn->prepare("UPDATE users SET password = :pw WHERE id = :id")
                 ->execute([':pw' => $hashed, ':id' => $userId]);

            echo json_encode(['status' => 'success', 'message' => 'Password changed successfully.']);
            break;

        /* ── Save system information ────────────────────── */
        case 'save-system-info':
            $sysName    = trim($input['sys_name']    ?? '');
            $sysEmail   = trim($input['sys_email']   ?? '');
            $sysTagline = trim($input['sys_tagline'] ?? '');

            if (!$sysName) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'System name is required.']);
                exit;
            }

            if ($sysEmail && !filter_var($sysEmail, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Invalid system email address.']);
                exit;
            }

            upsertSetting($conn, 'sys_name',    $sysName);
            upsertSetting($conn, 'sys_email',   $sysEmail);
            upsertSetting($conn, 'sys_tagline', $sysTagline);

            echo json_encode(['status' => 'success', 'message' => 'System information saved successfully.']);
            break;

        /* ── Save branding (logo/favicon paths) ─────────── */
        case 'save-branding':
            $logoPath    = trim($input['logo_path']    ?? '');
            $faviconPath = trim($input['favicon_path'] ?? '');

            upsertSetting($conn, 'logo_path',    $logoPath);
            upsertSetting($conn, 'favicon_path', $faviconPath);

            echo json_encode(['status' => 'success', 'message' => 'Branding saved successfully.']);
            break;

        /* ── Save barangay information ──────────────────── */
        case 'save-barangay':
            $brgyName         = trim($input['brgy_name']         ?? '');
            $brgyMunicipality = trim($input['brgy_municipality']  ?? '');
            $brgyProvince     = trim($input['brgy_province']      ?? '');
            $brgyContact      = trim($input['brgy_contact']       ?? '');
            $brgyEmail        = trim($input['brgy_email']         ?? '');
            $brgyAddress      = trim($input['brgy_address']       ?? '');
            $brgyAbout        = trim($input['brgy_about']         ?? '');

            if (!$brgyName || !$brgyMunicipality) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Barangay name and municipality are required.']);
                exit;
            }

            if ($brgyEmail && !filter_var($brgyEmail, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Invalid barangay email address.']);
                exit;
            }

            upsertSetting($conn, 'brgy_name',         $brgyName);
            upsertSetting($conn, 'brgy_municipality',  $brgyMunicipality);
            upsertSetting($conn, 'brgy_province',      $brgyProvince);
            upsertSetting($conn, 'brgy_contact',       $brgyContact);
            upsertSetting($conn, 'brgy_email',         $brgyEmail);
            upsertSetting($conn, 'brgy_address',       $brgyAddress);
            upsertSetting($conn, 'brgy_about',         $brgyAbout);

            echo json_encode(['status' => 'success', 'message' => 'Barangay information saved successfully.']);
            break;

        default:
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Unknown action.']);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}