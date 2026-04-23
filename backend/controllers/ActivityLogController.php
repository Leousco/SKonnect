<?php
/**
 * ActivityLogController.php
 *
 * Two purposes:
 *  1. GET  ?action=get_logs   → return paginated, filtered log entries (admin only)
 *  2. Static helper  ActivityLogController::log(...)  used by other controllers
 *     to INSERT a row without duplicating DB setup code.
 *
 * Usage from another controller:
 *   require_once __DIR__ . '/ActivityLogController.php';
 *   ActivityLogController::log($conn, $userId, 'approved', 'Approved request for Juan');
 */

require_once __DIR__ . '/../middleware/RoleMiddleware.php';
require_once __DIR__ . '/../config/database.php';

/* ── Static helper (always available, no HTTP context needed) ── */
class ActivityLogController
{
    /**
     * Insert one activity-log row.
     *
     * @param PDO         $conn        Active DB connection
     * @param int|null    $userId      The acting user's ID (null = system)
     * @param string      $action      e.g. 'approved', 'deleted', 'login'
     * @param string      $description Human-readable description (HTML allowed)
     * @param string|null $ip          IP address; pass null to auto-detect
     */
    public static function log(
        PDO    $conn,
        ?int   $userId,
        string $action,
        string $description,
        ?string $ip = null
    ): void {
        try {
            $ip = $ip ?? self::clientIp();
            $stmt = $conn->prepare("
                INSERT INTO activity_logs (user_id, action, description, ip_address)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$userId, $action, $description, $ip]);
        } catch (Exception $e) {
            // Never let logging break the main request
            error_log('[ActivityLog] ' . $e->getMessage());
        }
    }

    private static function clientIp(): string
    {
        foreach (['HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'] as $key) {
            if (!empty($_SERVER[$key])) {
                return trim(explode(',', $_SERVER[$key])[0]);
            }
        }
        return '0.0.0.0';
    }
}

/* ── HTTP endpoint (only runs when this file is hit directly) ── */
if (basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__)) {

    RoleMiddleware::requireAdmin();
    header('Content-Type: application/json');

    $action = $_GET['action'] ?? '';

    if ($action !== 'get_logs') {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => "Unknown action: '$action'"]);
        exit;
    }

    try {
        $db   = new Database();
        $conn = $db->getConnection();

        /* ── Query params ── */
        $search   = trim($_GET['search']   ?? '');
        $actFlt   = trim($_GET['action_filter'] ?? '');   // avoid collision with $action
        $dateFrom = trim($_GET['date_from'] ?? '');
        $dateTo   = trim($_GET['date_to']   ?? '');
        $page     = max(1, (int)($_GET['page']      ?? 1));
        $pageSize = max(1, min(100, (int)($_GET['page_size'] ?? 10)));

        /* ── Build WHERE ── */
        $where  = ['1=1'];
        $params = [];

        if ($search !== '') {
            $where[]  = "(al.description LIKE ? OR u.first_name LIKE ? OR u.last_name LIKE ? OR al.action LIKE ?)";
            $like     = "%{$search}%";
            $params   = array_merge($params, [$like, $like, $like, $like]);
        }
        if ($actFlt !== '') {
            $where[]  = 'al.action = ?';
            $params[] = $actFlt;
        }
        if ($dateFrom !== '') {
            $where[]  = 'DATE(al.created_at) >= ?';
            $params[] = $dateFrom;
        }
        if ($dateTo !== '') {
            $where[]  = 'DATE(al.created_at) <= ?';
            $params[] = $dateTo;
        }

        $whereSQL = implode(' AND ', $where);
        $offset   = ($page - 1) * $pageSize;

        /* ── Count ── */
        $cntStmt = $conn->prepare("
            SELECT COUNT(*) FROM activity_logs al
            LEFT JOIN users u ON u.id = al.user_id
            WHERE {$whereSQL}
        ");
        $cntStmt->execute($params);
        $total = (int)$cntStmt->fetchColumn();

        /* ── Rows ── */
        $rowStmt = $conn->prepare("
            SELECT
                al.id,
                al.user_id,
                COALESCE(CONCAT(u.first_name, ' ', u.last_name), 'System') AS user_name,
                COALESCE(u.role, 'system')                                  AS user_role,
                al.action,
                al.description,
                al.ip_address,
                al.created_at
            FROM activity_logs al
            LEFT JOIN users u ON u.id = al.user_id
            WHERE {$whereSQL}
            ORDER BY al.created_at DESC
            LIMIT {$pageSize} OFFSET {$offset}
        ");
        $rowStmt->execute($params);
        $rows = $rowStmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'success',
            'data'   => [
                'logs'      => $rows,
                'total'     => $total,
                'page'      => $page,
                'page_size' => $pageSize,
                'pages'     => (int)ceil($total / $pageSize),
            ],
        ]);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}