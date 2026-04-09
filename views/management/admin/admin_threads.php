<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Threads</title>
    <link rel="stylesheet" href="../../../styles/management/mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_topbar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_threads.css">
</head>
<body>

<div class="admin-layout">

    <?php include __DIR__ . '/../../../components/management/admin/admin_sidebar.php'; ?>

    <main class="admin-content">

        <?php
        $pageTitle      = 'Threads';
        $pageBreadcrumb = [['Home', '#'], ['Community', '#'], ['Threads', null]];
        $adminName      = $_SESSION['user_name'] ?? 'Admin';
        $adminRole      = 'System Admin';
        $notifCount     = 7;
        include __DIR__ . '/../../../components/management/admin/admin_topbar.php';
        ?>

        <?php
        $threads = [
            [
                'id'       => 1,
                'title'    => 'Scholarship Application Inquiry',
                'excerpt'  => 'Can SK provide guidance on how to submit the scholarship application for 2026? Many youth residents are confused about the requirements.',
                'author'   => 'Maria Santos',
                'category' => 'program',
                'priority' => 'urgent',
                'status'   => 'pending',
                'comments' => 3,
                'date'     => 'Feb 10, 2026',
                'pinned'   => false,
                'locked'   => false,
            ],
            [
                'id'       => 2,
                'title'    => 'Street Lighting Issue',
                'excerpt'  => 'The street lights near Barangay Hall are not working. Please fix them as soon as possible before an accident occurs.',
                'author'   => 'Juan Dela Cruz',
                'category' => 'complaint',
                'priority' => 'normal',
                'status'   => 'responded',
                'comments' => 2,
                'date'     => 'Feb 8, 2026',
                'pinned'   => true,
                'locked'   => false,
            ],
            [
                'id'       => 3,
                'title'    => 'Community Clean-Up Drive Schedule',
                'excerpt'  => 'Requesting confirmation of the cleanup schedule for March. Many volunteers are waiting for the final schedule to be posted.',
                'author'   => 'Ana Reyes',
                'category' => 'event',
                'priority' => 'critical',
                'status'   => 'resolved',
                'comments' => 5,
                'date'     => 'Feb 12, 2026',
                'pinned'   => false,
                'locked'   => true,
            ],
            [
                'id'       => 4,
                'title'    => 'Broken Street Light on Sauyo Road',
                'excerpt'  => 'The street light near the barangay hall entrance has been out for two weeks. It\'s a safety hazard at night for residents walking home.',
                'author'   => 'Marco Santos',
                'category' => 'complaint',
                'priority' => 'normal',
                'status'   => 'pending',
                'comments' => 12,
                'date'     => 'Feb 17, 2026',
                'pinned'   => false,
                'locked'   => false,
            ],
            [
                'id'       => 5,
                'title'    => 'Request for Basketball Court Repairs',
                'excerpt'  => 'The flooring on the covered court has cracks causing injuries during games. Requesting the SK to prioritize repairs before the sports league starts.',
                'author'   => 'Carlo Mendoza',
                'category' => 'other',
                'priority' => 'normal',
                'status'   => 'pending',
                'comments' => 8,
                'date'     => 'Feb 19, 2026',
                'pinned'   => false,
                'locked'   => false,
            ],
            [
                'id'       => 6,
                'title'    => 'Flooding Near Purok 4 During Heavy Rain',
                'excerpt'  => 'Every time it rains heavily, the drainage near Purok 4 overflows and floods the pathway. Residents are asking if this can be raised to the barangay.',
                'author'   => 'Liza Bautista',
                'category' => 'complaint',
                'priority' => 'critical',
                'status'   => 'responded',
                'comments' => 3,
                'date'     => 'Feb 20, 2026',
                'pinned'   => false,
                'locked'   => false,
            ],
            [
                'id'       => 7,
                'title'    => 'Schedule for Upcoming Barangay Clearance Processing',
                'excerpt'  => 'May we know the updated schedule for barangay clearance processing this March? Some residents are unsure if walk-ins are still allowed.',
                'author'   => 'Marco Dela Cruz',
                'category' => 'inquiry',
                'priority' => 'normal',
                'status'   => 'pending',
                'comments' => 1,
                'date'     => 'Feb 22, 2026',
                'pinned'   => false,
                'locked'   => false,
            ],
            [
                'id'       => 8,
                'title'    => 'Stray Dogs Roaming Near Elementary School',
                'excerpt'  => 'Several stray dogs have been seen roaming near the elementary school entrance during dismissal hours. Parents are concerned about student safety.',
                'author'   => 'Josephine Garcia',
                'category' => 'other',
                'priority' => 'critical',
                'status'   => 'responded',
                'comments' => 8,
                'date'     => 'Feb 25, 2026',
                'pinned'   => false,
                'locked'   => false,
            ],
        ];

        $counts = [
            'total'     => count($threads),
            'pending'   => count(array_filter($threads, fn($t) => $t['status'] === 'pending')),
            'responded' => count(array_filter($threads, fn($t) => $t['status'] === 'responded')),
            'resolved'  => count(array_filter($threads, fn($t) => $t['status'] === 'resolved')),
            'pinned'    => count(array_filter($threads, fn($t) => $t['pinned'])),
            'locked'    => count(array_filter($threads, fn($t) => $t['locked'])),
        ];
        ?>

        <!-- Controls -->
        <div class="svc-controls">
            <div class="svc-controls-left">
                <div class="svc-search-wrap">
                    <span class="svc-search-icon">🔍</span>
                    <input type="text" id="thread-search" class="svc-search-input" placeholder="Search threads...">
                </div>
                <select id="thread-category" class="svc-select">
                    <option value="all">All Categories</option>
                    <option value="program">Program</option>
                    <option value="complaint">Complaint</option>
                    <option value="event">Event</option>
                    <option value="inquiry">Inquiry</option>
                    <option value="other">Other</option>
                </select>
                <select id="thread-status" class="svc-select">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="responded">Responded</option>
                    <option value="resolved">Resolved</option>
                </select>
                <select id="thread-priority" class="svc-select">
                    <option value="all">All Priority</option>
                    <option value="normal">Normal</option>
                    <option value="urgent">Urgent</option>
                    <option value="critical">Critical</option>
                </select>
            </div>
        </div>

        <!-- Stats Strip -->
        <div class="svc-stats-strip">
            <div class="svc-stat-pill">
                <span class="svc-stat-num"><?= $counts['total'] ?></span>
                <span>Total</span>
            </div>
            <div class="svc-stat-pill stat-pending">
                <span class="svc-stat-num"><?= $counts['pending'] ?></span>
                <span>Pending</span>
            </div>
            <div class="svc-stat-pill stat-approved">
                <span class="svc-stat-num"><?= $counts['responded'] ?></span>
                <span>Responded</span>
            </div>
            <div class="svc-stat-pill stat-completed">
                <span class="svc-stat-num"><?= $counts['resolved'] ?></span>
                <span>Resolved</span>
            </div>
            <div class="svc-stat-pill">
                <span class="svc-stat-num"><?= $counts['pinned'] ?></span>
                <span>📌 Pinned</span>
            </div>
            <div class="svc-stat-pill">
                <span class="svc-stat-num"><?= $counts['locked'] ?></span>
                <span>🔒 Locked</span>
            </div>
        </div>

        <!-- Threads Grid -->
        <p class="svc-section-label">All Threads</p>
        <div class="svc-grid" id="thread-grid">
            <?php foreach ($threads as $thread): ?>
            <article class="svc-card thread-card <?= $thread['pinned'] ? 'is-pinned' : '' ?> <?= $thread['locked'] ? 'is-locked' : '' ?>"
                data-category="<?= $thread['category'] ?>"
                data-status="<?= $thread['status'] ?>"
                data-priority="<?= $thread['priority'] ?>"
                data-title="<?= strtolower($thread['title']) ?>"
                data-author="<?= strtolower($thread['author']) ?>">
                <div class="svc-card-body">

                    <!-- Badges -->
                    <div class="svc-card-top" style="flex-wrap:wrap; gap:6px;">
                        <div style="display:flex; gap:6px; flex-wrap:wrap; flex:1;">
                            <span class="thread-cat-badge cat-<?= $thread['category'] ?>">
                                <?= ucfirst($thread['category']) ?>
                            </span>
                            <span class="thread-priority-badge priority-<?= $thread['priority'] ?>">
                                <?= ucfirst($thread['priority']) ?>
                            </span>
                            <span class="svc-badge badge-thread-<?= $thread['status'] ?>">
                                <?= ucfirst($thread['status']) ?>
                            </span>
                            <?php if ($thread['pinned']): ?>
                                <span class="thread-flag-badge">📌 Pinned</span>
                            <?php endif; ?>
                            <?php if ($thread['locked']): ?>
                                <span class="thread-flag-badge">🔒 Locked</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <h3 class="svc-card-title"><?= htmlspecialchars($thread['title']) ?></h3>
                    <p class="svc-card-excerpt"><?= htmlspecialchars($thread['excerpt']) ?></p>

                    <ul class="svc-details">
                        <li>
                            <span class="svc-detail-label">Author</span>
                            <?= htmlspecialchars($thread['author']) ?>
                        </li>
                        <li>
                            <span class="svc-detail-label">Posted</span>
                            <?= htmlspecialchars($thread['date']) ?>
                        </li>
                        <li>
                            <span class="svc-detail-label">Comments</span>
                            💬 <?= $thread['comments'] ?>
                        </li>
                    </ul>

                    <div class="svc-card-actions">
                        <button class="btn-svc-primary"
                            onclick="openThreadModal(<?= htmlspecialchars(json_encode($thread)) ?>)">
                            👁️ View & Act
                        </button>
                    </div>

                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <div class="svc-no-results" id="no-results" style="display:none;">
            <p>No threads found matching your search.</p>
        </div>

    </main>
