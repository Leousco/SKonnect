<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Roles</title>
    <link rel="stylesheet" href="../../../styles/management/admin/admin_roles.css">
    <link rel="stylesheet" href="../../../styles/management/mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_topbar.css">
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
        /* ── Role card definitions (static — permissions don't change) ── */
        $roles = [
            [
                'role'        => 'admin',
                'label'       => '🛡️ Admin',
                'color'       => 'role-admin',
                'description' => 'Full access to all system features. Can manage users, content, settings, and roles.',
                'permissions' => [
                    'View all pages'           => true,
                    'Manage Users'             => true,
                    'Assign Roles'             => true,
                    'Manage Services'          => true,
                    'Approve Service Requests' => true,
                    'Manage Announcements'     => true,
                    'Moderate Threads'         => true,
                    'Handle Reports'           => true,
                    'View Analytics'           => true,
                    'Access Activity Logs'     => true,
                    'System Settings'          => true,
                ],
            ],
            [
                'role'        => 'moderator',
                'label'       => '🔧 Moderator',
                'color'       => 'role-moderator',
                'description' => 'Manages community content. Can moderate threads, handle reports, and post announcements.',
                'permissions' => [
                    'View all pages'           => false,
                    'Manage Users'             => false,
                    'Assign Roles'             => false,
                    'Manage Services'          => false,
                    'Approve Service Requests' => false,
                    'Manage Announcements'     => true,
                    'Moderate Threads'         => true,
                    'Handle Reports'           => true,
                    'View Analytics'           => true,
                    'Access Activity Logs'     => false,
                    'System Settings'          => false,
                ],
            ],
            [
                'role'        => 'sk_officer',
                'label'       => '⭐ SK Officer',
                'color'       => 'role-officer',
                'description' => 'Handles service requests and community concerns. Can approve/reject service applications.',
                'permissions' => [
                    'View all pages'           => false,
                    'Manage Users'             => false,
                    'Assign Roles'             => false,
                    'Manage Services'          => true,
                    'Approve Service Requests' => true,
                    'Manage Announcements'     => true,
                    'Moderate Threads'         => false,
                    'Handle Reports'           => false,
                    'View Analytics'           => true,
                    'Access Activity Logs'     => false,
                    'System Settings'          => false,
                ],
            ],
            [
                'role'        => 'resident',
                'label'       => '👤 Resident',
                'color'       => 'role-resident',
                'description' => 'Regular youth resident. Can view content, submit service requests, and post threads.',
                'permissions' => [
                    'View all pages'           => false,
                    'Manage Users'             => false,
                    'Assign Roles'             => false,
                    'Manage Services'          => false,
                    'Approve Service Requests' => false,
                    'Manage Announcements'     => false,
                    'Moderate Threads'         => false,
                    'Handle Reports'           => false,
                    'View Analytics'           => false,
                    'Access Activity Logs'     => false,
                    'System Settings'          => false,
                ],
            ],
        ];
        ?>

        <!-- Stats Strip — counts populated by JS -->
        <div class="svc-stats-strip">
            <?php foreach ($roles as $r): ?>
            <div class="svc-stat-pill">
                <span class="svc-stat-num">—</span>
                <span><?= $r['label'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Roles Grid — permissions are static, counts updated by JS -->
        <p class="svc-section-label">Role Permissions Overview</p>
        <div class="roles-grid" id="roles-grid">
            <?php foreach ($roles as $role): ?>
            <div class="role-card">
                <div class="role-card-header <?= $role['color'] ?>-header">
                    <div class="role-card-title-row">
                        <span class="user-role-badge <?= $role['color'] ?>"><?= $role['label'] ?></span>
                        <span class="role-user-count" id="count-<?= $role['role'] ?>">— users</span>
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

        <!-- Assign Roles Section — rows populated by JS -->
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
                    <tr>
                        <td colspan="5" style="text-align:center; padding:2rem;
                            color:var(--ap-text-muted); font-family:'Poppins',sans-serif; font-size:13px;">
                            Loading users…
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>
</div>

<script src="../../../scripts/management/admin/admin_roles.js"></script>
</body>
</html>