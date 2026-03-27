<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireRole('sk_officer');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Services — SK Officer</title>
    <link rel="stylesheet" href="../../../styles/management/officer_mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/officer/officer_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/officer/officer_topbar.css">
    <link rel="stylesheet" href="../../../styles/management/officer/officer_services.css">
</head>
<body>

<div class="off-layout">

    <?php include __DIR__ . '/../../../components/management/officer/officer_sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="off-content">

    <?php
    $pageTitle      = 'Services';
    $pageBreadcrumb = [['Home', '#'], ['Operations', null], ['Services', null]];
    $officerName    = $_SESSION['user_name'] ?? 'SK Officer';
    $officerRole    = 'SK Officer';
    $notifCount     = 3;
    include __DIR__ . '/../../../components/management/officer/officer_topbar.php';
    ?>

    <?php
    /* ── SAMPLE DATA (replace with DB query) ────────────────── */
    $services = [
        [
            'id'              => 1,
            'name'            => 'Medical Assistance',
            'category'        => 'medical',
            'description'     => 'Financial assistance for medical bills, prescriptions, and emergency care for youth residents.',
            'eligibility'     => 'Registered youth resident',
            'processing_time' => '3–5 working days',
            'requirements'    => 'Valid ID, Medical Certificate',
            'status'          => 'active',
        ],
        [
            'id'              => 2,
            'name'            => 'Educational Support',
            'category'        => 'education',
            'description'     => 'Assistance for school supplies, tuition fees, and academic-related expenses for enrolled youth.',
            'eligibility'     => 'Currently enrolled student',
            'processing_time' => '5–7 working days',
            'requirements'    => 'Enrollment Certificate, Valid ID',
            'status'          => 'active',
        ],
        [
            'id'              => 3,
            'name'            => 'Scholarship Program',
            'category'        => 'scholarship',
            'description'     => 'Apply for SK scholarship programs for qualified youth residents pursuing higher education.',
            'eligibility'     => 'GPA 1.75 or higher',
            'processing_time' => '2–3 weeks',
            'requirements'    => 'Transcript of Records, Endorsement Letter',
            'status'          => 'active',
        ],
        [
            'id'              => 4,
            'name'            => 'Livelihood Support',
            'category'        => 'livelihood',
            'description'     => 'Training programs and financial support for youth livelihood projects and small businesses.',
            'eligibility'     => 'Youth residents, 15–30 years',
            'processing_time' => '1–2 weeks',
            'requirements'    => 'Project Proposal, Valid ID',
            'status'          => 'active',
        ],
        [
            'id'              => 5,
            'name'            => 'Dental Assistance',
            'category'        => 'medical',
            'description'     => 'Free or subsidized dental check-ups and treatments for eligible youth residents.',
            'eligibility'     => 'Registered youth resident',
            'processing_time' => '3–5 working days',
            'requirements'    => 'Valid ID, Dental History',
            'status'          => 'active',
        ],
        [
            'id'              => 6,
            'name'            => 'Skills Training',
            'category'        => 'livelihood',
            'description'     => 'Support for youth to attend workshops and develop new skills for employment or entrepreneurship.',
            'eligibility'     => 'Youth residents, 15–30 years',
            'processing_time' => '1–2 weeks',
            'requirements'    => 'Valid ID, Training Application Form',
            'status'          => 'inactive',
        ],
    ];

    $categoryMeta = [
        'medical'     => ['label' => 'Medical',     'icon' => 'svc-icon-medical'],
        'education'   => ['label' => 'Education',   'icon' => 'svc-icon-education'],
        'scholarship' => ['label' => 'Scholarship', 'icon' => 'svc-icon-scholarship'],
        'livelihood'  => ['label' => 'Livelihood',  'icon' => 'svc-icon-livelihood'],
    ];

    $categoryIcons = [
        'medical'     => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>',
        'education'   => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84 51.39 51.39 0 0 0-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/></svg>',
        'scholarship' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0"/></svg>',
        'livelihood'  => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z"/></svg>',
    ];

    $totalActive   = count(array_filter($services, fn($s) => $s['status'] === 'active'));
    $totalInactive = count(array_filter($services, fn($s) => $s['status'] === 'inactive'));
    $totalServices = count($services);
    ?>

        <!-- STAT WIDGETS -->
        <section class="off-widgets">

            <div class="off-widget-card widget-green">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Active Services</span>
                    <p class="widget-number"><?= $totalActive ?></p>
                    <span class="widget-trend up">&#9650; Open for requests</span>
                </div>
            </div>

            <div class="off-widget-card widget-indigo">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Inactive Services</span>
                    <p class="widget-number"><?= $totalInactive ?></p>
                    <span class="widget-trend warning">Closed to requests</span>
                </div>
            </div>

            <div class="off-widget-card widget-cyan">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Total Services</span>
                    <p class="widget-number"><?= $totalServices ?></p>
                    <span class="widget-trend neutral">All categories</span>
                </div>
            </div>

            <div class="off-widget-card widget-amber">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Pending Requests</span>
                    <p class="widget-number">8</p>
                    <span class="widget-trend warning">&#9650; Needs attention</span>
                </div>
            </div>

        </section>

        <!-- CONTROLS BAR -->
        <div class="svc-controls">
            <div class="svc-controls-left">
                <div class="svc-search-wrap">
                    <svg class="svc-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                    <input type="text" id="svc-search" class="svc-search-input" placeholder="Search services…">
                </div>
                <select id="svc-category" class="svc-select">
                    <option value="all">All Categories</option>
                    <option value="medical">Medical</option>
                    <option value="education">Education</option>
                    <option value="scholarship">Scholarship</option>
                    <option value="livelihood">Livelihood</option>
                </select>
                <select id="svc-status" class="svc-select">
                    <option value="all">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="svc-controls-right">
                <button class="svc-add-btn" id="svc-add-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    Add Service
                </button>
            </div>
        </div>

        <!-- SERVICES GRID -->
        <div class="panel-header" style="margin-bottom: 16px;">
            <h2 class="section-label">All Services</h2>
            <span class="svc-count" id="svc-count">Showing <?= $totalServices ?> services</span>
        </div>

        <div class="svc-grid" id="svc-grid">
            <?php foreach ($services as $svc):
                $meta = $categoryMeta[$svc['category']] ?? ['label' => ucfirst($svc['category']), 'icon' => ''];
                $icon = $categoryIcons[$svc['category']] ?? '';
            ?>
            <article class="svc-card"
                data-id="<?= $svc['id'] ?>"
                data-category="<?= $svc['category'] ?>"
                data-status="<?= $svc['status'] ?>"
                data-name="<?= strtolower(htmlspecialchars($svc['name'])) ?>">

                <!-- Status accent bar handled by CSS via data-status -->

                <div class="svc-card-body">

                    <!-- Top row: icon + status badge -->
                    <div class="svc-card-top">
                        <div class="svc-icon-wrap svc-icon-<?= $svc['category'] ?>">
                            <?= $icon ?>
                        </div>
                        <span class="svc-status-badge svc-badge-<?= $svc['status'] ?>">
                            <?php if ($svc['status'] === 'active'): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                Active
                            <?php else: ?>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                Inactive
                            <?php endif; ?>
                        </span>
                    </div>

                    <!-- Title -->
                    <h3 class="svc-card-title"><?= htmlspecialchars($svc['name']) ?></h3>

                    <!-- Category tag -->
                    <span class="svc-cat-tag svc-cat-<?= $svc['category'] ?>"><?= $meta['label'] ?></span>

                    <!-- Description -->
                    <p class="svc-card-desc"><?= htmlspecialchars($svc['description']) ?></p>

                    <!-- Details list -->
                    <ul class="svc-details-list">
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                            <span class="svc-detail-label">Eligibility</span>
                            <span><?= htmlspecialchars($svc['eligibility']) ?></span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            <span class="svc-detail-label">Processing</span>
                            <span><?= htmlspecialchars($svc['processing_time']) ?></span>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                            <span class="svc-detail-label">Requirements</span>
                            <span><?= htmlspecialchars($svc['requirements']) ?></span>
                        </li>
                    </ul>

                </div>

                <!-- Card Footer: actions -->
                <div class="svc-card-footer">
                    <!-- Toggle status -->
                    <button class="svc-toggle-btn svc-toggle-<?= $svc['status'] ?>"
                        data-id="<?= $svc['id'] ?>"
                        data-status="<?= $svc['status'] ?>"
                        title="<?= $svc['status'] === 'active' ? 'Deactivate' : 'Activate' ?> service">
                        <?php if ($svc['status'] === 'active'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9"/></svg>
                            Deactivate
                        <?php else: ?>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9"/></svg>
                            Activate
                        <?php endif; ?>
                    </button>
                    <div class="svc-card-actions-right">
                        <button class="svc-edit-btn"
                            data-service='<?= htmlspecialchars(json_encode($svc), ENT_QUOTES) ?>'
                            title="Edit service">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                            Edit
                        </button>
                        <button class="svc-delete-btn"
                            data-id="<?= $svc['id'] ?>"
                            data-name="<?= htmlspecialchars($svc['name'], ENT_QUOTES) ?>"
                            title="Delete service">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                            Delete
                        </button>
                    </div>
                </div>

            </article>
            <?php endforeach; ?>
        </div>

        <!-- NO RESULTS -->
        <div class="svc-no-results" id="svc-no-results" style="display:none;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
            <p>No services match your current filters.</p>
        </div>

    </main>
</div>

<!-- ADD / EDIT MODAL -->
<div class="svc-modal-overlay" id="svc-modal-overlay" style="display:none;" aria-modal="true" role="dialog" aria-labelledby="svc-modal-title">
    <div class="svc-modal-box">

        <div class="svc-modal-header">
            <div class="svc-modal-header-left">
                <div class="svc-modal-icon" id="svc-modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                </div>
                <div>
                    <h3 class="svc-modal-title" id="svc-modal-title">Add Service</h3>
                    <p class="svc-modal-subtitle">Fields marked <span class="svc-required">*</span> are required.</p>
                </div>
            </div>
            <button class="svc-modal-close" id="svc-modal-close" aria-label="Close">&times;</button>
        </div>

        <div class="svc-modal-body">
            <input type="hidden" id="svc-id">

            <!-- Row: Name + Category -->
            <div class="svc-form-row">
                <div class="svc-form-group">
                    <label class="svc-label" for="svc-name">Service Name <span class="svc-required">*</span></label>
                    <input type="text" id="svc-name" class="svc-input" placeholder="e.g. Medical Assistance" maxlength="80">
                    <span class="svc-field-error" id="err-svc-name"></span>
                </div>
                <div class="svc-form-group">
                    <label class="svc-label" for="svc-category-field">Category <span class="svc-required">*</span></label>
                    <select id="svc-category-field" class="svc-select-input">
                        <option value="">Select Category</option>
                        <option value="medical">Medical</option>
                        <option value="education">Education</option>
                        <option value="scholarship">Scholarship</option>
                        <option value="livelihood">Livelihood</option>
                    </select>
                    <span class="svc-field-error" id="err-svc-category"></span>
                </div>
            </div>

            <!-- Description -->
            <div class="svc-form-group">
                <label class="svc-label" for="svc-desc">Description <span class="svc-required">*</span></label>
                <textarea id="svc-desc" class="svc-textarea" rows="4" placeholder="Describe what this service offers…"></textarea>
                <span class="svc-field-error" id="err-svc-desc"></span>
            </div>

            <!-- Row: Eligibility + Processing Time -->
            <div class="svc-form-row">
                <div class="svc-form-group">
                    <label class="svc-label" for="svc-eligibility">Eligibility</label>
                    <input type="text" id="svc-eligibility" class="svc-input" placeholder="e.g. Registered youth resident">
                </div>
                <div class="svc-form-group">
                    <label class="svc-label" for="svc-time">Processing Time</label>
                    <input type="text" id="svc-time" class="svc-input" placeholder="e.g. 3–5 working days">
                </div>
            </div>

            <!-- Requirements -->
            <div class="svc-form-group">
                <label class="svc-label" for="svc-requirements">Requirements</label>
                <input type="text" id="svc-requirements" class="svc-input" placeholder="e.g. Valid ID, Medical Certificate">
            </div>

            <!-- Status -->
            <div class="svc-form-group">
                <label class="svc-label" for="svc-status-field">Status <span class="svc-required">*</span></label>
                <select id="svc-status-field" class="svc-select-input">
                    <option value="active">Active — open for requests</option>
                    <option value="inactive">Inactive — closed to requests</option>
                </select>
            </div>

        </div>

        <div class="svc-modal-footer">
            <button class="btn-off-sm" id="svc-modal-cancel">Cancel</button>
            <button class="svc-save-btn" id="svc-save-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                Save Service
            </button>
        </div>

    </div>
</div>

<!-- CONFIRM DELETE MODAL -->
<div class="svc-confirm-overlay" id="svc-confirm-overlay" style="display:none;" aria-modal="true" role="dialog">
    <div class="svc-confirm-box">
        <div class="svc-confirm-icon">🗑️</div>
        <h3 class="svc-confirm-title">Delete Service</h3>
        <p class="svc-confirm-body" id="svc-confirm-body">Are you sure you want to delete this service? This cannot be undone.</p>
        <div class="svc-confirm-footer">
            <button class="btn-off-sm" id="svc-confirm-cancel">Cancel</button>
            <button class="svc-confirm-delete" id="svc-confirm-delete">Delete</button>
        </div>
    </div>
</div>

<!-- TOAST -->
<div class="svc-toast" id="svc-toast" aria-live="polite"></div>

<script src="../../../scripts/management/officer/officer_services.js"></script>

</body>
</html>