</div>

<!-- THREAD ACTION MODAL -->
<div class="svc-modal-overlay" id="thread-modal-overlay">
    <div class="svc-modal-box">

        <div class="svc-modal-header">
            <div class="svc-modal-header-left">
                <div class="svc-modal-icon">💬</div>
                <div>
                    <h3 class="svc-modal-title" id="thread-modal-title">Thread Details</h3>
                    <p class="svc-modal-subtitle" id="thread-modal-subtitle">Community Thread</p>
                </div>
            </div>
            <button class="svc-modal-close" onclick="closeThreadModal()">×</button>
        </div>

        <div class="svc-modal-summary">
            <div class="svc-summary-item">
                <span class="svc-summary-label">Author</span>
                <span class="svc-summary-value" id="thread-modal-author">—</span>
            </div>
            <div class="svc-summary-item">
                <span class="svc-summary-label">Category</span>
                <span class="svc-summary-value" id="thread-modal-category">—</span>
            </div>
            <div class="svc-summary-item">
                <span class="svc-summary-label">Status</span>
                <span class="svc-summary-value" id="thread-modal-status">—</span>
            </div>
        </div>

        <div class="svc-modal-body">
            <div class="svc-form-group">
                <label class="svc-label">Thread Content</label>
                <p id="thread-modal-excerpt" style="font-size:13px; color:var(--ap-text-body); font-family:'Poppins',sans-serif; line-height:1.6; background:var(--ap-surface-2); border:1px solid var(--ap-border); border-radius:8px; padding:12px 14px;"></p>
            </div>
            <div class="svc-form-group">
                <label class="svc-label">Date Posted & Comments</label>
                <p id="thread-modal-meta" style="font-size:13px; color:var(--ap-text-muted); font-family:'Poppins',sans-serif;"></p>
            </div>
            <div class="svc-form-group">
                <label class="svc-label">Admin Note <span style="color:var(--ap-text-muted); font-weight:400; text-transform:none;">(optional)</span></label>
                <textarea class="svc-textarea" id="thread-admin-note" placeholder="Add an internal note..."></textarea>
            </div>
        </div>

        <div class="svc-modal-footer">
            <button class="btn-svc-secondary" onclick="closeThreadModal()">Close</button>
            <button class="btn-svc-primary" id="btn-pin"    onclick="threadAction('pin')">📌 Pin</button>
            <button class="btn-svc-primary" id="btn-lock"   onclick="threadAction('lock')" style="background:#92400e;">🔒 Lock</button>
            <button class="btn-svc-danger"  id="btn-delete" onclick="threadAction('delete')">🗑️ Delete</button>
        </div>

    </div>
</div>

<script src="../../../scripts/management/admin/admin_threads.js"></script>
</body>
</html>