<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Manage Users</title>
    <link rel="stylesheet" href="../../../styles/management/admin/admin_dashboard.css">
    <link rel="stylesheet" href="../../../styles/management/mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_topbar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_service_requests.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_users.css">
</head>
<body>

<div class="admin-layout">

    <?php include __DIR__ . '/../../../components/management/admin/admin_sidebar.php'; ?>

    <main class="admin-content">

        <?php
        $pageTitle      = 'Manage Users';
        $pageBreadcrumb = [['Home', '#'], ['Users', '#'], ['Manage Users', null]];
        $adminName      = $_SESSION['user_name'] ?? 'Admin';
        $adminRole      = 'System Admin';
        $notifCount     = 7;
        include __DIR__ . '/../../../components/management/admin/admin_topbar.php';
        ?>

        <?php
        $users = [
            ['id' => 12, 'first_name' => 'Rey',       'last_name' => 'Santos',   'middle_name' => 'Cruz',    'email' => 'admin@skonnect.com',       'role' => 'admin',      'gender' => 'male',   'age' => 25, 'is_verified' => 1, 'created_at' => '2026-03-04'],
            ['id' => 13, 'first_name' => 'Maya',      'last_name' => 'Reyes',    'middle_name' => 'Lim',     'email' => 'moderator@skonnect.com',   'role' => 'moderator',  'gender' => 'female', 'age' => 27, 'is_verified' => 1, 'created_at' => '2026-03-04'],
            ['id' => 14, 'first_name' => 'Carlo',     'last_name' => 'Mendoza',  'middle_name' => 'Bautista','email' => 'officer@skonnect.com',     'role' => 'sk_officer', 'gender' => 'male',   'age' => 30, 'is_verified' => 1, 'created_at' => '2026-03-04'],
            ['id' => 16, 'first_name' => 'Bico',      'last_name' => 'Sico',     'middle_name' => 'Qiko',    'email' => 'lvillete778@gmail.com',    'role' => 'resident',   'gender' => 'male',   'age' => 25, 'is_verified' => 1, 'created_at' => '2026-03-05'],
            ['id' => 17, 'first_name' => 'Leonardo',  'last_name' => 'Da Bink',  'middle_name' => 'name',    'email' => 'leovillete878@gmail.com',  'role' => 'resident',   'gender' => 'male',   'age' => 25, 'is_verified' => 1, 'created_at' => '2026-03-12'],
        ];

        $roleColors = [
            'admin'      => 'role-admin',
            'moderator'  => 'role-moderator',
            'sk_officer' => 'role-officer',
            'resident'   => 'role-resident',
        ];

        $roleLabels = [
            'admin'      => '🛡️ Admin',
            'moderator'  => '🔧 Moderator',
            'sk_officer' => '⭐ SK Officer',
            'resident'   => '👤 Resident',
        ];

        $counts = [
            'total'      => count($users),
            'admin'      => count(array_filter($users, fn($u) => $u['role'] === 'admin')),
            'moderator'  => count(array_filter($users, fn($u) => $u['role'] === 'moderator')),
            'sk_officer' => count(array_filter($users, fn($u) => $u['role'] === 'sk_officer')),
            'resident'   => count(array_filter($users, fn($u) => $u['role'] === 'resident')),
            'verified'   => count(array_filter($users, fn($u) => $u['is_verified'] == 1)),
        ];
        ?>

        <!-- Controls -->
        <div class="svc-controls">
            <div class="svc-controls-left">
                <div class="svc-search-wrap">
                    <span class="svc-search-icon">🔍</span>
                    <input type="text" id="user-search" class="svc-search-input" placeholder="Search by name or email...">
                </div>
                <select id="user-role" class="svc-select">
                    <option value="all">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="moderator">Moderator</option>
                    <option value="sk_officer">SK Officer</option>
                    <option value="resident">Resident</option>
                </select>
                <select id="user-gender" class="svc-select">
                    <option value="all">All Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <select id="user-verified" class="svc-select">
                    <option value="all">All Status</option>
                    <option value="1">Verified</option>
                    <option value="0">Unverified</option>
                </select>
            </div>
        </div>

        <!-- Stats Strip -->
        <div class="svc-stats-strip">
            <div class="svc-stat-pill">
                <span class="svc-stat-num"><?= $counts['total'] ?></span>
                <span>Total Users</span>
            </div>
            <div class="svc-stat-pill stat-approved">
                <span class="svc-stat-num"><?= $counts['verified'] ?></span>
                <span>Verified</span>
            </div>
            <div class="svc-stat-pill">
                <span class="svc-stat-num"><?= $counts['admin'] ?></span>
                <span>🛡️ Admins</span>
            </div>
            <div class="svc-stat-pill">
                <span class="svc-stat-num"><?= $counts['moderator'] ?></span>
                <span>🔧 Moderators</span>
            </div>
            <div class="svc-stat-pill">
                <span class="svc-stat-num"><?= $counts['sk_officer'] ?></span>
                <span>⭐ SK Officers</span>
            </div>
            <div class="svc-stat-pill">
                <span class="svc-stat-num"><?= $counts['resident'] ?></span>
                <span>👤 Residents</span>
            </div>
        </div>

        <!-- Users Table -->
        <p class="svc-section-label">All Users</p>
        <div class="user-table-wrap">
            <table class="user-table" id="user-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Verified</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="user-tbody">
                    <?php foreach ($users as $user):
                        $initials = strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1));
                        $fullName = $user['first_name'] . ' ' . $user['middle_name'] . ' ' . $user['last_name'];
                    ?>
                    <tr class="user-row"
                        data-role="<?= $user['role'] ?>"
                        data-gender="<?= $user['gender'] ?>"
                        data-verified="<?= $user['is_verified'] ?>"
                        data-name="<?= strtolower($fullName) ?>"
                        data-email="<?= strtolower($user['email']) ?>">
                        <td>
                            <div class="user-name-cell">
                                <div class="user-avatar role-avatar-<?= $user['role'] ?>"><?= $initials ?></div>
                                <div>
                                    <div class="user-fullname"><?= htmlspecialchars($fullName) ?></div>
                                    <div class="user-id">ID: <?= $user['id'] ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="user-email"><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <span class="user-role-badge <?= $roleColors[$user['role']] ?>">
                                <?= $roleLabels[$user['role']] ?>
                            </span>
                        </td>
                        <td><?= ucfirst($user['gender']) ?></td>
                        <td><?= $user['age'] ?></td>
                        <td>
                            <span class="user-verified-badge <?= $user['is_verified'] ? 'verified-yes' : 'verified-no' ?>">
                                <?= $user['is_verified'] ? '✅ Verified' : '❌ Unverified' ?>
                            </span>
                        </td>
                        <td class="user-date"><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                        <td>
                            <div class="user-actions">
                                <button class="btn-user-action btn-view"
                                    onclick="openUserModal(<?= htmlspecialchars(json_encode(array_merge($user, ['fullName' => $fullName, 'initials' => $initials]))) ?>)">
                                    👁️ View
                                </button>
                                <button class="btn-user-action btn-toggle"
                                    onclick="toggleUser(<?= $user['id'] ?>, '<?= htmlspecialchars($fullName, ENT_QUOTES) ?>')">
                                    <?= $user['is_verified'] ? '🚫 Deactivate' : '✅ Activate' ?>
                                </button>
                                <button class="btn-user-action btn-delete"
                                    onclick="deleteUser(<?= $user['id'] ?>, '<?= htmlspecialchars($fullName, ENT_QUOTES) ?>')">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="svc-no-results" id="no-results" style="display:none;">
            <p>No users found matching your search.</p>
        </div>

    </main>
