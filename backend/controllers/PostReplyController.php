<?php
// backend/controllers/PostReplyController.php
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

$user_id    = $_SESSION['user_id'] ?? null;
$comment_id = (int)($_POST['comment_id'] ?? 0);
$message    = trim($_POST['message'] ?? '');

if (!$user_id) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized.']);
    exit;
}
if (!$comment_id) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid comment.']);
    exit;
}
if (strlen($message) < 2) {
    echo json_encode(['status' => 'error', 'message' => 'Reply is too short.']);
    exit;
}

$reply = $model->createReply($comment_id, (int)$user_id, $message);

if (!$reply) {
    echo json_encode(['status' => 'error', 'message' => 'Comment not found or has been removed.']);
    exit;
}

echo json_encode(['status' => 'success', 'reply' => $reply]);