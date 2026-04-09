<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Reports</title>
    <link rel="stylesheet" href="../../../styles/management/mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_topbar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_manage_services.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_threads.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_reports.css">
</head>
<body>

<div class="admin-layout">

    <?php include __DIR__ . '/../../../components/management/admin/admin_sidebar.php'; ?>

    <main class="admin-content">

        <?php
        $pageTitle      = 'Reports';
        $pageBreadcrumb = [['Home', '#'], ['Community', '#'], ['Reports', null]];
        $adminName      = $_SESSION['user_name'] ?? 'Admin';
        $adminRole      = 'System Admin';
        $notifCount     = 7;
        include __DIR__ . '/../../../components/management/admin/admin_topbar.php';
        ?>

        <?php
        $reports = [
            [
                'id'           => 1,
                'type'         => 'thread',
                'content'      => 'Scholarship Application Inquiry',
                'excerpt'      => 'Can SK provide guidance on how to submit the scholarship application for 2026?',
                'reported_by'  => 'Juan Dela Cruz',
                'author'       => 'Maria Santos',
                'reason'       => 'spam',
                'details'      => 'This post has been spammed multiple times by the same user.',
                'date'         => 'Feb 11, 2026',
                'status'       => 'pending',
            ],
            [
                'id'           => 2,
                'type'         => 'comment',
                'content'      => 'Comment on: Street Lighting Issue',
                'excerpt'      => 'This is a useless post, stop flooding the feed with nonsense.',
                'reported_by'  => 'Ana Reyes',
                'author'       => 'Unknown User',
                'reason'       => 'abuse',
                'details'      => 'The comment contains offensive language directed at the original poster.',
                'date'         => 'Feb 13, 2026',
                'status'       => 'pending',
            ],
            [
                'id'           => 3,
                'type'         => 'thread',
                'content'      => 'Request for Basketball Court Repairs',
                'excerpt'      => 'The flooring on the covered court has cracks causing injuries during games.',
                'reported_by'  => 'Carlo Mendoza',
                'author'       => 'Marco Santos',
                'reason'       => 'misinformation',
                'details'      => 'The information about the court damage is exaggerated and misleading.',
                'date'         => 'Feb 18, 2026',
                'status'       => 'warned',
            ],
            [
                'id'           => 4,
                'type'         => 'comment',
                'content'      => 'Comment on: Flooding Near Purok 4',
                'excerpt'      => 'Just move out if you don\'t like it here. Stop complaining.',
                'reported_by'  => 'Liza Bautista',
                'author'       => 'Anonymous',
                'reason'       => 'harassment',
                'details'      => 'The comment is directed at harassing other residents who filed the complaint.',
                'date'         => 'Feb 21, 2026',
                'status'       => 'pending',
            ],
            [
                'id'           => 5,
                'type'         => 'thread',
                'content'      => 'Stray Dogs Roaming Near Elementary School',
                'excerpt'      => 'Several stray dogs have been seen roaming near the elementary school entrance.',
                'reported_by'  => 'Pedro Reyes',
                'author'       => 'Josephine Garcia',
                'reason'       => 'spam',
                'details'      => 'Same content posted 3 times in a row.',
                'date'         => 'Feb 26, 2026',
                'status'       => 'ignored',
            ],
            [
                'id'           => 6,
                'type'         => 'comment',
                'content'      => 'Comment on: Community Clean-Up Drive',
                'excerpt'      => 'Admin is corrupt and does not care about residents!',
                'reported_by'  => 'Maria Santos',
                'author'       => 'Bico Sico',
                'reason'       => 'abuse',
                'details'      => 'Baseless accusations against SK officers in a public thread.',
                'date'         => 'Feb 27, 2026',
                'status'       => 'pending',
            ],
        ];

        $reasonIcons = [
            'spam'           => '🚫',
            'abuse'          => '⚠️',
            'harassment'     => '😡',
            'misinformation' => '❌',
            'other'          => '📋',
        ];

        $counts = [
            'total'   => count($reports),
            'pending' => count(array_filter($reports, fn($r) => $r['status'] === 'pending')),
            'warned'  => count(array_filter($reports, fn($r) => $r['status'] === 'warned')),
            'ignored' => count(array_filter($reports, fn($r) => $r['status'] === 'ignored')),
        ];
        ?>

        <!-- Controls -->
        <div class="rpt-controls">
            <div class="rpt-controls-left">
                <div class="rpt-search-wrap">
                    <span class="rpt-search-icon">🔍</span>
                    <input type="text" id="report-search" class="rpt-search-input" placeholder="Search reports…">
                </div>
                <select id="report-type" class="rpt-select">
                    <option value="all">All Types</option>
                    <option value="thread">Thread</option>
                    <option value="comment">Comment</option>
                </select>
                <select id="report-reason" class="rpt-select">
                    <option value="all">All Reasons</option>
                    <option value="spam">Spam</option>
                    <option value="abuse">Abuse</option>
                    <option value="harassment">Harassment</option>
                    <option value="misinformation">Misinformation</option>
                    <option value="other">Other</option>
                </select>
                <select id="report-status" class="rpt-select">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="warned">Warned</option>
                    <option value="ignored">Ignored</option>
                </select>
            </div>
        </div>

        <!-- Stats Strip -->
        <div class="rpt-stats-strip">
            <div class="rpt-stat-pill">
                <span class="rpt-stat-num"><?= $counts['total'] ?></span>
                <span>Total Reports</span>
            </div>
            <div class="rpt-stat-pill stat-pending">
                <span class="rpt-stat-num"><?= $counts['pending'] ?></span>
                <span>Pending</span>
            </div>
            <div class="rpt-stat-pill stat-warned">
                <span class="rpt-stat-num"><?= $counts['warned'] ?></span>
                <span>Warned</span>
            </div>
            <div class="rpt-stat-pill stat-ignored">
                <span class="rpt-stat-num"><?= $counts['ignored'] ?></span>
                <span>Ignored</span>
            </div>
        </div>

        <!-- Reports Table -->
        <p class="rpt-section-label">All Reports</p>

        <div class="rpt-table-wrap">
            <table class="rpt-table" id="report-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Content / Subject</th>
                        <th>Reason</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="report-tbody">
                    <?php foreach ($reports as $report):
                        $icon = $reasonIcons[$report['reason']] ?? '📋';
                    ?>
                    <tr class="rpt-row"
                        data-type="<?= $report['type'] ?>"
                        data-reason="<?= $report['reason'] ?>"
                        data-status="<?= $report['status'] ?>"
                        data-content="<?= strtolower($report['content']) ?>"
                        data-reporter="<?= strtolower($report['reported_by']) ?>">

                        <td class="rpt-td-id"><?= $report['id'] ?></td>

                        <td>
                            <span class="rpt-type-badge type-<?= $report['type'] ?>">
                                <?= $report['type'] === 'thread' ? '🧵 Thread' : '💬 Comment' ?>
                            </span>
                        </td>

                        <td class="rpt-td-content">
                            <span class="rpt-content-title"><?= htmlspecialchars($report['content']) ?></span>
                        </td>

                        <td>
                            <span class="rpt-reason-badge reason-<?= $report['reason'] ?>">
                                <?= $icon ?> <?= ucfirst($report['reason']) ?>
                            </span>
                        </td>

                        <td class="rpt-td-date"><?= htmlspecialchars($report['date']) ?></td>

                        <td>
                            <span class="rpt-status-badge status-<?= $report['status'] ?>">
                                <?= ucfirst($report['status']) ?>
                            </span>
                        </td>

                        <td>
                            <button class="btn-rpt-review"
                                onclick="openReportModal(<?= htmlspecialchars(json_encode($report)) ?>)">
                                👁️ Review
                            </button>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="rpt-no-results" id="no-results" style="display:none;">
                <p>No reports found matching your search.</p>
            </div>
        </div>

    </main>
