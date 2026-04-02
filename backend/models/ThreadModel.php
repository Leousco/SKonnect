<?php
// backend/models/ThreadModel.php

class ThreadModel
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Fetch all visible threads for the feed, with counts and user state.
     */
    public function getFeedThreads(int $user_id): array
    {
        $stmt = $this->conn->prepare(
            "SELECT
                t.id,
                t.category,
                t.subject,
                t.message,
                t.status,
                t.created_at,
                CONCAT(u.first_name, ' ', u.last_name) AS author_name,
                (SELECT COUNT(*) FROM thread_comments  tc  WHERE tc.thread_id  = t.id AND tc.is_removed = 0)           AS comment_count,
                (SELECT COUNT(*) FROM thread_supports  ts  WHERE ts.thread_id  = t.id)                                AS support_count,
                (SELECT COUNT(*) FROM thread_bookmarks tb  WHERE tb.thread_id  = t.id AND tb.user_id = :uid1)          AS is_bookmarked,
                (SELECT COUNT(*) FROM thread_supports  ts2 WHERE ts2.thread_id = t.id AND ts2.user_id = :uid2)         AS user_supported
             FROM threads t
             JOIN users u ON u.id = t.author_id
             WHERE t.is_removed = 0
             ORDER BY t.created_at DESC"
        );
        $stmt->execute([':uid1' => $user_id, ':uid2' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch a single thread by ID with counts and user state.
     */
    public function getThreadById(int $thread_id, int $user_id): array|false
    {
        $stmt = $this->conn->prepare(
            "SELECT
                t.*,
                CONCAT(u.first_name, ' ', u.last_name) AS author_name,
                (SELECT COUNT(*) FROM thread_supports  ts  WHERE ts.thread_id  = t.id)                                AS support_count,
                (SELECT COUNT(*) FROM thread_comments  tc  WHERE tc.thread_id  = t.id AND tc.is_removed = 0)           AS comment_count,
                (SELECT COUNT(*) FROM thread_bookmarks tb  WHERE tb.thread_id  = t.id AND tb.user_id = :uid1)          AS is_bookmarked,
                (SELECT COUNT(*) FROM thread_supports  ts2 WHERE ts2.thread_id = t.id AND ts2.user_id = :uid2)         AS user_supported
             FROM threads t
             JOIN users u ON u.id = t.author_id
             WHERE t.id = :tid AND t.is_removed = 0
             LIMIT 1"
        );
        $stmt->execute([':uid1' => $user_id, ':uid2' => $user_id, ':tid' => $thread_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch images for a given thread.
     */
    public function getThreadImages(int $thread_id): array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM thread_images WHERE thread_id = :tid ORDER BY id ASC"
        );
        $stmt->execute([':tid' => $thread_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Insert a new thread. Returns the new thread ID.
     */
    public function createThread(int $author_id, string $category, string $subject, string $message): int
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO threads (author_id, category, subject, message)
             VALUES (:author_id, :category, :subject, :message)"
        );
        $stmt->execute([
            ':author_id' => $author_id,
            ':category'  => $category,
            ':subject'   => $subject,
            ':message'   => $message,
        ]);
        return (int)$this->conn->lastInsertId();
    }

    /**
     * Insert a thread image record.
     */
    public function addThreadImage(int $thread_id, string $file_name, string $file_path): void
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO thread_images (thread_id, file_name, file_path)
             VALUES (:thread_id, :file_name, :file_path)"
        );
        $stmt->execute([
            ':thread_id' => $thread_id,
            ':file_name' => $file_name,
            ':file_path' => $file_path,
        ]);
    }
}