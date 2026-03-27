<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireRole('sk_officer');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Requests — SK Officer</title>
    <link rel="stylesheet" href="../../../styles/management/officer_mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/officer/officer_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/officer/officer_topbar.css">
    <link rel="stylesheet" href="../../../styles/management/officer/officer_requests.css">
</head>
<body>

<div class="off-layout">

    <?php include __DIR__ . '/../../../components/management/officer/officer_sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="off-content">

    <?php
    $pageTitle      = 'Requests';
    $pageBreadcrumb = [['Home', '#'], ['Operations', null], ['Requests', null]];
    $officerName    = $_SESSION['user_name'] ?? 'SK Officer';
    $officerRole    = 'SK Officer';
    $notifCount     = 3;
    include __DIR__ . '/../../../components/management/officer/officer_topbar.php';
    ?>

    <?php
    /* ── SAMPLE DATA (replace with DB query) ────────────────── */
    $requests = [
        [
            'id'          => 1,
            'resident'    => 'Pedro Cruz',
            'initials'    => 'PC',
            'service'     => 'Barangay Clearance',
            'category'    => 'clearance',
            'purpose'     => 'For employment requirements at a local company.',
            'submitted'   => '2026-03-05',
            'submitted_f' => 'Mar 5, 2026',
            'status'      => 'pending',
            'has_files'   => true,
            'file_count'  => 2,
        ],
        [
            'id'          => 2,
            'resident'    => 'Ana Reyes',
            'initials'    => 'AR',
            'service'     => 'Certificate of Residency',
            'category'    => 'residency',
            'purpose'     => 'Required for scholarship application at DLSU.',
            'submitted'   => '2026-03-05',
            'submitted_f' => 'Mar 5, 2026',
            'status'      => 'processing',
            'has_files'   => true,
            'file_count'  => 1,
        ],
        [
            'id'          => 3,
            'resident'    => 'Jose Lim',
            'initials'    => 'JL',
            'service'     => 'Indigency Certificate',
            'category'    => 'indigency',
            'purpose'     => 'To avail PhilHealth indigent benefits.',
            'submitted'   => '2026-03-04',
            'submitted_f' => 'Mar 4, 2026',
            'status'      => 'pending',
            'has_files'   => false,
            'file_count'  => 0,
        ],
        [
            'id'          => 4,
            'resident'    => 'Maria Santos',
            'initials'    => 'MS',
            'service'     => 'Medical Assistance',
            'category'    => 'medical',
            'purpose'     => 'Financial assistance for hospitalization at Quezon City General Hospital.',
            'submitted'   => '2026-03-03',
            'submitted_f' => 'Mar 3, 2026',
            'status'      => 'approved',
            'has_files'   => true,
            'file_count'  => 3,
        ],
        [
            'id'          => 5,
            'resident'    => 'Carlo Mendoza',
            'initials'    => 'CM',
            'service'     => 'Educational Support',
            'category'    => 'education',
            'purpose'     => 'Assistance for school supplies and tuition for incoming semester.',
            'submitted'   => '2026-03-03',
            'submitted_f' => 'Mar 3, 2026',
            'status'      => 'approved',
            'has_files'   => true,
            'file_count'  => 2,
        ],
        [
            'id'          => 6,
            'resident'    => 'Sofia Villanueva',
            'initials'    => 'SV',
            'service'     => 'Scholarship Program',
            'category'    => 'scholarship',
            'purpose'     => 'Applying for SK Youth Scholarship for the academic year 2026–2027.',
            'submitted'   => '2026-03-02',
            'submitted_f' => 'Mar 2, 2026',
            'status'      => 'declined',
            'has_files'   => true,
            'file_count'  => 4,
        ],
        [
            'id'          => 7,
            'resident'    => 'Roberto Gomez',
            'initials'    => 'RG',
            'service'     => 'Livelihood Support',
            'category'    => 'livelihood',
            'purpose'     => 'Requesting funds to start a small sari-sari store as a livelihood project.',
            'submitted'   => '2026-03-01',
            'submitted_f' => 'Mar 1, 2026',
            'status'      => 'processing',
            'has_files'   => true,
            'file_count'  => 2,
        ],
        [
            'id'          => 8,
            'resident'    => 'Lita Punzalan',
            'initials'    => 'LP',
            'service'     => 'Business Permit Endorsement',
            'category'    => 'business',
            'purpose'     => 'Barangay endorsement for business permit renewal of a small eatery.',
            'submitted'   => '2026-02-28',
            'submitted_f' => 'Feb 28, 2026',
            'status'      => 'pending',
            'has_files'   => false,
            'file_count'  => 0,
        ],
        [
            'id'          => 9,
            'resident'    => 'Rey Santos',
            'initials'    => 'RS',
            'service'     => 'Barangay Clearance',
            'category'    => 'clearance',
            'purpose'     => 'Required for National ID application at PSA.',
            'submitted'   => '2026-02-27',
            'submitted_f' => 'Feb 27, 2026',
            'status'      => 'approved',
            'has_files'   => true,
            'file_count'  => 1,
        ],
        [
            'id'          => 10,
            'resident'    => 'Ana Cruz',
            'initials'    => 'AC',
            'service'     => 'Dental Assistance',
            'category'    => 'medical',
            'purpose'     => 'Requesting assistance for tooth extraction and dental consultation.',
            'submitted'   => '2026-02-26',
            'submitted_f' => 'Feb 26, 2026',
            'status'      => 'declined',
            'has_files'   => false,
            'file_count'  => 0,
        ],
    ];

    $counts = [
        'all'        => count($requests),
        'pending'    => count(array_filter($requests, fn($r) => $r['status'] === 'pending')),
        'processing' => count(array_filter($requests, fn($r) => $r['status'] === 'processing')),
        'approved'   => count(array_filter($requests, fn($r) => $r['status'] === 'approved')),
        'declined'   => count(array_filter($requests, fn($r) => $r['status'] === 'declined')),
    ];
    ?>

        <!-- STAT WIDGETS -->
        <section class="off-widgets">

            <div class="off-widget-card widget-amber">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Pending</span>
                    <p class="widget-number"><?= $counts['pending'] ?></p>
                    <span class="widget-trend warning">&#9650; Needs attention</span>
                </div>
            </div>

            <div class="off-widget-card widget-cyan">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Processing</span>
                    <p class="widget-number"><?= $counts['processing'] ?></p>
                    <span class="widget-trend neutral">Under review</span>
                </div>
            </div>

            <div class="off-widget-card widget-green">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Approved</span>
                    <p class="widget-number"><?= $counts['approved'] ?></p>
                    <span class="widget-trend up">&#9650; This month</span>
                </div>
            </div>

            <div class="off-widget-card widget-indigo">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Declined</span>
                    <p class="widget-number"><?= $counts['declined'] ?></p>
                    <span class="widget-trend danger">This month</span>
                </div>
            </div>

        </section>

        <!-- STATUS TABS + CONTROLS -->
        <div class="req-controls-wrap">

            <!-- Status tabs -->
            <div class="req-tabs" role="tablist">
                <button class="req-tab active" data-status="all"        role="tab">All </button>
                <button class="req-tab"        data-status="pending"    role="tab">Pending </button>
                <button class="req-tab"        data-status="processing" role="tab">Processing </span></button>
                <button class="req-tab"        data-status="approved"   role="tab">Approved </button>
                <button class="req-tab"        data-status="declined"   role="tab">Declined </button>
            </div>

            <!-- Search + filter -->
            <div class="req-filters">
                <div class="req-search-wrap">
                    <svg class="req-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                    <input type="text" id="req-search" class="req-search-input" placeholder="Search by resident or service…">
                </div>
                <select id="req-category" class="req-select">
                    <option value="all">All Services</option>
                    <option value="clearance">Barangay Clearance</option>
                    <option value="residency">Certificate of Residency</option>
                    <option value="indigency">Indigency Certificate</option>
                    <option value="medical">Medical / Dental</option>
                    <option value="education">Educational Support</option>
                    <option value="scholarship">Scholarship</option>
                    <option value="livelihood">Livelihood Support</option>
                    <option value="business">Business Permit</option>
                </select>
                <select id="req-sort" class="req-select">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                </select>
            </div>

        </div>

        <!-- REQUESTS TABLE -->
        <div class="req-table-panel">

            <div class="panel-header">
                <h2 class="section-label">All Requests</h2>
                <span class="req-count" id="req-count">Showing <?= $counts['all'] ?> requests</span>
            </div>

            <div class="req-table-wrap">
                <table class="req-table" id="req-table">
                    <thead>
                        <tr>
                            <th class="col-resident">Resident</th>
                            <th class="col-service">Service</th>
                            <th class="col-purpose">Purpose</th>
                            <th class="col-date sortable" data-col="date">Date Submitted <span class="sort-icon">↕</span></th>
                            <th class="col-files">Files</th>
                            <th class="col-status">Status</th>
                            <th class="col-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="req-tbody">

                    <?php foreach ($requests as $req): ?>
                        <tr data-id="<?= $req['id'] ?>"
                            data-status="<?= $req['status'] ?>"
                            data-category="<?= $req['category'] ?>"
                            data-date="<?= $req['submitted'] ?>"
                            data-resident="<?= strtolower(htmlspecialchars($req['resident'])) ?>"
                            data-service="<?= strtolower(htmlspecialchars($req['service'])) ?>"
                            data-purpose="<?= htmlspecialchars($req['purpose'], ENT_QUOTES) ?>"
                            data-submitted-f="<?= htmlspecialchars($req['submitted_f']) ?>"
                            data-has-files="<?= $req['has_files'] ? 'true' : 'false' ?>"
                            data-file-count="<?= $req['file_count'] ?>">

                            <!-- Resident -->
                            <td class="col-resident">
                                <div class="req-resident-cell">
                                    <div class="req-avatar"><?= htmlspecialchars($req['initials']) ?></div>
                                    <span class="req-resident-name"><?= htmlspecialchars($req['resident']) ?></span>
                                </div>
                            </td>

                            <!-- Service -->
                            <td class="col-service">
                                <span class="req-service-badge badge-<?= $req['category'] ?>">
                                    <?= htmlspecialchars($req['service']) ?>
                                </span>
                            </td>

                            <!-- Purpose -->
                            <td class="col-purpose">
                                <span class="req-purpose-text"><?= htmlspecialchars($req['purpose']) ?></span>
                            </td>

                            <!-- Date -->
                            <td class="col-date">
                                <time datetime="<?= $req['submitted'] ?>"><?= $req['submitted_f'] ?></time>
                            </td>

                            <!-- Files -->
                            <td class="col-files">
                                <?php if ($req['has_files']): ?>
                                    <span class="req-files-badge">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13"/></svg>
                                        <?= $req['file_count'] ?> file<?= $req['file_count'] !== 1 ? 's' : '' ?>
                                    </span>
                                <?php else: ?>
                                    <span class="req-no-files">—</span>
                                <?php endif; ?>
                            </td>

                            <!-- Status -->
                            <td class="col-status">
                                <span class="req-status-pill status-<?= $req['status'] ?>">
                                    <?= ucfirst($req['status']) ?>
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="col-actions">
                                <div class="req-action-group">
                                    <button class="req-btn-view" data-id="<?= $req['id'] ?>" title="View full request">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.641 0-8.573-3.007-9.964-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                        View
                                    </button>
                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>

            <!-- NO RESULTS -->
            <div class="req-no-results" id="req-no-results" style="display:none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                <p>No requests match your current filters.</p>
            </div>

        </div>

        <!-- PAGINATION -->
        <section class="off-pagination">
            <button class="off-page-btn" id="req-prev-btn" disabled>&#8249; Previous</button>
            <div class="off-page-numbers" id="req-page-numbers">
                <button class="off-page-num active">1</button>
                <button class="off-page-num">2</button>
                <button class="off-page-num">3</button>
            </div>
            <button class="off-page-btn" id="req-next-btn">Next &#8250;</button>
        </section>

    </main>
