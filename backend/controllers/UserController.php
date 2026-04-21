<?php
require_once __DIR__ . '/../middleware/RoleMiddleware.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/EmailService.php';
require_once __DIR__ . '/ActivityLogController.php';   // ← activity log helper

RoleMiddleware::requireAdmin();
header('Content-Type: application/json');

$raw    = file_get_contents('php://input');
$data   = json_decode($raw, true) ?? [];
$action = $data['action'] ?? ($_GET['action'] ?? '');

$emailService = new EmailService();

/* Acting admin's session ID — used for log attribution */
session_start_if_needed();
$actorId = $_SESSION['user_id'] ?? null;

try {
    $db   = new Database();
    $conn = $db->getConnection();

    switch ($action) {

        /* ── GET USERS ─────────────────────────────────────────────────────
         * Returns { status, data: { users: [...], counts: { admin, moderator,
         *   sk_officer, resident } } }
         * ────────────────────────────────────────────────────────────────── */
        case 'get_users':
            $stmt = $conn->prepare("
                SELECT u.id, u.first_name, u.last_name, u.middle_name, u.gender,
                       u.birth_date, u.age, u.email, u.role, u.is_verified, u.created_at,
                       us.is_active, us.is_banned, us.banned_reason
                FROM users u
                JOIN user_status us ON us.user_id = u.id
                WHERE us.is_deleted = 0
                ORDER BY u.created_at DESC
            ");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $counts = ['admin' => 0, 'moderator' => 0, 'sk_officer' => 0, 'resident' => 0];
            foreach ($users as $u) {
                $role = $u['role'] ?? '';
                if (array_key_exists($role, $counts)) $counts[$role]++;
            }

            echo json_encode([
                'status' => 'success',
                'data'   => ['users' => $users, 'counts' => $counts],
            ]);
            break;

        /* ── ADD USER ──────────────────────────────────────────────────────*/
        case 'add_user':
            $required = ['first_name', 'last_name', 'email', 'password', 'role', 'gender', 'birth_date'];
            foreach ($required as $field) {
                if (empty($data[$field])) respond(400, "Field '$field' is required.");
            }
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) respond(400, 'Invalid email format.');

            $allowed_roles = ['admin', 'moderator', 'sk_officer', 'resident'];
            if (!in_array($data['role'], $allowed_roles)) respond(400, 'Invalid role.');

            $check = $conn->prepare("
                SELECT u.id FROM users u
                JOIN user_status us ON us.user_id = u.id
                WHERE u.email = ? AND us.is_deleted = 0
            ");
            $check->execute([strtolower(trim($data['email']))]);
            if ($check->fetch()) respond(409, 'Email is already in use.');

            $birth  = new DateTime($data['birth_date']);
            $age    = (new DateTime())->diff($birth)->y;
            $hashed = password_hash($data['password'], PASSWORD_BCRYPT);

            $stmt = $conn->prepare("
                INSERT INTO users
                    (first_name, last_name, middle_name, gender, birth_date, age,
                     email, password, role, is_verified, created_at, verified_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, NOW(), NOW())
            ");
            $stmt->execute([
                trim($data['first_name']),
                trim($data['last_name']),
                trim($data['middle_name'] ?? ''),
                $data['gender'],
                $data['birth_date'],
                $age,
                strtolower(trim($data['email'])),
                $hashed,
                $data['role'],
            ]);

            $newId      = $conn->lastInsertId();
            $fullName   = trim($data['first_name']) . ' ' . trim($data['last_name']);
            $roleLabels = ['admin' => 'System Admin', 'moderator' => 'Moderator', 'sk_officer' => 'SK Officer', 'resident' => 'Resident'];

            // ── Log ──
            ActivityLogController::log(
                $conn, $actorId, 'created',
                "Created new user account for <strong>{$fullName}</strong> with role <strong>" . ($roleLabels[$data['role']] ?? $data['role']) . "</strong>"
            );

            $emailService->sendAdminActionNotification(
                email:      strtolower(trim($data['email'])),
                name:       $fullName,
                subject:    'Your SKonnect Account Has Been Created',
                badge:      '✅ Account Created',
                badgeColor: '#4ade80',
                title:      "Welcome to SKonnect, {$data['first_name']}!",
                bodyHtml:   "<p>An administrator has created an account for you on the SKonnect portal.</p>
                             <p><strong>Email:</strong> " . htmlspecialchars(strtolower(trim($data['email']))) . "<br>
                                <strong>Role:</strong> " . ($roleLabels[$data['role']] ?? $data['role']) . "</p>
                             <p>Use the password provided to you by the admin to log in.</p>",
                bodyPlain:  "An admin created your SKonnect account.\nEmail: {$data['email']}\nRole: {$data['role']}"
            );

            echo json_encode(['status' => 'success', 'message' => 'User created successfully.', 'id' => $newId]);
            break;

        /* ── UPDATE USER ───────────────────────────────────────────────────*/
        case 'update_user':
            if (empty($data['id'])) respond(400, 'User ID is required.');

            $fetch = $conn->prepare("
                SELECT u.*, us.is_deleted FROM users u
                JOIN user_status us ON us.user_id = u.id
                WHERE u.id = ? AND us.is_deleted = 0
            ");
            $fetch->execute([$data['id']]);
            $user = $fetch->fetch(PDO::FETCH_ASSOC);
            if (!$user) respond(404, 'User not found.');

            $email = strtolower(trim($data['email'] ?? $user['email']));

            if ($email !== $user['email']) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) respond(400, 'Invalid email format.');
                $dup = $conn->prepare("
                    SELECT u.id FROM users u
                    JOIN user_status us ON us.user_id = u.id
                    WHERE u.email = ? AND u.id != ? AND us.is_deleted = 0
                ");
                $dup->execute([$email, $data['id']]);
                if ($dup->fetch()) respond(409, 'Email already in use by another account.');
            }

            $allowed_genders = ['male', 'female', 'other'];
            $gender          = in_array($data['gender'] ?? '', $allowed_genders) ? $data['gender'] : $user['gender'];
            $birth_date      = $data['birth_date'] ?? $user['birth_date'];
            $age             = (new DateTime())->diff(new DateTime($birth_date))->y;
            $newFirst        = trim($data['first_name']  ?? $user['first_name']);
            $newLast         = trim($data['last_name']   ?? $user['last_name']);
            $newMiddle       = trim($data['middle_name'] ?? $user['middle_name']);

            $stmt = $conn->prepare("
                UPDATE users
                SET first_name = ?, last_name = ?, middle_name = ?,
                    email = ?, gender = ?, birth_date = ?, age = ?
                WHERE id = ?
            ");
            $stmt->execute([$newFirst, $newLast, $newMiddle, $email, $gender, $birth_date, $age, $data['id']]);

            $changes = [];
            if ($newFirst   !== $user['first_name'])  $changes[] = "First name → <strong>{$newFirst}</strong>";
            if ($newLast    !== $user['last_name'])   $changes[] = "Last name → <strong>{$newLast}</strong>";
            if ($newMiddle  !== $user['middle_name']) $changes[] = "Middle name → <strong>{$newMiddle}</strong>";
            if ($email      !== $user['email'])       $changes[] = "Email → <strong>" . htmlspecialchars($email) . "</strong>";
            if ($gender     !== $user['gender'])      $changes[] = "Gender → <strong>" . ucfirst($gender) . "</strong>";
            if ($birth_date !== $user['birth_date'])  $changes[] = "Birth date → <strong>{$birth_date}</strong>";

            $fullName    = $newFirst . ' ' . $newLast;
            $changesList = $changes
                ? '<ul style="margin:8px 0 0;padding-left:18px;">'
                    . implode('', array_map(fn($c) => "<li style='margin-bottom:4px;'>{$c}</li>", $changes))
                    . '</ul>'
                : '<p>Minor profile details were updated.</p>';

            // ── Log ──
            $changesSummary = $changes
                ? implode(', ', array_map('strip_tags', $changes))
                : 'minor details';
            ActivityLogController::log(
                $conn, $actorId, 'updated',
                "Updated profile of <strong>{$fullName}</strong>: {$changesSummary}"
            );

            $emailService->sendAdminActionNotification(
                email:      $email,
                name:       $fullName,
                subject:    'Your SKonnect Profile Has Been Updated',
                badge:      '✏️ Profile Updated',
                badgeColor: '#60a5fa',
                title:      'An admin has updated your profile information',
                bodyHtml:   "<p>The following changes were made to your account:</p>{$changesList}
                             <p style='margin-top:12px;color:rgba(255,255,255,0.6);font-size:12px;'>
                                 If you did not expect these changes, please contact the barangay office.
                             </p>",
                bodyPlain:  "An admin updated your profile. Changes: " . implode(', ', array_map('strip_tags', $changes))
            );

            echo json_encode(['status' => 'success', 'message' => 'User info updated successfully.']);
            break;

        /* ── UPDATE ROLE ───────────────────────────────────────────────────*/
        case 'update_role':
            if (empty($data['id']) || empty($data['role'])) respond(400, 'User ID and role are required.');

            $allowed_roles = ['admin', 'moderator', 'sk_officer', 'resident'];
            if (!in_array($data['role'], $allowed_roles)) respond(400, 'Invalid role.');

            $fetch = $conn->prepare("
                SELECT u.first_name, u.last_name, u.email, u.role FROM users u
                JOIN user_status us ON us.user_id = u.id
                WHERE u.id = ? AND us.is_deleted = 0
            ");
            $fetch->execute([$data['id']]);
            $user = $fetch->fetch(PDO::FETCH_ASSOC);
            if (!$user) respond(404, 'User not found.');

            $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->execute([$data['role'], $data['id']]);

            $roleLabels   = ['admin' => '🛡️ System Admin', 'moderator' => '🔧 Moderator', 'sk_officer' => '⭐ SK Officer', 'resident' => '👤 Resident'];
            $oldRoleLabel = $roleLabels[$user['role']] ?? $user['role'];
            $newRoleLabel = $roleLabels[$data['role']] ?? $data['role'];
            $fullName     = $user['first_name'] . ' ' . $user['last_name'];

            // ── Log ──
            ActivityLogController::log(
                $conn, $actorId, 'updated',
                "Changed role of <strong>{$fullName}</strong>: {$oldRoleLabel} → <strong>{$newRoleLabel}</strong>"
            );

            $emailService->sendAdminActionNotification(
                email:      $user['email'],
                name:       $fullName,
                subject:    'Your SKonnect Role Has Been Updated',
                badge:      '🔄 Role Changed',
                badgeColor: '#a78bfa',
                title:      'Your account role has been changed',
                bodyHtml:   "<p>An administrator has updated your role on the SKonnect portal:</p>
                             <p style='margin:14px 0;font-size:15px;'>
                                 <span style='color:rgba(255,255,255,0.5);'>{$oldRoleLabel}</span>
                                 &nbsp;→&nbsp;
                                 <strong style='color:#facc15;'>{$newRoleLabel}</strong>
                             </p>
                             <p>Your new role may come with different permissions. Log in to see your updated access.</p>",
                bodyPlain:  "Your SKonnect role has been changed from {$user['role']} to {$data['role']}."
            );

            echo json_encode(['status' => 'success', 'message' => 'Role updated successfully.']);
            break;

        /* ── TOGGLE USER ───────────────────────────────────────────────────*/
        case 'toggle_user':
            if (empty($data['id'])) respond(400, 'User ID is required.');

            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $data['id']) {
                respond(403, 'You cannot deactivate your own account.');
            }

            $fetch = $conn->prepare("
                SELECT u.first_name, u.last_name, u.email, us.is_active FROM users u
                JOIN user_status us ON us.user_id = u.id
                WHERE u.id = ? AND us.is_deleted = 0
            ");
            $fetch->execute([$data['id']]);
            $user = $fetch->fetch(PDO::FETCH_ASSOC);
            if (!$user) respond(404, 'User not found.');

            $newActive = $user['is_active'] ? 0 : 1;
            $stmt = $conn->prepare("UPDATE user_status SET is_active = ? WHERE user_id = ?");
            $stmt->execute([$newActive, $data['id']]);

            $fullName = $user['first_name'] . ' ' . $user['last_name'];

            // ── Log ──
            ActivityLogController::log(
                $conn, $actorId, 'updated',
                "Account <strong>" . ($newActive ? 'reactivated' : 'deactivated') . "</strong> for <strong>{$fullName}</strong>"
            );

            if ($newActive) {
                $emailService->sendAdminActionNotification(
                    email:      $user['email'],
                    name:       $fullName,
                    subject:    'Your SKonnect Account Has Been Reactivated',
                    badge:      '✅ Account Reactivated',
                    badgeColor: '#4ade80',
                    title:      'Your account is now active again',
                    bodyHtml:   "<p>Your SKonnect account has been reactivated by an administrator.</p>
                                 <p>You can now log in and access all your account features.</p>",
                    bodyPlain:  "Your SKonnect account has been reactivated."
                );
            } else {
                $emailService->sendAdminActionNotification(
                    email:      $user['email'],
                    name:       $fullName,
                    subject:    'Your SKonnect Account Has Been Deactivated',
                    badge:      '🚫 Account Deactivated',
                    badgeColor: '#fbbf24',
                    title:      'Your account has been temporarily deactivated',
                    bodyHtml:   "<p>Your SKonnect account has been temporarily deactivated by an administrator.</p>
                                 <p>You will not be able to log in while your account is deactivated.</p>
                                 <p style='color:rgba(255,255,255,0.6);font-size:12px;'>
                                     If you believe this is a mistake, please contact the barangay office.
                                 </p>",
                    bodyPlain:  "Your SKonnect account has been temporarily deactivated."
                );
            }

            echo json_encode([
                'status'    => 'success',
                'message'   => "Account " . ($newActive ? 'activated' : 'deactivated') . " for {$fullName}.",
                'is_active' => $newActive,
            ]);
            break;

        /* ── BAN USER ──────────────────────────────────────────────────────*/
        case 'ban_user':
            if (empty($data['id'])) respond(400, 'User ID is required.');

            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $data['id']) {
                respond(403, 'You cannot ban your own account.');
            }

            $fetch = $conn->prepare("
                SELECT u.first_name, u.last_name, u.email, us.is_banned FROM users u
                JOIN user_status us ON us.user_id = u.id
                WHERE u.id = ? AND us.is_deleted = 0
            ");
            $fetch->execute([$data['id']]);
            $user = $fetch->fetch(PDO::FETCH_ASSOC);
            if (!$user) respond(404, 'User not found.');

            $newBanned = $user['is_banned'] ? 0 : 1;
            $reason    = $newBanned ? (trim($data['reason'] ?? '') ?: 'Banned by admin') : null;

            $stmt = $conn->prepare("UPDATE user_status SET is_banned = ?, banned_reason = ? WHERE user_id = ?");
            $stmt->execute([$newBanned, $reason, $data['id']]);

            $fullName = $user['first_name'] . ' ' . $user['last_name'];

            // ── Log ──
            if ($newBanned) {
                ActivityLogController::log(
                    $conn, $actorId, 'declined',
                    "Banned user <strong>{$fullName}</strong>. Reason: " . htmlspecialchars($reason ?? '')
                );
            } else {
                ActivityLogController::log(
                    $conn, $actorId, 'updated',
                    "Lifted ban for user <strong>{$fullName}</strong>"
                );
            }

            if ($newBanned) {
                $safeReason = htmlspecialchars($reason);
                $emailService->sendAdminActionNotification(
                    email:      $user['email'],
                    name:       $fullName,
                    subject:    'Your SKonnect Account Has Been Restricted',
                    badge:      '⛔ Account Banned',
                    badgeColor: '#f87171',
                    title:      'Your account has been restricted',
                    bodyHtml:   "<p>Your SKonnect account has been restricted by an administrator.</p>
                                 <p><strong>Reason:</strong> {$safeReason}</p>
                                 <p>While banned, you may not be able to access certain features of the portal.</p>
                                 <p style='color:rgba(255,255,255,0.6);font-size:12px;'>
                                     If you believe this is a mistake, please contact the barangay office.
                                 </p>",
                    bodyPlain:  "Your SKonnect account has been restricted.\nReason: {$reason}"
                );
            } else {
                $emailService->sendAdminActionNotification(
                    email:      $user['email'],
                    name:       $fullName,
                    subject:    'Your SKonnect Account Restriction Has Been Lifted',
                    badge:      '🔓 Account Unbanned',
                    badgeColor: '#4ade80',
                    title:      'Your account restriction has been removed',
                    bodyHtml:   "<p>Your SKonnect account restriction has been lifted by an administrator.</p>
                                 <p>You now have full access to the portal again.</p>",
                    bodyPlain:  "Your SKonnect account restriction has been lifted."
                );
            }

            echo json_encode([
                'status'    => 'success',
                'message'   => "{$fullName} has been " . ($newBanned ? 'banned' : 'unbanned') . ".",
                'is_banned' => $newBanned,
            ]);
            break;

        /* ── DELETE USER ───────────────────────────────────────────────────*/
        case 'delete_user':
            if (empty($data['id'])) respond(400, 'User ID is required.');

            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $data['id']) {
                respond(403, 'You cannot delete your own account.');
            }

            $fetch = $conn->prepare("
                SELECT u.first_name, u.last_name, u.email FROM users u
                JOIN user_status us ON us.user_id = u.id
                WHERE u.id = ? AND us.is_deleted = 0
            ");
            $fetch->execute([$data['id']]);
            $user = $fetch->fetch(PDO::FETCH_ASSOC);
            if (!$user) respond(404, 'User not found or already deleted.');

            $fullName = $user['first_name'] . ' ' . $user['last_name'];

            // ── Log BEFORE soft-delete (FK still resolves to user row) ──
            ActivityLogController::log(
                $conn, $actorId, 'deleted',
                "Permanently deleted account: <strong>{$fullName}</strong> ({$user['email']})"
            );

            $emailService->sendAdminActionNotification(
                email:      $user['email'],
                name:       $fullName,
                subject:    'Your SKonnect Account Has Been Removed',
                badge:      '🗑️ Account Deleted',
                badgeColor: '#f87171',
                title:      'Your SKonnect account has been permanently removed',
                bodyHtml:   "<p>Your SKonnect account has been permanently deleted by an administrator.</p>
                             <p>All your account data has been removed from the system.</p>
                             <p style='color:rgba(255,255,255,0.6);font-size:12px;'>
                                 If you believe this was done in error, please contact the barangay office.
                             </p>",
                bodyPlain:  "Your SKonnect account has been permanently deleted."
            );

            $conn->prepare("
                UPDATE user_status
                SET is_deleted = 1, is_active = 0, deleted_at = NOW()
                WHERE user_id = ?
            ")->execute([$data['id']]);

            $conn->prepare("
                UPDATE users
                SET email = CONCAT('deleted_', id, '_', email),
                    otp_code = NULL, otp_expires = NULL
                WHERE id = ?
            ")->execute([$data['id']]);

            echo json_encode(['status' => 'success', 'message' => "User \"{$fullName}\" has been permanently deleted."]);
            break;

        default:
            respond(400, "Unknown action: '$action'");
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

/* ── Helpers ─────────────────────────────────────────────────────────────── */
function respond(int $code, string $message): void {
    http_response_code($code);
    echo json_encode(['status' => 'error', 'message' => $message]);
    exit;
}

function session_start_if_needed(): void {
    if (session_status() === PHP_SESSION_NONE) session_start();
}