<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireAdmin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Manage Users</title>
    <link rel="stylesheet" href="../../../styles/management/mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_topbar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_manage_users.css">
</head>
<body>
<div class="admin-layout">

    <?php include __DIR__ . '/../../../components/management/admin/admin_sidebar.php'; ?>

    <main class="admin-content">
        <?php
        $pageTitle      = 'Manage Users';
        $pageBreadcrumb = [['Home', '#'], ['Users', '#'], ['User Management', null]];
        $adminName      = $_SESSION['user_name'] ?? 'Admin';
        $adminRole      = 'System Admin';
        $notifCount     = 7;
        include __DIR__ . '/../../../components/management/admin/admin_topbar.php';
        ?>

        <div class="svc-controls">
            <div class="svc-controls-left">
                <div class="svc-search-wrap">
                    <span class="svc-search-icon">🔍</span>
                    <input type="text" id="user-search" class="svc-search-input" placeholder="Search by name or email…">
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
                    <option value="other">Other</option>
                </select>
                <select id="user-verified" class="svc-select">
                    <option value="all">All Status</option>
                    <option value="1">Verified</option>
                    <option value="0">Unverified</option>
                </select>
            </div>
            <div class="svc-controls-right">
                <button id="btn-add-user" class="btn-svc-primary btn-svc-approve">➕ Add User</button>
            </div>
        </div>

        <div class="svc-stats-strip">
            <div class="svc-stat-pill">
                <span class="svc-stat-num" data-stat="total">—</span>
                <span>Total Users</span>
            </div>
            <div class="svc-stat-pill stat-approved">
                <span class="svc-stat-num" data-stat="verified">—</span>
                <span>Verified</span>
            </div>
            <div class="svc-stat-pill">
                <span class="svc-stat-num" data-stat="admin">—</span>
                <span>🔑 Admins</span>
            </div>
            <div class="svc-stat-pill">
                <span class="svc-stat-num" data-stat="moderator">—</span>
                <span>💬 Moderators</span>
            </div>
            <div class="svc-stat-pill">
                <span class="svc-stat-num" data-stat="sk_officer">—</span>
                <span>🌟 SK Officers</span>
            </div>
            <div class="svc-stat-pill">
                <span class="svc-stat-num" data-stat="resident">—</span>
                <span>👤 Residents</span>
            </div>
        </div>

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
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="user-tbody">
                    <tr><td colspan="8" class="mu-loading-row">Loading users…</td></tr>
                </tbody>
            </table>
        </div>

        <div class="svc-no-results" id="no-results" style="display:none;">
            <p>No users found matching your search.</p>
        </div>
    </main>
</div>

<!-- ADD USER MODAL -->
<div class="svc-modal-overlay" id="add-user-modal-overlay">
    <div class="svc-modal-box">
        <div class="svc-modal-header">
            <div class="svc-modal-header-left">
                <div class="svc-modal-icon mu-icon-success">➕</div>
                <div>
                    <h3 class="svc-modal-title">Add New User</h3>
                    <p class="svc-modal-subtitle">Fill in the details to create an account.</p>
                </div>
            </div>
            <button class="svc-modal-close" id="add-user-close">×</button>
        </div>
        <div class="svc-modal-body">
            <form id="add-user-form" onsubmit="return false;">
                <div class="svc-form-row">
                    <div class="svc-form-group">
                        <label class="svc-label">First Name <span class="mu-required">*</span></label>
                        <input type="text" id="add-first-name" class="svc-select-input" placeholder="Juan">
                    </div>
                    <div class="svc-form-group">
                        <label class="svc-label">Last Name <span class="mu-required">*</span></label>
                        <input type="text" id="add-last-name" class="svc-select-input" placeholder="Dela Cruz">
                    </div>
                </div>
                <div class="svc-form-group">
                    <label class="svc-label">Middle Name</label>
                    <input type="text" id="add-middle-name" class="svc-select-input" placeholder="Optional">
                </div>
                <div class="svc-form-row">
                    <div class="svc-form-group">
                        <label class="svc-label">Email <span class="mu-required">*</span></label>
                        <input type="email" id="add-email" class="svc-select-input" placeholder="user@email.com">
                    </div>
                    <div class="svc-form-group">
                        <label class="svc-label">Password <span class="mu-required">*</span></label>
                        <input type="password" id="add-password" class="svc-select-input" placeholder="Min. 8 characters">
                    </div>
                </div>
                <div class="svc-form-row">
                    <div class="svc-form-group">
                        <label class="svc-label">Role <span class="mu-required">*</span></label>
                        <select id="add-role" class="svc-select-input">
                            <option value="">Select role…</option>
                            <option value="admin">🔑 Admin</option>
                            <option value="moderator">💬 Moderator</option>
                            <option value="sk_officer">🌟 SK Officer</option>
                            <option value="resident">👤 Resident</option>
                        </select>
                    </div>
                    <div class="svc-form-group">
                        <label class="svc-label">Gender <span class="mu-required">*</span></label>
                        <select id="add-gender" class="svc-select-input">
                            <option value="">Select gender…</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="svc-form-group">
                    <label class="svc-label">Birth Date <span class="mu-required">*</span></label>
                    <input type="date" id="add-birth-date" class="svc-select-input">
                </div>
            </form>
        </div>
        <div class="svc-modal-footer">
            <button class="btn-svc-secondary" id="add-user-cancel">Cancel</button>
            <button class="btn-svc-primary btn-svc-approve" id="add-user-submit">✅ Create User</button>
        </div>
    </div>
