<?php
// backend/controllers/ModFlagThreadController.php
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

$db          = new Database();
$conn        = $db->getConnection();
$threadModel = new ThreadModel($conn);
$reportModel = new ReportModel($conn);

$thread_id = (int)($_POST['thread_id'] ?? 0);
$category  = trim($_POST['category']  ?? '');
$mod_id    = (int)($_SESSION['user_id'] ?? 0);

$allowed_categories = ['inappropriate', 'spam', 'misinformation', 'harassment'];

if (!$thread_id) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid thread ID.']);
    exit;
}

if (!in_array($category, $allowed_categories, true)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid category.']);
    exit;
}

if (!$mod_id) {
    echo json_encode(['status' => 'error', 'message' => 'Session expired. Please log in again.']);
    exit;
}

// 1. Set is_flagged = 1 on the thread
$flagged = $threadModel->setThreadFlag($thread_id, 1);

if (!$flagged) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to flag thread.']);
    exit;
}

// 2. Insert a thread_report row so it appears in mod_queue
//    Only create the report if this mod hasn't already reported this thread
if (!$reportModel->hasReportedThread($thread_id, $mod_id)) {
    $reportModel->createThreadReport(
        thread_id:   $thread_id,
        reporter_id: $mod_id,
        category:    $category,
        note:        null   // mods don't need to provide a note
    );
}

echo json_encode([
    'status'  => 'success',
    'message' => 'Thread flagged.',
    'flagged' => true,
]);