</div>

<!-- VIEW USER MODAL -->
<div class="svc-modal-overlay" id="user-modal-overlay">
    <div class="svc-modal-box">

        <div class="svc-modal-header">
            <div class="svc-modal-header-left">
                <div class="svc-modal-icon user-modal-avatar" id="user-modal-avatar">US</div>
                <div>
                    <h3 class="svc-modal-title" id="user-modal-name">User Details</h3>
                    <p class="svc-modal-subtitle" id="user-modal-email">—</p>
                </div>
            </div>
            <button class="svc-modal-close" onclick="closeUserModal()">×</button>
        </div>

        <div class="svc-modal-summary">
            <div class="svc-summary-item">
                <span class="svc-summary-label">Role</span>
                <span class="svc-summary-value" id="user-modal-role">—</span>
            </div>
            <div class="svc-summary-item">
                <span class="svc-summary-label">Gender</span>
                <span class="svc-summary-value" id="user-modal-gender">—</span>
            </div>
            <div class="svc-summary-item">
                <span class="svc-summary-label">Status</span>
                <span class="svc-summary-value" id="user-modal-status">—</span>
            </div>
        </div>

        <div class="svc-modal-body">
            <div class="svc-form-row">
                <div class="svc-form-group">
                    <label class="svc-label">Age</label>
                    <p id="user-modal-age" class="user-detail-val"></p>
                </div>
                <div class="svc-form-group">
                    <label class="svc-label">Date Joined</label>
                    <p id="user-modal-joined" class="user-detail-val"></p>
                </div>
            </div>
            <div class="svc-form-group">
                <label class="svc-label">User ID</label>
                <p id="user-modal-id" class="user-detail-val"></p>
            </div>
            <div class="svc-form-group">
                <label class="svc-label">Change Role</label>
                <select class="svc-select-input" id="user-modal-role-select">
                    <option value="admin">🛡️ Admin</option>
                    <option value="moderator">🔧 Moderator</option>
                    <option value="sk_officer">⭐ SK Officer</option>
                    <option value="resident">👤 Resident</option>
                </select>
                <span class="svc-field-hint">Changing role will update access permissions immediately.</span>
            </div>
        </div>

        <div class="svc-modal-footer">
            <button class="btn-svc-secondary"                 onclick="closeUserModal()">Close</button>
            <button class="btn-svc-primary"                   onclick="saveUserRole()">💾 Save Role</button>
            <button class="btn-svc-primary btn-svc-approve"   id="user-modal-toggle"  onclick="toggleFromModal()">🚫 Deactivate</button>
            <button class="btn-svc-danger btn-svc-primary"    onclick="deleteFromModal()" style="background:var(--ap-danger); color:white; border:none;">🗑️ Delete</button>
        </div>

    </div>
</div>

<script src="../../../scripts/management/admin/admin_manage_users.js"></script>
</body>
</html>