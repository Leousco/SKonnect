<?php
// backend/controllers/ModQueueController.php
require_once __DIR__ . '/../middleware/RoleMiddleware.php';
RoleMiddleware::requireRole('moderator');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/ThreadModel.php';
require_once __DIR__ . '/../models/ReportModel.php';
require_once __DIR__ . '/../services/EmailService.php';

$db          = new Database();
$conn        = $db->getConnection();
$threadModel = new ThreadModel($conn);
$reportModel = new ReportModel($conn);

$report_id = (int)($_POST['report_id'] ?? 0);
$action    = trim($_POST['action']    ?? '');

if (!$report_id) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid report ID.']);
    exit;
}

// Fetch the report row so we have thread_id and category
$reports = $reportModel->getThreadReports();
$report  = null;
foreach ($reports as $r) {
    if ((int)$r['report_id'] === $report_id) {
        $report = $r;
        break;
    }
}

if (!$report) {
    echo json_encode(['status' => 'error', 'message' => 'Report not found.']);
    exit;
}

$thread_id        = (int)$report['thread_id'];
$thread_author_id = (int)$report['thread_author_id'];
$category         = $report['category'];
$thread_subject   = $report['thread_subject'];

// ── Helper: send email to thread author ──────────────────────────────────────
function notifyAuthorEmail(ThreadModel $tm, int $thread_id, callable $send): void
{
    $author = $tm->getThreadAuthor($thread_id);
    if ($author && !empty($author['email'])) {
        $svc = new EmailService();
        $send($svc, $author);
    }
}
// ─────────────────────────────────────────────────────────────────────────────

switch ($action) {

        // ── DISMISS ───────────────────────────────────────────────────────────────
        // Mark the report as dismissed. Thread stays visible. No notification to author.
    case 'dismiss':
        $ok = $reportModel->updateThreadReportStatus($report_id, 'dismissed');
        echo json_encode([
            'status'        => $ok ? 'success' : 'error',
            'message'       => $ok ? 'Report dismissed.' : 'Failed to dismiss report.',
            'report_status' => 'dismissed',
        ]);
        break;

        // ── RESOLVE & NOTIFY ──────────────────────────────────────────────────────
        // Combines the old warn + hide into one atomic action:
        //   1. Hides the thread (is_removed = 1)
        //   2. Marks the report as reviewed
        //   3. Sends an email notification to the thread author
        //   [IN-APP NOTIFICATION] — placeholder until notification system is ready
    case 'resolve':
        $hideOk   = $threadModel->setThreadRemoved($thread_id, 1);
        $reportOk = $reportModel->updateThreadReportStatus($report_id, 'reviewed');

        if ($hideOk) {
            // [IN-APP NOTIFICATION PLACEHOLDER]
            // When the in-app notification system is ready, insert a notification here:
            // e.g. $reportModel->createNotification(
            //     user_id:  $thread_author_id,
            //     type:     'thread_hidden',
            //     title:    'Your thread has been hidden',
            //     message:  "Your thread \"{$thread_subject}\" was hidden by a moderator following a {$category_label} report.",
            //     ref_type: 'thread',
            //     ref_id:   $thread_id
            // );

            // Email notification
            notifyAuthorEmail($threadModel, $thread_id, function (EmailService $svc, array $author): void {
                $svc->sendRemovalStatusNotification(
                    email: $author['email'],
                    name: $author['name'],
                    threadSubject: $author['subject'],
                    isRemoved: true
                );
            });
        }

        echo json_encode([
            'status'        => ($hideOk && $reportOk) ? 'success' : 'error',
            'message'       => $hideOk
                ? 'Report resolved. Thread hidden and author notified.'
                : 'Failed to hide thread.',
            'report_status' => 'reviewed',
            'thread_hidden' => $hideOk,
        ]);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Unknown action.']);
        break;
}