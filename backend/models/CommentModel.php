<?php
// backend/models/CommentModel.php

class CommentModel
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Fetch all visible comments for a thread, with support counts and user state.
     * Each comment row will have a 'replies' key populated separately via getReplies().
     */
    public function getCommentsByThread(int $thread_id, int $user_id): array
    {
        $stmt = $this->conn->prepare(
            "SELECT
                tc.id,
                tc.message,
                tc.created_at,
                CONCAT(u.first_name, ' ', u.last_name) AS author_name,
                tc.author_id,
                (SELECT COUNT(*) FROM comment_supports cs  WHERE cs.comment_id  = tc.id)                        AS support_count,
                (SELECT COUNT(*) FROM comment_supports cs2 WHERE cs2.comment_id = tc.id AND cs2.user_id = :uid) AS user_supported
             FROM thread_comments tc
             JOIN users u ON u.id = tc.author_id
             WHERE tc.thread_id = :tid AND tc.is_removed = 0
             ORDER BY tc.created_at ASC"
        );
        $stmt->execute([':uid' => $user_id, ':tid' => $thread_id]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Attach replies to each comment
        foreach ($comments as &$comment) {
            $comment['replies'] = $this->getRepliesByComment((int)$comment['id']);
        }
        unset($comment);

        return $comments;
    }

    /**
     * Fetch all visible replies for a comment.
     */
    public function getRepliesByComment(int $comment_id): array
    {
        $stmt = $this->conn->prepare(
            "SELECT
                cr.id,
                cr.message,
                cr.created_at,
                CONCAT(u.first_name, ' ', u.last_name) AS author_name,
                cr.author_id
             FROM comment_replies cr
             JOIN users u ON u.id = cr.author_id
             WHERE cr.comment_id = :cid AND cr.is_removed = 0
             ORDER BY cr.created_at ASC"
        );
        $stmt->execute([':cid' => $comment_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Insert a new comment. Returns the full inserted row (with author info).
     */
    public function createComment(int $thread_id, int $author_id, string $message): array|false
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO thread_comments (thread_id, author_id, message)
             VALUES (:tid, :uid, :msg)"
        );
        $stmt->execute([':tid' => $thread_id, ':uid' => $author_id, ':msg' => $message]);
        $comment_id = (int)$this->conn->lastInsertId();

        $fetch = $this->conn->prepare(
            "SELECT tc.id, tc.message, tc.created_at,
                    u.first_name, u.last_name
             FROM thread_comments tc
             JOIN users u ON u.id = tc.author_id
             WHERE tc.id = :cid"
        );
        $fetch->execute([':cid' => $comment_id]);
        return $fetch->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Insert a new reply to a comment. Returns the full inserted row.
     */
    public function createReply(int $comment_id, int $author_id, string $message): array|false
    {
        // Verify parent comment exists and is not removed
        $check = $this->conn->prepare(
            "SELECT id FROM thread_comments WHERE id = :cid AND is_removed = 0"
        );
        $check->execute([':cid' => $comment_id]);
        if (!$check->fetch()) {
            return false;
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO comment_replies (comment_id, author_id, message)
             VALUES (:cid, :uid, :msg)"
        );
        $stmt->execute([':cid' => $comment_id, ':uid' => $author_id, ':msg' => $message]);
        $reply_id = (int)$this->conn->lastInsertId();

        $fetch = $this->conn->prepare(
            "SELECT cr.id, cr.message, cr.created_at,
                    u.first_name, u.last_name
             FROM comment_replies cr
             JOIN users u ON u.id = cr.author_id
             WHERE cr.id = :rid"
        );
        $fetch->execute([':rid' => $reply_id]);
        return $fetch->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Check whether a thread exists and is not removed.
     */
    public function threadExists(int $thread_id): bool
    {
        $check = $this->conn->prepare(
            "SELECT id FROM threads WHERE id = :id AND is_removed = 0"
        );
        $check->execute([':id' => $thread_id]);
        return (bool)$check->fetch();
    }
}