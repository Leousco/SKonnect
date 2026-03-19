<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Service Requests</title>
    <link rel="stylesheet" href="../../../styles/management/admin/admin_dashboard.css">
    <link rel="stylesheet" href="../../../styles/management/mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_topbar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_services.css">
</head>
<body>

<div class="admin-layout">

    <?php include __DIR__ . '/../../../components/management/admin/admin_sidebar.php'; ?>

    <main class="admin-content">

        <?php
        $pageTitle      = 'Service Requests';
        $pageBreadcrumb = [['Home', '#'], ['Services', '#'], ['Service Requests', null]];
        $adminName      = $_SESSION['user_name'] ?? 'Admin';
        $adminRole      = 'System Admin';
        $notifCount     = 7;
        include __DIR__ . '/../../../components/management/admin/admin_topbar.php';
        ?>

        <?php
        $requests = [
            ['id' => 1, 'resident' => 'Juan Dela Cruz', 'service' => 'Medical Assistance',  'category' => 'medical',     'icon' => '🏥', 'contact' => '09171234567', 'address' => 'Purok 3, Barangay Sauyo', 'purpose' => 'I need financial assistance for my hospital bills due to recent surgery.',    'date' => '2026-03-10 09:00:00', 'status' => 'pending',   'admin_remarks' => ''],
            ['id' => 2, 'resident' => 'Maria Santos',   'service' => 'Scholarship Program',  'category' => 'scholarship', 'icon' => '🏅', 'contact' => '09189876543', 'address' => 'Purok 1, Barangay Sauyo', 'purpose' => 'I am applying for the SK scholarship to help with my college tuition.',       'date' => '2026-03-11 10:30:00', 'status' => 'approved',  'admin_remarks' => 'Documents verified. Approved for release.'],
            ['id' => 3, 'resident' => 'Pedro Reyes',    'service' => 'Livelihood Support',   'category' => 'livelihood',  'icon' => '🛠️', 'contact' => '09201112222', 'address' => 'Purok 5, Barangay Sauyo', 'purpose' => 'I want to start a small sari-sari store and need financial assistance.',    'date' => '2026-03-12 14:00:00', 'status' => 'rejected',  'admin_remarks' => 'Incomplete documents submitted.'],
            ['id' => 4, 'resident' => 'Ana Gonzales',   'service' => 'Dental Assistance',    'category' => 'medical',     'icon' => '🩺', 'contact' => '09153334444', 'address' => 'Purok 2, Barangay Sauyo', 'purpose' => 'I need a dental check-up and tooth extraction for my decaying molar.',      'date' => '2026-03-13 08:30:00', 'status' => 'completed', 'admin_remarks' => 'Assistance claimed.'],
            ['id' => 5, 'resident' => 'Bico Sico',      'service' => 'Educational Support',  'category' => 'education',   'icon' => '🎓', 'contact' => '09175556666', 'address' => 'Purok 4, Barangay Sauyo', 'purpose' => 'I need help buying school supplies and books for this coming semester.',  'date' => '2026-03-14 11:00:00', 'status' => 'pending',   'admin_remarks' => ''],
        ];

        $counts = [
            'pending'   => count(array_filter($requests, fn($r) => $r['status'] === 'pending')),
            'approved'  => count(array_filter($requests, fn($r) => $r['status'] === 'approved')),
            'rejected'  => count(array_filter($requests, fn($r) => $r['status'] === 'rejected')),
            'completed' => count(array_filter($requests, fn($r) => $r['status'] === 'completed')),
        ];
        ?>

        <!-- Controls -->
        <div class="svc-controls">
            <div class="svc-controls-left">
                <div class="svc-search-wrap">
                    <span class="svc-search-icon">🔍</span>
                    <input type="text" id="req-search" class="svc-search-input" placeholder="Search by name or service...">
                </div>
                <select id="req-category" class="svc-select">
                    <option value="all">All Categories</option>
                    <option value="medical">Medical</option>
                    <option value="education">Education</option>
                    <option value="livelihood">Livelihood</option>
                    <option value="scholarship">Scholarship</option>
                </select>
                <select id="req-status" class="svc-select">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
        </div>

        <!-- Stats Strip -->
        <div class="svc-stats-strip">
            <div class="svc-stat-pill stat-pending">
                <span class="svc-stat-num"><?= $counts['pending'] ?></span>
                <span>Pending</span>
            </div>
            <div class="svc-stat-pill stat-approved">
                <span class="svc-stat-num"><?= $counts['approved'] ?></span>
                <span>Approved</span>
            </div>
            <div class="svc-stat-pill stat-rejected">
                <span class="svc-stat-num"><?= $counts['rejected'] ?></span>
                <span>Rejected</span>
            </div>
            <div class="svc-stat-pill stat-completed">
                <span class="svc-stat-num"><?= $counts['completed'] ?></span>
                <span>Completed</span>
            </div>
            <div class="svc-stat-pill">
                <span class="svc-stat-num"><?= count($requests) ?></span>
                <span>Total</span>
            </div>
        </div>

        <!-- Requests Grid -->
        <p class="svc-section-label">All Service Requests</p>
        <div class="svc-grid" id="req-grid">
            <?php foreach ($requests as $req): ?>
            <article class="svc-card"
                data-category="<?= $req['category'] ?>"
                data-status="<?= $req['status'] ?>"
                data-name="<?= strtolower($req['resident']) ?>"
                data-service="<?= strtolower($req['service']) ?>">
                <div class="svc-card-body">
                    <div class="svc-card-top">
                        <div class="svc-icon-wrap svc-icon-<?= $req['category'] ?>">
                            <?= $req['icon'] ?>
                        </div>
                        <span class="svc-badge badge-<?= $req['status'] ?>">
                            <?= ucfirst($req['status']) ?>
                        </span>
                    </div>
                    <h3 class="svc-card-title"><?= htmlspecialchars($req['service']) ?></h3>
                    <p class="svc-card-excerpt">
                        <strong>👤 <?= htmlspecialchars($req['resident']) ?></strong><br>
                        <?= htmlspecialchars($req['purpose']) ?>
                    </p>
                    <ul class="svc-details">
                        <li>
                            <span class="svc-detail-label">Contact</span>
                            <?= htmlspecialchars($req['contact']) ?>
                        </li>
                        <li>
                            <span class="svc-detail-label">Address</span>
                            <?= htmlspecialchars($req['address']) ?>
                        </li>
                        <li>
                            <span class="svc-detail-label">Submitted</span>
                            <?= date('M d, Y h:i A', strtotime($req['date'])) ?>
                        </li>
                    </ul>
                    <div class="svc-card-actions">
                        <button class="btn-svc-primary"
                            onclick="openRequestModal(<?= htmlspecialchars(json_encode($req)) ?>)">
                            👁️ View & Act
                        </button>
                        <span class="svc-cat-tag tag-<?= $req['category'] ?>">
                            <?= ucfirst($req['category']) ?>
                        </span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <div class="svc-no-results" id="no-results" style="display:none;">
            <p>No requests found matching your search.</p>
        </div>

    </main>
