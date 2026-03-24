<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Manage Services</title>
    <link rel="stylesheet" href="../../../styles/management/admin/admin_dashboard.css">
    <link rel="stylesheet" href="../../../styles/management/mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_topbar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_manage_services.css">
</head>
<body>

<div class="admin-layout">

    <?php include __DIR__ . '/../../../components/management/admin/admin_sidebar.php'; ?>

    <main class="admin-content">

        <?php
        $pageTitle      = 'Manage Services';
        $pageBreadcrumb = [['Home', '#'], ['Services', '#'], ['Manage Services', null]];
        $adminName      = $_SESSION['user_name'] ?? 'Admin';
        $adminRole      = 'System Admin';
        $notifCount     = 7;
        include __DIR__ . '/../../../components/management/admin/admin_topbar.php';
        ?>

        <?php
        $services = [
            ['id' => 1, 'name' => 'Medical Assistance',   'category' => 'medical',     'description' => 'Financial assistance for medical bills, prescriptions, and emergency care for youth residents.', 'eligibility' => 'Registered youth resident',    'processing_time' => '3–5 working days', 'requirements' => 'Valid ID, Medical Certificate',           'status' => 'active'],
            ['id' => 2, 'name' => 'Educational Support',  'category' => 'education',   'description' => 'Assistance for school supplies, tuition fees, and academic-related expenses.',                   'eligibility' => 'Currently enrolled student',   'processing_time' => '5–7 working days', 'requirements' => 'Enrollment Certificate, Valid ID',        'status' => 'active'],
            ['id' => 3, 'name' => 'Scholarship Program',  'category' => 'scholarship', 'description' => 'Apply for SK scholarship programs for qualified youth residents.',                               'eligibility' => 'GPA 1.75 or higher',           'processing_time' => '2–3 weeks',        'requirements' => 'Transcript of Records, Endorsement Letter','status' => 'active'],
            ['id' => 4, 'name' => 'Livelihood Support',   'category' => 'livelihood',  'description' => 'Training programs and financial support for youth livelihood projects.',                         'eligibility' => 'Youth residents, 15–30 years', 'processing_time' => '1–2 weeks',        'requirements' => 'Project Proposal, Valid ID',              'status' => 'active'],
            ['id' => 5, 'name' => 'Dental Assistance',    'category' => 'medical',     'description' => 'Free or subsidized dental check-ups and treatments for eligible youth residents.',               'eligibility' => 'Registered youth resident',    'processing_time' => '3–5 working days', 'requirements' => 'Valid ID, Dental History',                'status' => 'active'],
            ['id' => 6, 'name' => 'Skills Training',      'category' => 'livelihood',  'description' => 'Support for youth to learn new skills, attend workshops, and start livelihood projects.',        'eligibility' => 'Youth residents, 15–30 years', 'processing_time' => '1–2 weeks',        'requirements' => 'Valid ID, Training Application Form',     'status' => 'inactive'],
        ];

        $categoryIcons = [
            'medical'     => '🏥',
            'education'   => '🎓',
            'scholarship' => '🏅',
            'livelihood'  => '🛠️',
        ];

        $totalActive   = count(array_filter($services, fn($s) => $s['status'] === 'active'));
        $totalInactive = count(array_filter($services, fn($s) => $s['status'] === 'inactive'));
        ?>

        <!-- Controls -->
        <div class="svc-controls">
            <div class="svc-controls-left">
                <div class="svc-search-wrap">
                    <span class="svc-search-icon">🔍</span>
                    <input type="text" id="svc-search" class="svc-search-input" placeholder="Search services...">
                </div>
                <select id="svc-category" class="svc-select">
                    <option value="all">All Categories</option>
                    <option value="medical">Medical</option>
                    <option value="education">Education</option>
                    <option value="livelihood">Livelihood</option>
                    <option value="scholarship">Scholarship</option>
                </select>
                <select id="svc-status" class="svc-select">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="svc-controls-right">
                <button class="btn-svc-add" onclick="openAddModal()">+ Add Service</button>
            </div>
        </div>

        <!-- Stats Strip -->
        <div class="svc-stats-strip">
            <div class="svc-stat-pill stat-active">
                <span class="svc-stat-num"><?= $totalActive ?></span>
                <span>Active</span>
            </div>
            <div class="svc-stat-pill stat-inactive">
                <span class="svc-stat-num"><?= $totalInactive ?></span>
                <span>Inactive</span>
            </div>
            <div class="svc-stat-pill">
                <span class="svc-stat-num"><?= count($services) ?></span>
                <span>Total Services</span>
            </div>
        </div>

        <!-- Services Grid -->
        <p class="svc-section-label">All Services</p>
        <div class="svc-grid" id="svc-grid">
            <?php foreach ($services as $service):
                $icon = $categoryIcons[$service['category']] ?? '📋';
            ?>
            <article class="svc-card"
                data-category="<?= $service['category'] ?>"
                data-status="<?= $service['status'] ?>"
                data-name="<?= strtolower($service['name']) ?>">
                <div class="svc-card-body">
                    <div class="svc-card-top">
                        <div class="svc-icon-wrap svc-icon-<?= $service['category'] ?>">
                            <?= $icon ?>
                        </div>
                        <span class="svc-badge badge-<?= $service['status'] ?>">
                            <?= $service['status'] === 'active' ? 'Active' : 'Inactive' ?>
                        </span>
                    </div>
                    <h3 class="svc-card-title"><?= htmlspecialchars($service['name']) ?></h3>
                    <p class="svc-card-excerpt"><?= htmlspecialchars($service['description']) ?></p>
                    <ul class="svc-details">
                        <li>
                            <span class="svc-detail-label">Eligibility</span>
                            <?= htmlspecialchars($service['eligibility']) ?>
                        </li>
                        <li>
                            <span class="svc-detail-label">Processing</span>
                            <?= htmlspecialchars($service['processing_time']) ?>
                        </li>
                        <li>
                            <span class="svc-detail-label">Required</span>
                            <?= htmlspecialchars($service['requirements']) ?>
                        </li>
                    </ul>
                    <div class="svc-card-actions">
                        <button class="btn-svc-primary"
                            onclick="openEditModal(<?= htmlspecialchars(json_encode($service)) ?>)">
                            ✏️ Edit
                        </button>
                        <button class="btn-svc-danger"
                            onclick="deleteService(<?= $service['id'] ?>, '<?= htmlspecialchars($service['name'], ENT_QUOTES) ?>')">
                            🗑️ Delete
                        </button>
                        <span class="svc-cat-tag tag-<?= $service['category'] ?>">
                            <?= ucfirst($service['category']) ?>
                        </span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <div class="svc-no-results" id="no-results" style="display:none;">
            <p>No services found matching your search.</p>
        </div>

    </main>
