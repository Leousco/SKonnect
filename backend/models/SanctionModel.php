<?php
// backend/models/SanctionModel.php

class SanctionModel
{
    private PDO $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Get the highest active sanction level for a user.
     * Returns 0 if no active sanctions.
     */
    public function getActiveLevel(int $user_id): int
    {
        // First, expire any level-2 bans that have passed
        $this->expireOldBans($user_id);

        $stmt = $this->conn->prepare(
            "SELECT MAX(level) FROM user_sanctions
             WHERE user_id = :uid AND is_active = 1"
        );
        $stmt->execute([':uid' => $user_id]);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Get all sanctions for a user (most recent first).
     */
    public function getByUser(int $user_id): array
    {
        $stmt = $this->conn->prepare(
            "SELECT us.*,
                    CONCAT(m.first_name, ' ', m.last_name) AS issued_by_name
             FROM user_sanctions us
             JOIN users m ON m.id = us.issued_by
             WHERE us.user_id = :uid
             ORDER BY us.created_at DESC"
        );
        $stmt->execute([':uid' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Issue a new sanction.
     *
     * Level 1 — warning (no ban, no expiry)
     * Level 2 — 7-day posting ban
     * Level 3 — permanent feed ban
     *
     * Returns the new sanction ID.
     */
    public function issue(
        int    $user_id,
        int    $issued_by,
        int    $level,
        string $reason,
        ?int   $report_id = null
    ): int {
        // Calculate expiry for level 2
        $expires_at = null;
        if ($level === 2) {
            $expires_at = date('Y-m-d H:i:s', strtotime('+7 days'));
        }

        $stmt = $this->conn->prepare(
            "INSERT INTO user_sanctions
                (user_id, issued_by, level, reason, report_id, expires_at, is_active)
             VALUES
                (:user_id, :issued_by, :level, :reason, :report_id, :expires_at, 1)"
        );
        $stmt->execute([
            ':user_id'    => $user_id,
            ':issued_by'  => $issued_by,
            ':level'      => $level,
            ':reason'     => $reason,
            ':report_id'  => $report_id,
            ':expires_at' => $expires_at,
        ]);

        $sanction_id = (int)$this->conn->lastInsertId();

        // Mirror the ban level on the users row for fast feed-gate checks
        $this->syncUserBanFlag($user_id, $level, $expires_at);

        return $sanction_id;
    }

    /**
     * Determine what the NEXT sanction level should be for a user.
     * Mods can override, but this is what the system recommends.
     */
    public function getNextLevel(int $user_id): int
    {
        $current = $this->getActiveLevel($user_id);
        return min($current + 1, 3);
    }

    /**
     * Deactivate all active sanctions for a user (used if a mod lifts restrictions).
     */
    public function clearSanctions(int $user_id): bool
    {
        $stmt = $this->conn->prepare(
            "UPDATE user_sanctions SET is_active = 0 WHERE user_id = :uid AND is_active = 1"
        );
        $ok = $stmt->execute([':uid' => $user_id]);
        if ($ok) {
            $this->syncUserBanFlag($user_id, 0, null);
        }
        return $ok;
    }

    // ── PRIVATE HELPERS ──────────────────────────────────────────

    /**
     * Auto-expire level-2 sanctions that have passed their expires_at.
     */
    private function expireOldBans(int $user_id): void
    {
        $stmt = $this->conn->prepare(
            "UPDATE user_sanctions
             SET is_active = 0
             WHERE user_id = :uid
               AND level = 2
               AND is_active = 1
               AND expires_at IS NOT NULL
               AND expires_at < NOW()"
        );
        $stmt->execute([':uid' => $user_id]);

        // If no more active level-2 (or higher) bans remain, clear the flag
        $remaining = $this->conn->prepare(
            "SELECT COUNT(*) FROM user_sanctions
             WHERE user_id = :uid AND is_active = 1 AND level >= 2"
        );
        $remaining->execute([':uid' => $user_id]);
        if ((int)$remaining->fetchColumn() === 0) {
            // Only reset if not permanently banned
            $perm = $this->conn->prepare(
                "SELECT COUNT(*) FROM user_sanctions
                 WHERE user_id = :uid AND is_active = 1 AND level = 3"
            );
            $perm->execute([':uid' => $user_id]);
            if ((int)$perm->fetchColumn() === 0) {
                $this->syncUserBanFlag($user_id, 0, null);
            }
        }
    }

    /**
     * Keep users.feed_ban_level and users.feed_ban_expires in sync.
     */
    private function syncUserBanFlag(int $user_id, int $level, ?string $expires_at): void
    {
        // Only apply if the column exists (graceful no-op if migration hasn't run)
        try {
            $stmt = $this->conn->prepare(
                "UPDATE users
                 SET feed_ban_level   = :level,
                     feed_ban_expires = :expires
                 WHERE id = :uid"
            );
            $stmt->execute([
                ':level'   => $level,
                ':expires' => $expires_at,
                ':uid'     => $user_id,
            ]);
        } catch (\PDOException $e) {
            // Column doesn't exist yet — skip silently
            error_log('SanctionModel::syncUserBanFlag skipped: ' . $e->getMessage());
        }
    }

    /**
     * Get summary stats for the widget row.
     */
    public function getStats(): array
    {
        $row = $this->conn->query(
            "SELECT
                COUNT(*)                                      AS total_active,
                SUM(level = 1 AND is_active = 1)             AS level1,
                SUM(level = 2 AND is_active = 1)             AS level2,
                SUM(level = 3 AND is_active = 1)             AS level3,
                SUM(DATE(created_at) = CURDATE())            AS today
             FROM user_sanctions"
        )->fetch(PDO::FETCH_ASSOC);

        return $row ?: ['total_active' => 0, 'level1' => 0, 'level2' => 0, 'level3' => 0, 'today' => 0];
    }
}