</div>

<!-- VIEW / ACTION MODAL -->
<div class="svc-modal-overlay" id="req-modal-overlay">
    <div class="svc-modal-box">

        <div class="svc-modal-header">
            <div class="svc-modal-header-left">
                <div class="svc-modal-icon" id="req-modal-icon">🏥</div>
                <div>
                    <h3 class="svc-modal-title" id="req-modal-title">Request Details</h3>
                    <p class="svc-modal-subtitle" id="req-modal-subtitle">Service Request</p>
                </div>
            </div>
            <button class="svc-modal-close" onclick="closeRequestModal()">×</button>
        </div>

        <div class="svc-modal-summary">
            <div class="svc-summary-item">
                <span class="svc-summary-label">Resident</span>
                <span class="svc-summary-value" id="req-modal-resident">—</span>
            </div>
            <div class="svc-summary-item">
                <span class="svc-summary-label">Contact</span>
                <span class="svc-summary-value" id="req-modal-contact">—</span>
            </div>
            <div class="svc-summary-item">
                <span class="svc-summary-label">Status</span>
                <span class="svc-summary-value" id="req-modal-status">—</span>
            </div>
        </div>

        <div class="svc-modal-body">
            <div class="svc-form-group">
                <label class="svc-label">Address</label>
                <p id="req-modal-address" style="font-size:13px; color:var(--ap-text-body); font-family:'Poppins',sans-serif;"></p>
            </div>
            <div class="svc-form-group">
                <label class="svc-label">Date Submitted</label>
                <p id="req-modal-date" style="font-size:13px; color:var(--ap-text-body); font-family:'Poppins',sans-serif;"></p>
            </div>
            <div class="svc-form-group">
                <label class="svc-label">Purpose / Details</label>
                <p id="req-modal-purpose" style="font-size:13px; color:var(--ap-text-body); font-family:'Poppins',sans-serif; line-height:1.6;"></p>
            </div>
            <div class="svc-form-group">
                <label class="svc-label">Admin Remarks</label>
                <textarea class="svc-textarea" id="req-modal-remarks" placeholder="Add remarks or notes..."></textarea>
            </div>
        </div>

        <div class="svc-modal-footer">
            <button class="btn-svc-secondary" onclick="closeRequestModal()">Close</button>
            <button class="btn-svc-primary btn-svc-approve"  onclick="updateStatus('approved')">✅ Approve</button>
            <button class="btn-svc-primary btn-svc-reject"   onclick="updateStatus('rejected')">❌ Reject</button>
            <button class="btn-svc-primary btn-svc-complete" onclick="updateStatus('completed')">🏁 Complete</button>
        </div>

    </div>
</div>

<script src="../../../scripts/management/admin/admin_service_requests.js"></script>
<script src="../../../scripts/management/admin/admin_sidebar.js"></script>
</body>
</html>