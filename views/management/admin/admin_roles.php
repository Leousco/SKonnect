<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Roles</title>
    <link rel="stylesheet" href="../../../styles/management/admin/admin_dashboard.css">
    <link rel="stylesheet" href="../../../styles/management/mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_topbar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_manage_services.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_users.css">
</head>
<body>

<div class="admin-layout">

    <?php include __DIR__ . '/../../../components/management/admin/admin_sidebar.php'; ?>

    <main class="admin-content">

        <?php
        $pageTitle      = 'Roles Management';
        $pageBreadcrumb = [['Home', '#'], ['Users', '#'], ['Roles', null]];
        $adminName      = $_SESSION['user_name'] ?? 'Admin';
        $adminRole      = 'System Admin';
        $notifCount     = 7;
        include __DIR__ . '/../../../components/management/admin/admin_topbar.php';
        ?>

        <?php
        $roles = [
            [
                'role'        => 'admin',
                'label'       => '🛡️ Admin',
                'color'       => 'role-admin',
                'count'       => 1,
                'description' => 'Full access to all system features. Can manage users, content, settings, and roles.',
                'permissions' => [
                    'View all pages'             => true,
                    'Manage Users'               => true,
                    'Assign Roles'               => true,
                    'Manage Services'            => true,
                    'Approve Service Requests'   => true,
                    'Manage Announcements'       => true,
                    'Moderate Threads'           => true,
                    'Handle Reports'             => true,
                    'View Analytics'             => true,
                    'Access Activity Logs'       => true,
                    'System Settings'            => true,
                ],
            ],
            [
                'role'        => 'moderator',
                'label'       => '🔧 Moderator',
                'color'       => 'role-moderator',
                'count'       => 1,
                'description' => 'Manages community content. Can moderate threads, handle reports, and post announcements.',
                'permissions' => [
                    'View all pages'             => false,
                    'Manage Users'               => false,
                    'Assign Roles'               => false,
                    'Manage Services'            => false,
                    'Approve Service Requests'   => false,
                    'Manage Announcements'       => true,
                    'Moderate Threads'           => true,
                    'Handle Reports'             => true,
                    'View Analytics'             => true,
                    'Access Activity Logs'       => false,
                    'System Settings'            => false,
                ],
            ],
            [
                'role'        => 'sk_officer',
                'label'       => '⭐ SK Officer',
                'color'       => 'role-officer',
                'count'       => 1,
                'description' => 'Handles service requests and community concerns. Can approve/reject service applications.',
                'permissions' => [
                    'View all pages'             => false,
                    'Manage Users'               => false,
                    'Assign Roles'               => false,
                    'Manage Services'            => true,
                    'Approve Service Requests'   => true,
                    'Manage Announcements'       => true,
                    'Moderate Threads'           => false,
                    'Handle Reports'             => false,
                    'View Analytics'             => true,
                    'Access Activity Logs'       => false,
                    'System Settings'            => false,
                ],
            ],
            [
                'role'        => 'resident',
                'label'       => '👤 Resident',
                'color'       => 'role-resident',
                'count'       => 2,
                'description' => 'Regular youth resident. Can view content, submit service requests, and post threads.',
                'permissions' => [
                    'View all pages'             => false,
                    'Manage Users'               => false,
                    'Assign Roles'               => false,
                    'Manage Services'            => false,
                    'Approve Service Requests'   => false,
                    'Manage Announcements'       => false,
                    'Moderate Threads'           => false,
                    'Handle Reports'             => false,
                    'View Analytics'             => false,
                    'Access Activity Logs'       => false,
                    'System Settings'            => false,
                ],
            ],
        ];

        $users = [
            ['id' => 12, 'first_name' => 'Rey',      'last_name' => 'Santos',  'email' => 'admin@skonnect.com',      'role' => 'admin'],
            ['id' => 13, 'first_name' => 'Maya',     'last_name' => 'Reyes',   'email' => 'moderator@skonnect.com',  'role' => 'moderator'],
            ['id' => 14, 'first_name' => 'Carlo',    'last_name' => 'Mendoza', 'email' => 'officer@skonnect.com',    'role' => 'sk_officer'],
            ['id' => 16, 'first_name' => 'Bico',     'last_name' => 'Sico',    'email' => 'lvillete778@gmail.com',   'role' => 'resident'],
            ['id' => 17, 'first_name' => 'Leonardo', 'last_name' => 'Da Bink', 'email' => 'leovillete878@gmail.com', 'role' => 'resident'],
        ];
        ?>

        <!-- Stats Strip -->
        <div class="svc-stats-strip" style="margin-bottom:28px;">
            <?php foreach ($roles as $r): ?>
            <div class="svc-stat-pill">
                <span class="svc-stat-num"><?= $r['count'] ?></span>
                <span><?= $r['label'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Roles Grid -->
        <p class="svc-section-label">Role Permissions Overview</p>
        <div class="roles-grid" id="roles-grid">
            <?php foreach ($roles as $role): ?>
            <div class="role-card">
                <div class="role-card-header <?= $role['color'] ?>-header">
                    <div class="role-card-title-row">
                        <span class="user-role-badge <?= $role['color'] ?>"><?= $role['label'] ?></span>
                        <span class="role-user-count"><?= $role['count'] ?> user<?= $role['count'] !== 1 ? 's' : '' ?></span>
                    </div>
                    <p class="role-description"><?= htmlspecialchars($role['description']) ?></p>
                </div>
                <div class="role-card-body">
                    <p class="role-perms-label">Permissions</p>
                    <ul class="role-perms-list">
                        <?php foreach ($role['permissions'] as $perm => $allowed): ?>
                        <li class="role-perm-item <?= $allowed ? 'perm-allowed' : 'perm-denied' ?>">
                            <span class="perm-icon"><?= $allowed ? '✅' : '❌' ?></span>
                            <span><?= $perm ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Assign Roles Section -->
        <p class="svc-section-label" style="margin-top:32px;">Assign / Change User Roles</p>
        <div class="user-table-wrap">
            <table class="user-table" id="assign-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Current Role</th>
                        <th>Assign New Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user):
                        $initials = strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1));
                        $fullName = $user['first_name'] . ' ' . $user['last_name'];
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
                    ?>
                    <tr>
                        <td>
                            <div class="user-name-cell">
                                <div class="user-avatar role-avatar-<?= $user['role'] ?>"><?= $initials ?></div>
                                <span class="user-fullname"><?= htmlspecialchars($fullName) ?></span>
                            </div>
                        </td>
                        <td class="user-email"><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <span class="user-role-badge <?= $roleColors[$user['role']] ?>">
                                <?= $roleLabels[$user['role']] ?>
                            </span>
                        </td>
                        <td>
                            <select class="svc-select-input role-select" id="role-select-<?= $user['id'] ?>" style="width:100%;">
                                <option value="admin"      <?= $user['role'] === 'admin'      ? 'selected' : '' ?>>🛡️ Admin</option>
                                <option value="moderator"  <?= $user['role'] === 'moderator'  ? 'selected' : '' ?>>🔧 Moderator</option>
                                <option value="sk_officer" <?= $user['role'] === 'sk_officer' ? 'selected' : '' ?>>⭐ SK Officer</option>
                                <option value="resident"   <?= $user['role'] === 'resident'   ? 'selected' : '' ?>>👤 Resident</option>
                            </select>
                        </td>
                        <td>
                            <button class="btn-user-action btn-view"
                                onclick="assignRole(<?= $user['id'] ?>, '<?= htmlspecialchars($fullName, ENT_QUOTES) ?>')">
                                💾 Save
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </main>
</div>

<script src="../../../scripts/management/admin/admin_roles.js"></script>
<script src="../../../scripts/management/admin/admin_sidebar.js"></script>
</body>
</html>