</div>

<!-- REPORT ACTION MODAL -->
<div class="rpt-modal-overlay" id="report-modal-overlay">
    <div class="rpt-modal-box">

        <!-- Header -->
        <div class="rpt-modal-header">
            <div class="rpt-modal-header-left">
                <div class="rpt-modal-icon" id="report-modal-icon">⚠️</div>
                <div>
                    <h3 class="rpt-modal-title" id="report-modal-title">Report Details</h3>
                    <p class="rpt-modal-subtitle" id="report-modal-subtitle">Reported Content</p>
                </div>
            </div>
            <button class="rpt-modal-close" onclick="closeReportModal()">×</button>
        </div>

        <!-- Summary strip -->
        <div class="rpt-modal-summary">
            <div class="rpt-summary-item">
                <span class="rpt-summary-label">Reported By</span>
                <span class="rpt-summary-value" id="report-modal-reporter">—</span>
            </div>
            <div class="rpt-summary-item">
                <span class="rpt-summary-label">Author</span>
                <span class="rpt-summary-value" id="report-modal-author">—</span>
            </div>
            <div class="rpt-summary-item">
                <span class="rpt-summary-label">Reason</span>
                <span class="rpt-summary-value" id="report-modal-reason">—</span>
            </div>
            <div class="rpt-summary-item">
                <span class="rpt-summary-label">Date Reported</span>
                <span class="rpt-summary-value" id="report-modal-date">—</span>
            </div>
        </div>

        <!-- Body -->
        <div class="rpt-modal-body">

            <div class="rpt-form-group">
                <label class="rpt-label">Reported Content</label>
                <p id="report-modal-excerpt" class="rpt-content-block rpt-content-block--flagged"></p>
            </div>

            <div class="rpt-form-group">
                <label class="rpt-label">Report Details</label>
                <p id="report-modal-details" class="rpt-content-block"></p>
            </div>

            <div class="rpt-form-group">
                <label class="rpt-label">
                    Admin Note
                    <span class="rpt-label-optional">(optional)</span>
                </label>
                <textarea class="rpt-textarea" id="report-admin-note" placeholder="Add an internal note or reason for action…"></textarea>
            </div>

        </div>

        <!-- Footer actions -->
        <div class="rpt-modal-footer">
            <button class="btn-rpt-secondary"  onclick="closeReportModal()">Close</button>
            <button class="btn-rpt-ignore"     onclick="reportAction('ignore')">✅ Ignore</button>
            <button class="btn-rpt-warn"       onclick="reportAction('warn')">⚠️ Warn User</button>
            <button class="btn-rpt-delete"     onclick="reportAction('delete')">❌ Delete Post</button>
            <button class="btn-rpt-ban"        onclick="reportAction('ban')">🚫 Ban User</button>
        </div>

    </div>
</div>

<script src="../../../scripts/management/admin/admin_reports.js"></script>
</body>
</html>