<?php
// backend/controllers/PostCommentController.php
require_once __DIR__ . '/../middleware/RoleMiddleware.php';
RoleMiddleware::requireAuth();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/CommentModel.php';

$db    = new Database();
$conn  = $db->getConnection();
$model = new CommentModel($conn);

$user_id   = $_SESSION['user_id'] ?? null;
$thread_id = (int)($_POST['thread_id'] ?? 0);
$message   = trim($_POST['message'] ?? '');

if (!$user_id) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized.']);
    exit;
}
if (!$thread_id) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid thread.']);
    exit;
}
if (strlen($message) < 2) {
    echo json_encode(['status' => 'error', 'message' => 'Comment is too short.']);
    exit;
}
if (!$model->threadExists($thread_id)) {
    echo json_encode(['status' => 'error', 'message' => 'Thread not found.']);
    exit;
}

$comment = $model->createComment($thread_id, (int)$user_id, $message);

echo json_encode(['status' => 'success', 'comment' => $comment]);