</div>

<!-- ── VIEW MODAL ────────────────────────────────────────────── -->
<div class="req-modal-overlay" id="req-drawer-overlay" style="display:none;" aria-modal="true" role="dialog">
    <div class="req-modal" id="req-drawer">

        <div class="req-modal-header">
            <div class="req-drawer-header-left">
                <div class="req-drawer-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                </div>
                <div>
                    <h2 class="req-drawer-title" id="drawer-title">Request Details</h2>
                    <p class="req-drawer-subtitle" id="drawer-subtitle">Request #—</p>
                </div>
            </div>
            <button class="req-drawer-close" id="req-drawer-close" aria-label="Close modal">&times;</button>
        </div>

        <div class="req-modal-body req-drawer-body">

            <!-- Resident info -->
            <div class="drawer-section">
                <p class="drawer-section-label">Resident</p>
                <div class="drawer-resident-row">
                    <div class="drawer-avatar" id="drawer-avatar">—</div>
                    <div>
                        <p class="drawer-resident-name" id="drawer-resident-name">—</p>
                        <p class="drawer-resident-sub">Barangay Resident</p>
                    </div>
                </div>
            </div>

            <!-- Request info -->
            <div class="drawer-row-2">
                <div class="drawer-section">
                    <p class="drawer-section-label">Service Requested</p>
                    <p class="drawer-value" id="drawer-service">—</p>
                </div>
                <div class="drawer-section">
                    <p class="drawer-section-label">Current Status</p>
                    <p class="drawer-value" id="drawer-status-wrap">—</p>
                </div>
            </div>

            <div class="drawer-section">
                <p class="drawer-section-label">Purpose / Details</p>
                <p class="drawer-value drawer-value--purpose" id="drawer-purpose">—</p>
            </div>

            <div class="drawer-section">
                <p class="drawer-section-label">Date Submitted</p>
                <p class="drawer-value" id="drawer-date">—</p>
            </div>

            <!-- Attachments -->
            <div class="drawer-section" id="drawer-files-section">
                <p class="drawer-section-label">Attachments</p>
                <div id="drawer-files">—</div>
            </div>

            <!-- Response -->
            <div class="drawer-section drawer-section--response">
                <p class="drawer-section-label">Officer Response <span class="drawer-optional">(optional)</span></p>
                <textarea id="drawer-response" class="drawer-textarea" rows="3" placeholder="Write a response or note to the resident…"></textarea>
            </div>

        </div>

        <div class="req-modal-footer req-drawer-footer" id="req-drawer-footer">
            <!-- Buttons injected by JS based on status -->
        </div>

    </div>
</div>

<!-- CONFIRM MODAL -->
<div class="req-confirm-overlay" id="req-confirm-overlay" style="display:none;" aria-modal="true" role="dialog">
    <div class="req-confirm-box">
        <div class="req-confirm-icon" id="req-confirm-icon">⚠️</div>
        <h3 class="req-confirm-title" id="req-confirm-title">Confirm Action</h3>
        <p class="req-confirm-body" id="req-confirm-body">Are you sure?</p>
        <div class="req-confirm-footer">
            <button class="btn-off-sm" id="req-confirm-cancel">Cancel</button>
            <button class="req-confirm-ok" id="req-confirm-ok">Confirm</button>
        </div>
    </div>
</div>

<!-- TOAST -->
<div class="req-toast" id="req-toast" aria-live="polite"></div>

<script src="../../../scripts/management/officer/officer_requests.js"></script>

</body>
</html>