</div>

<!-- ADD / EDIT MODAL -->
<div class="svc-modal-overlay" id="svc-modal-overlay">
    <div class="svc-modal-box">

        <div class="svc-modal-header">
            <div class="svc-modal-header-left">
                <div class="svc-modal-icon" id="modal-icon">📋</div>
                <div>
                    <h3 class="svc-modal-title" id="modal-title">Add Service</h3>
                    <p class="svc-modal-subtitle">Fill in the service details below.</p>
                </div>
            </div>
            <button class="svc-modal-close" onclick="closeModal()">×</button>
        </div>

        <div class="svc-modal-body">
            <input type="hidden" id="serviceId">

            <div class="svc-form-row">
                <div class="svc-form-group">
                    <label class="svc-label">Service Name <span class="svc-required">*</span></label>
                    <input type="text" class="svc-input" id="serviceName" placeholder="e.g. Medical Assistance">
                    <span class="svc-field-error" id="err-name"></span>
                </div>
                <div class="svc-form-group">
                    <label class="svc-label">Category <span class="svc-required">*</span></label>
                    <select class="svc-select-input" id="serviceCategory">
                        <option value="medical">Medical</option>
                        <option value="education">Education</option>
                        <option value="scholarship">Scholarship</option>
                        <option value="livelihood">Livelihood</option>
                    </select>
                </div>
            </div>

            <div class="svc-form-group">
                <label class="svc-label">Description</label>
                <textarea class="svc-textarea" id="serviceDescription" placeholder="Describe the service..."></textarea>
            </div>

            <div class="svc-form-row">
                <div class="svc-form-group">
                    <label class="svc-label">Eligibility</label>
                    <input type="text" class="svc-input" id="serviceEligibility" placeholder="e.g. Registered youth resident">
                </div>
                <div class="svc-form-group">
                    <label class="svc-label">Processing Time</label>
                    <input type="text" class="svc-input" id="serviceTime" placeholder="e.g. 3–5 working days">
                </div>
            </div>

            <div class="svc-form-group">
                <label class="svc-label">Requirements</label>
                <input type="text" class="svc-input" id="serviceRequirements" placeholder="e.g. Valid ID, Medical Certificate">
            </div>

            <div class="svc-form-group">
                <label class="svc-label">Status</label>
                <select class="svc-select-input" id="serviceStatus">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div class="svc-modal-footer">
            <button class="btn-svc-secondary" onclick="closeModal()">Cancel</button>
            <button class="btn-svc-primary" onclick="saveService()">💾 Save Service</button>
        </div>

    </div>
</div>

<script src="../../../scripts/management/admin/admin_manage_services.js"></script>
</body>
</html>