<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Reports</title>
    <link rel="stylesheet" href="../../../styles/management/admin/admin_dashboard.css">
    <link rel="stylesheet" href="../../../styles/management/mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_topbar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_manage_services.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_threads.css">
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
            'spam'          => '🚫',
            'abuse'         => '⚠️',
            'harassment'    => '😡',
            'misinformation'=> '❌',
            'other'         => '📋',
        ];

        $counts = [
            'total'   => count($reports),
            'pending' => count(array_filter($reports, fn($r) => $r['status'] === 'pending')),
            'warned'  => count(array_filter($reports, fn($r) => $r['status'] === 'warned')),
            'ignored' => count(array_filter($reports, fn($r) => $r['status'] === 'ignored')),
        ];
        ?>

        <!-- Controls -->
        <div class="svc-controls">
            <div class="svc-controls-left">
                <div class="svc-search-wrap">
                    <span class="svc-search-icon">🔍</span>
                    <input type="text" id="report-search" class="svc-search-input" placeholder="Search reports...">
                </div>
                <select id="report-type" class="svc-select">
                    <option value="all">All Types</option>
                    <option value="thread">Thread</option>
                    <option value="comment">Comment</option>
                </select>
                <select id="report-reason" class="svc-select">
                    <option value="all">All Reasons</option>
                    <option value="spam">Spam</option>
                    <option value="abuse">Abuse</option>
                    <option value="harassment">Harassment</option>
                    <option value="misinformation">Misinformation</option>
                    <option value="other">Other</option>
                </select>
                <select id="report-status" class="svc-select">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="warned">Warned</option>
                    <option value="ignored">Ignored</option>
                </select>
            </div>
        </div>

        <!-- Stats Strip -->
        <div class="svc-stats-strip">
            <div class="svc-stat-pill">
                <span class="svc-stat-num"><?= $counts['total'] ?></span>
                <span>Total Reports</span>
            </div>
            <div class="svc-stat-pill stat-pending">
                <span class="svc-stat-num"><?= $counts['pending'] ?></span>
                <span>Pending</span>
            </div>
            <div class="svc-stat-pill stat-approved">
                <span class="svc-stat-num"><?= $counts['warned'] ?></span>
                <span>Warned</span>
            </div>
            <div class="svc-stat-pill stat-inactive">
                <span class="svc-stat-num"><?= $counts['ignored'] ?></span>
                <span>Ignored</span>
            </div>
        </div>

        <!-- Reports Grid -->
        <p class="svc-section-label">All Reports</p>
        <div class="svc-grid" id="report-grid">
            <?php foreach ($reports as $report):
                $icon = $reasonIcons[$report['reason']] ?? '📋';
            ?>
            <article class="svc-card"
                data-type="<?= $report['type'] ?>"
                data-reason="<?= $report['reason'] ?>"
                data-status="<?= $report['status'] ?>"
                data-content="<?= strtolower($report['content']) ?>"
                data-reporter="<?= strtolower($report['reported_by']) ?>">
                <div class="svc-card-body">

                    <div class="svc-card-top">
                        <div style="display:flex; gap:6px; flex-wrap:wrap; flex:1;">
                            <span class="thread-type-badge type-<?= $report['type'] ?>">
                                <?= $report['type'] === 'thread' ? '🧵 Thread' : '💬 Comment' ?>
                            </span>
                            <span class="thread-reason-badge reason-<?= $report['reason'] ?>">
                                <?= $icon ?> <?= ucfirst($report['reason']) ?>
                            </span>
                            <span class="svc-badge badge-report-<?= $report['status'] ?>">
                                <?= ucfirst($report['status']) ?>
                            </span>
                        </div>
                    </div>

                    <h3 class="svc-card-title"><?= htmlspecialchars($report['content']) ?></h3>
                    <p class="svc-card-excerpt" style="font-style:italic; border-left:3px solid var(--ap-border); padding-left:10px;">
                        "<?= htmlspecialchars($report['excerpt']) ?>"
                    </p>

                    <ul class="svc-details">
                        <li>
                            <span class="svc-detail-label">Reported by</span>
                            <?= htmlspecialchars($report['reported_by']) ?>
                        </li>
                        <li>
                            <span class="svc-detail-label">Author</span>
                            <?= htmlspecialchars($report['author']) ?>
                        </li>
                        <li>
                            <span class="svc-detail-label">Date</span>
                            <?= htmlspecialchars($report['date']) ?>
                        </li>
                    </ul>

                    <div class="svc-card-actions">
                        <button class="btn-svc-primary"
                            onclick="openReportModal(<?= htmlspecialchars(json_encode($report)) ?>)">
                            👁️ Review
                        </button>
                    </div>

                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <div class="svc-no-results" id="no-results" style="display:none;">
            <p>No reports found matching your search.</p>
        </div>

    </main>
