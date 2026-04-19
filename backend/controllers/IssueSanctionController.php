<?php
// backend/controllers/IssueSanctionController.php
require_once __DIR__ . '/../middleware/RoleMiddleware.php';
RoleMiddleware::requireRole('moderator');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/SanctionModel.php';
require_once __DIR__ . '/../models/CommentReportModel.php';
require_once __DIR__ . '/../models/CommentModel.php';
require_once __DIR__ . '/../services/EmailService.php';

$db            = new Database();
$conn          = $db->getConnection();
$sanctionModel = new SanctionModel($conn);
$reportModel   = new CommentReportModel($conn);
$commentModel  = new CommentModel($conn);

$mod_id    = (int)($_SESSION['user_id'] ?? 0);
$user_id   = (int)($_POST['user_id']   ?? 0);
$level     = (int)($_POST['level']     ?? 0);
$reason    = trim($_POST['reason']     ?? '');   // now optional — empty string is fine
$report_id = isset($_POST['report_id']) ? (int)$_POST['report_id'] : null;

// ── Basic validation ─────────────────────────────────────────
if (!$user_id || !$level) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields (user_id, level).']);
    exit;
}

if ($level < 1 || $level > 3) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid sanction level.']);
    exit;
}

// ── Fetch user info for email ────────────────────────────────
$userStmt = $conn->prepare(
    "SELECT id, CONCAT(first_name, ' ', last_name) AS name, email FROM users WHERE id = :id LIMIT 1"
);
$userStmt->execute([':id' => $user_id]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(['status' => 'error', 'message' => 'User not found.']);
    exit;
}

// ── Fetch the reported comment/reply text to show in the email ──
// This is the PRIMARY content the user needs to see: what they actually wrote.
$reportedContent = null;
$threadSubject   = null;

if ($report_id) {
    $reportRow = $reportModel->getById($report_id);
    if ($reportRow) {
        $targetType = $reportRow['target_type'];
        $targetId   = (int)$reportRow['target_id'];

        if ($targetType === 'comment') {
            $q = $conn->prepare("SELECT tc.message, t.subject FROM thread_comments tc JOIN threads t ON t.id = tc.thread_id WHERE tc.id = :id LIMIT 1");
        } else {
            // reply
            $q = $conn->prepare(
                "SELECT cr.message, t.subject
                 FROM comment_replies cr
                 JOIN thread_comments tc ON tc.id = cr.comment_id
                 JOIN threads t          ON t.id  = tc.thread_id
                 WHERE cr.id = :id LIMIT 1"
            );
        }
        $q->execute([':id' => $targetId]);
        $row = $q->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            $reportedContent = $row['message'];
            $threadSubject   = $row['subject'];
        }
    }
}

// ── Issue sanction ───────────────────────────────────────────
$sanction_id = $sanctionModel->issue(
    user_id: $user_id,
    issued_by: $mod_id,
    level: $level,
    reason: $reason ?: '(No additional reason provided)',
    report_id: $report_id
);

// ── Auto-remove the reported comment/reply on level 2 or 3 ──
// The content is marked removed_by_mod = 1 so a visible tombstone
// ("This comment was removed by a Moderator") is shown in its place.
$content_removed = false;
if ($level >= 2 && $report_id) {
    $reportRow = $reportModel->getById($report_id);
    if ($reportRow) {
        $targetType = $reportRow['target_type'];
        $targetId   = (int)$reportRow['target_id'];

        if ($targetType === 'comment') {
            $content_removed = $commentModel->removeCommentByMod($targetId);
        } elseif ($targetType === 'reply') {
            $content_removed = $commentModel->removeReplyByMod($targetId);
        }
    }
}

// ── Mark report as reviewed ───────────────────────────────────
if ($report_id) {
    $reportModel->updateStatus($report_id, 'reviewed');
}

// ── Send email notification ───────────────────────────────────
$emailSvc  = new EmailService();
$emailSent = $emailSvc->sendSanctionNotification(
    email: $user['email'],
    name: $user['name'],
    level: $level,
    reason: $reason,                          // optional moderator note
    reportedContent: $reportedContent,                 // the actual comment/reply text
    threadSubject: $threadSubject                    // thread title for context
);

// ── Respond ──────────────────────────────────────────────────
$levelLabels = [1 => 'Warning', 2 => '7-Day Ban', 3 => 'Permanent Ban'];
echo json_encode([
    'status'          => 'success',
    'message'         => "Sanction issued: Level {$level} ({$levelLabels[$level]}) to {$user['name']}.",
    'sanction_id'     => $sanction_id,
    'new_level'       => $level,
    'email_sent'      => $emailSent,
    'content_removed' => $content_removed,
]);