</div>

<!-- VIEW / EDIT USER MODAL -->
<div class="svc-modal-overlay" id="user-modal-overlay">
    <div class="svc-modal-box">
        <div class="svc-modal-header">
            <div class="svc-modal-header-left">
                <div class="svc-modal-icon" id="user-modal-avatar">US</div>
                <div>
                    <h3 class="svc-modal-title" id="user-modal-name">User Details</h3>
                    <p class="svc-modal-subtitle" id="user-modal-email-disp">—</p>
                </div>
            </div>
            <button class="svc-modal-close" id="user-modal-close">×</button>
        </div>

        <div class="svc-modal-summary">
            <div class="svc-summary-item">
                <span class="svc-summary-label">Role</span>
                <span class="svc-summary-value" id="user-modal-role-disp">—</span>
            </div>
            <div class="svc-summary-item">
                <span class="svc-summary-label">Gender</span>
                <span class="svc-summary-value" id="user-modal-gender-disp">—</span>
            </div>
            <div class="svc-summary-item">
                <span class="svc-summary-label">Status</span>
                <span class="svc-summary-value" id="user-modal-status-disp">—</span>
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
                    <option value="admin">🔑 Admin</option>
                    <option value="moderator">💬 Moderator</option>
                    <option value="sk_officer">🌟 SK Officer</option>
                    <option value="resident">👤 Resident</option>
                </select>
                <span class="svc-field-hint">Changing role updates access permissions immediately.</span>
            </div>

            <div class="mu-edit-toggle-wrap">
                <button class="btn-svc-secondary mu-btn-edit-toggle" id="btn-toggle-edit">✏️ Edit Info</button>
            </div>

            <div id="edit-section" class="mu-edit-section" style="display:none;">
                <div class="mu-edit-warning">
                    ⚠️ <strong>Warning:</strong> Editing a user's personal information is a sensitive action. Make sure the changes are correct before saving.
                </div>
                <div class="svc-form-row">
                    <div class="svc-form-group">
                        <label class="svc-label">First Name</label>
                        <input type="text" id="edit-first-name" class="svc-select-input">
                    </div>
                    <div class="svc-form-group">
                        <label class="svc-label">Last Name</label>
                        <input type="text" id="edit-last-name" class="svc-select-input">
                    </div>
                </div>
                <div class="svc-form-group">
                    <label class="svc-label">Middle Name</label>
                    <input type="text" id="edit-middle-name" class="svc-select-input">
                </div>
                <div class="svc-form-row">
                    <div class="svc-form-group">
                        <label class="svc-label">Email</label>
                        <input type="email" id="edit-email" class="svc-select-input">
                    </div>
                    <div class="svc-form-group">
                        <label class="svc-label">Gender</label>
                        <select id="edit-gender" class="svc-select-input">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="svc-form-group">
                    <label class="svc-label">Birth Date</label>
                    <input type="date" id="edit-birth-date" class="svc-select-input">
                </div>
                <button class="btn-svc-primary mu-btn-save-edit" id="btn-save-edit">💾 Save Changes</button>
            </div>
        </div>

        <div class="svc-modal-footer">
            <button class="btn-svc-primary" id="btn-save-role">💾 Save Role</button>
            <button class="btn-svc-primary btn-svc-warning" id="user-modal-toggle">🚫 Deactivate</button>
            <button class="btn-svc-primary btn-svc-danger" id="user-modal-ban">⛔ Ban User</button>
            <button class="btn-svc-primary btn-svc-delete" id="user-modal-delete">❌ Remove</button>
        </div>
    </div>
</div>

<script src="../../../scripts/management/admin/admin_manage_users.js"></script>
</body>
</html>