</div>

<!-- REPORT ACTION MODAL -->
<div class="svc-modal-overlay" id="report-modal-overlay">
    <div class="svc-modal-box">

        <div class="svc-modal-header">
            <div class="svc-modal-header-left">
                <div class="svc-modal-icon" id="report-modal-icon">⚠️</div>
                <div>
                    <h3 class="svc-modal-title" id="report-modal-title">Report Details</h3>
                    <p class="svc-modal-subtitle" id="report-modal-subtitle">Reported Content</p>
                </div>
            </div>
            <button class="svc-modal-close" onclick="closeReportModal()">×</button>
        </div>

        <div class="svc-modal-summary">
            <div class="svc-summary-item">
                <span class="svc-summary-label">Reported By</span>
                <span class="svc-summary-value" id="report-modal-reporter">—</span>
            </div>
            <div class="svc-summary-item">
                <span class="svc-summary-label">Author</span>
                <span class="svc-summary-value" id="report-modal-author">—</span>
            </div>
            <div class="svc-summary-item">
                <span class="svc-summary-label">Reason</span>
                <span class="svc-summary-value" id="report-modal-reason">—</span>
            </div>
        </div>

        <div class="svc-modal-body">
            <div class="svc-form-group">
                <label class="svc-label">Reported Content</label>
                <p id="report-modal-excerpt" style="font-size:13px; color:var(--ap-text-body); font-family:'Poppins',sans-serif; line-height:1.6; background:var(--ap-surface-2); border:1px solid var(--ap-border); border-radius:8px; padding:12px 14px; font-style:italic; border-left: 3px solid var(--ap-danger);"></p>
            </div>
            <div class="svc-form-group">
                <label class="svc-label">Report Details</label>
                <p id="report-modal-details" style="font-size:13px; color:var(--ap-text-body); font-family:'Poppins',sans-serif; line-height:1.6;"></p>
            </div>
            <div class="svc-form-group">
                <label class="svc-label">Date Reported</label>
                <p id="report-modal-date" style="font-size:13px; color:var(--ap-text-muted); font-family:'Poppins',sans-serif;"></p>
            </div>
            <div class="svc-form-group">
                <label class="svc-label">Admin Note <span style="color:var(--ap-text-muted); font-weight:400; text-transform:none;">(optional)</span></label>
                <textarea class="svc-textarea" id="report-admin-note" placeholder="Add an internal note or reason for action..."></textarea>
            </div>
        </div>

        <div class="svc-modal-footer" style="flex-wrap:wrap;">
            <button class="btn-svc-secondary"                          onclick="closeReportModal()">Close</button>
            <button class="btn-svc-primary"                            onclick="reportAction('ignore')" style="background:#6b7280;">✅ Ignore</button>
            <button class="btn-svc-primary"                            onclick="reportAction('warn')"   style="background:#d97706;">⚠️ Warn</button>
            <button class="btn-svc-danger btn-svc-primary"             onclick="reportAction('delete')" style="background:var(--ap-danger); color:white; border:none;">❌ Delete Post</button>
            <button class="btn-svc-primary"                            onclick="reportAction('ban')"    style="background:#1e1b4b;">🚫 Ban User</button>
        </div>

    </div>
</div>

<script src="../../../scripts/management/admin/admin_reports.js"></script>
<script src="../../../scripts/management/admin/admin_sidebar.js"></script>
</body>
</html>