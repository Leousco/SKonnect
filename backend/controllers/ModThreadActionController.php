<?php
// backend/controllers/ModThreadActionController.php
require_once __DIR__ . '/../middleware/RoleMiddleware.php';
RoleMiddleware::requireRole('moderator');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/ThreadModel.php';
require_once __DIR__ . '/../services/EmailService.php';

$db    = new Database();
$conn  = $db->getConnection();
$model = new ThreadModel($conn);

$thread_id = (int)($_POST['thread_id'] ?? 0);
$action    = trim($_POST['action'] ?? '');

if (!$thread_id) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid thread ID.']);
    exit;
}

// ── Helper: fetch author info once and send email non-blocking ────────────────
function notifyThreadAuthor(ThreadModel $model, int $thread_id, callable $send): void
{
    $author = $model->getThreadAuthor($thread_id);
    if ($author && !empty($author['email'])) {
        $emailService = new EmailService();
        $send($emailService, $author);
    }
}
// ─────────────────────────────────────────────────────────────────────────────

switch ($action) {

    case 'flag':
        $result = $model->setThreadFlag($thread_id, 1);
        echo json_encode([
            'status'  => $result ? 'success' : 'error',
            'flagged' => true,
            'message' => $result ? 'Thread flagged.' : 'Failed to flag thread.',
        ]);
        // No email — flagging is an internal moderator action, not surfaced to the author.
        break;

    case 'unflag':
        $result = $model->setThreadFlag($thread_id, 0);
        echo json_encode([
            'status'  => $result ? 'success' : 'error',
            'flagged' => false,
            'message' => $result ? 'Flag removed.' : 'Failed to remove flag.',
        ]);
        // No email — same reason as above.
        break;

    case 'remove':
        $result = $model->setThreadRemoved($thread_id, 1);
        echo json_encode([
            'status'  => $result ? 'success' : 'error',
            'message' => $result ? 'Thread hidden from residents.' : 'Failed to remove thread.',
        ]);
        if ($result) {
            notifyThreadAuthor($model, $thread_id, function (EmailService $svc, array $author): void {
                $svc->sendRemovalStatusNotification(
                    email: $author['email'],
                    name: $author['name'],
                    threadSubject: $author['subject'],
                    isRemoved: true
                );
            });
        }
        break;

    case 'restore':
        $result = $model->setThreadRemoved($thread_id, 0);
        echo json_encode([
            'status'  => $result ? 'success' : 'error',
            'message' => $result ? 'Thread restored.' : 'Failed to restore thread.',
        ]);
        if ($result) {
            notifyThreadAuthor($model, $thread_id, function (EmailService $svc, array $author): void {
                $svc->sendRemovalStatusNotification(
                    email: $author['email'],
                    name: $author['name'],
                    threadSubject: $author['subject'],
                    isRemoved: false
                );
            });
        }
        break;

    case 'pin':
        $result = $model->setThreadPinned($thread_id, 1);
        echo json_encode([
            'status'  => $result ? 'success' : 'error',
            'pinned'  => true,
            'message' => $result ? 'Thread pinned.' : 'Failed to pin thread.',
        ]);
        if ($result) {
            notifyThreadAuthor($model, $thread_id, function (EmailService $svc, array $author): void {
                $svc->sendPinStatusNotification(
                    email: $author['email'],
                    name: $author['name'],
                    threadSubject: $author['subject'],
                    isPinned: true
                );
            });
        }
        break;

    case 'unpin':
        $result = $model->setThreadPinned($thread_id, 0);
        echo json_encode([
            'status'  => $result ? 'success' : 'error',
            'pinned'  => false,
            'message' => $result ? 'Thread unpinned.' : 'Failed to unpin thread.',
        ]);
        if ($result) {
            notifyThreadAuthor($model, $thread_id, function (EmailService $svc, array $author): void {
                $svc->sendPinStatusNotification(
                    email: $author['email'],
                    name: $author['name'],
                    threadSubject: $author['subject'],
                    isPinned: false
                );
            });
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Unknown action.']);
        break;
}