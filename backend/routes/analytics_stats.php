<?php
/**
 * analytics_stats.php
 * Returns all analytics data for the admin analytics page.
 * Place at: /backend/routes/analytics_stats.php
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../middleware/RoleMiddleware.php';
require_once __DIR__ . '/../config/database.php';

RoleMiddleware::requireAdmin();

$db   = new Database();
$conn = $db->getConnection();

$year = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');

try {

    /* ── STAT CARDS ─────────────────────────────────────── */

    // Total residents
    $stmt = $conn->query("
        SELECT COUNT(*) FROM users u
        JOIN user_status us ON u.id = us.user_id
        WHERE u.role = 'resident' AND us.is_deleted = 0
    ");
    $totalUsers = (int)$stmt->fetchColumn();

    // New residents this month
    $stmt = $conn->query("
        SELECT COUNT(*) FROM users u
        JOIN user_status us ON u.id = us.user_id
        WHERE u.role = 'resident' AND us.is_deleted = 0
          AND MONTH(u.created_at) = MONTH(CURDATE())
          AND YEAR(u.created_at)  = YEAR(CURDATE())
    ");
    $newThisMonth = (int)$stmt->fetchColumn();

    // Total service requests
    $stmt = $conn->query("SELECT COUNT(*) FROM service_applications");
    $totalRequests = (int)$stmt->fetchColumn();

    // Requests this month
    $stmt = $conn->query("
        SELECT COUNT(*) FROM service_applications
        WHERE MONTH(submitted_at) = MONTH(CURDATE())
          AND YEAR(submitted_at)  = YEAR(CURDATE())
    ");
    $requestsThisMonth = (int)$stmt->fetchColumn();

    // Most requested service (current month)
    $stmt = $conn->query("
        SELECT s.name, s.category, COUNT(*) AS cnt
        FROM service_applications sa
        JOIN services s ON sa.service_id = s.id
        WHERE MONTH(sa.submitted_at) = MONTH(CURDATE())
          AND YEAR(sa.submitted_at)  = YEAR(CURDATE())
        GROUP BY s.id
        ORDER BY cnt DESC
        LIMIT 1
    ");
    $topService = $stmt->fetch(PDO::FETCH_ASSOC);

    // Active vs inactive users
    $stmt = $conn->query("
        SELECT
            SUM(us.is_active = 1 AND us.is_banned = 0 AND us.is_deleted = 0) AS active,
            SUM(us.is_active = 0 OR us.is_banned = 1)                         AS inactive
        FROM users u
        JOIN user_status us ON u.id = us.user_id
        WHERE u.role = 'resident' AND us.is_deleted = 0
    ");
    $activeStats = $stmt->fetch(PDO::FETCH_ASSOC);
    $activeUsers   = (int)($activeStats['active']   ?? 0);
    $inactiveUsers = (int)($activeStats['inactive'] ?? 0);
    $activePct     = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0;

    /* ── REQUESTS PER MONTH (selected year) ─────────────── */
    $stmt = $conn->prepare("
        SELECT MONTH(submitted_at) AS mo, COUNT(*) AS cnt
        FROM service_applications
        WHERE YEAR(submitted_at) = :year
        GROUP BY mo
        ORDER BY mo
    ");
    $stmt->execute([':year' => $year]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $requestsByMonth = array_fill(1, 12, 0);
    foreach ($rows as $r) $requestsByMonth[(int)$r['mo']] = (int)$r['cnt'];
    $requestsByMonth = array_values($requestsByMonth); // 0-indexed

    /* ── SERVICE TYPE BREAKDOWN (current month) ─────────── */
    $stmt = $conn->query("
        SELECT s.category, COUNT(*) AS cnt
        FROM service_applications sa
        JOIN services s ON sa.service_id = s.id
        WHERE MONTH(sa.submitted_at) = MONTH(CURDATE())
          AND YEAR(sa.submitted_at)  = YEAR(CURDATE())
        GROUP BY s.category
        ORDER BY cnt DESC
    ");
    $serviceBreakdown = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* ── USER GROWTH (last 12 months — cumulative) ───────── */
    $stmt = $conn->query("
        SELECT
            DATE_FORMAT(created_at, '%b') AS lbl,
            DATE_FORMAT(created_at, '%Y-%m') AS ym,
            COUNT(*) AS cnt
        FROM users
        WHERE role = 'resident'
          AND created_at >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 11 MONTH)
        GROUP BY ym, lbl
        ORDER BY ym ASC
    ");
    $monthRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Build cumulative count — start from total minus last 12 months additions
    $stmt = $conn->query("
        SELECT COUNT(*) FROM users
        WHERE role = 'resident'
          AND created_at < DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 11 MONTH)
    ");
    $baseCount = (int)$stmt->fetchColumn();

    $growthLabels = [];
    $growthData   = [];
    $running      = $baseCount;
    foreach ($monthRows as $r) {
        $running        += (int)$r['cnt'];
        $growthLabels[]  = $r['lbl'];
        $growthData[]    = $running;
    }

    /* ── AVAILABLE YEARS for year filter ────────────────── */
    $stmt = $conn->query("
        SELECT DISTINCT YEAR(submitted_at) AS yr
        FROM service_applications
        ORDER BY yr DESC
    ");
    $availableYears = $stmt->fetchAll(PDO::FETCH_COLUMN);
    if (empty($availableYears)) $availableYears = [(int)date('Y')];

    /* ── RESPONSE ────────────────────────────────────────── */
    echo json_encode([
        'status' => 'success',
        'data'   => [
            'totalUsers'        => $totalUsers,
            'newThisMonth'      => $newThisMonth,
            'totalRequests'     => $totalRequests,
            'requestsThisMonth' => $requestsThisMonth,
            'topService'        => $topService ?: ['name' => 'N/A', 'category' => 'other', 'cnt' => 0],
            'activeUsers'       => $activeUsers,
            'inactiveUsers'     => $inactiveUsers,
            'activePct'         => $activePct,
            'requestsByMonth'   => $requestsByMonth,
            'serviceBreakdown'  => $serviceBreakdown,
            'growthLabels'      => $growthLabels,
            'growthData'        => $growthData,
            'availableYears'    => $availableYears,
            'selectedYear'      => $year,
        ],
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}