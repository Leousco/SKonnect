<?php  
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect Admin | Settings</title>
    <link rel="stylesheet" href="../../../styles/management/admin/admin_settings.css">
    <link rel="stylesheet" href="../../../styles/management/mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_topbar.css">
</head>
<body>

<div class="admin-layout">

    <?php include __DIR__ . '/../../../components/management/admin/admin_sidebar.php'; ?>

    <main class="admin-content">

    <?php
        $pageTitle      = 'Settings';
        $pageBreadcrumb = [['Home', '#'], ['Settings', null]];
        $adminName      = $_SESSION['user_name'] ?? 'Admin';
        $adminRole      = 'System Admin';
        $notifCount     = 7;
        include __DIR__ . '/../../../components/management/admin/admin_topbar.php';
    ?>

        <!-- SETTINGS TABS NAV -->
        <div class="settings-shell">

            <aside class="settings-sidebar">
                <nav class="settings-nav" aria-label="Settings sections">

                    <div class="snav-group">
                        <span class="snav-group-label">System</span>
                        <button class="snav-item active" data-tab="system-info">
                            <span class="snav-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="3" width="20" height="14" rx="2"/>
                                    <path d="M8 21h8M12 17v4"/>
                                </svg>
                            </span>
                            System Information
                        </button>
                        <button class="snav-item" data-tab="branding">
                            <span class="snav-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M12 8v4l3 3"/>
                                </svg>
                            </span>
                            Branding &amp; Logo
                        </button>
                        <button class="snav-item" data-tab="barangay">
                            <span class="snav-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                    <polyline points="9 22 9 12 15 12 15 22"/>
                                </svg>
                            </span>
                            Barangay Info
                        </button>
                    </div>

                    <div class="snav-group">
                        <span class="snav-group-label">Account</span>
                        <button class="snav-item" data-tab="admin-info">
                            <span class="snav-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </span>
                            Admin Profile
                        </button>
                        <button class="snav-item" data-tab="password">
                            <span class="snav-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                            </span>
                            Change Password
                        </button>
                    </div>

                </nav>
            </aside>

            <!-- SETTINGS PANELS -->
            <div class="settings-panels">

                <!-- ── 1. SYSTEM INFORMATION ────────────────── -->
                <section class="settings-panel active" id="tab-system-info">
                    <div class="panel-head">
                        <div class="panel-head-icon panel-head-icon--violet">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="3" width="20" height="14" rx="2"/>
                                <path d="M8 21h8M12 17v4"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="panel-title">System Information</h2>
                            <p class="panel-desc">Configure the core identity of your SKonnect platform.</p>
                        </div>
                    </div>

                    <form class="settings-form" id="form-system-info" novalidate>
                        <div class="form-grid form-grid--2">
                            <div class="form-field form-field--full">
                                <label class="field-label" for="sys-name">System Name <span class="req">*</span></label>
                                <input class="field-input" type="text" id="sys-name" name="sys_name"
                                       value="SKonnect" placeholder="e.g. SKonnect" required>
                                <span class="field-hint">The name shown in browser tabs, emails, and headers.</span>
                            </div>

                            <div class="form-field">
                                <label class="field-label" for="sys-version">System Version</label>
                                <input class="field-input" type="text" id="sys-version" name="sys_version"
                                       value="1.0.0" placeholder="e.g. 1.0.0" readonly>
                                <span class="field-hint">Auto-managed by the system.</span>
                            </div>

                            <div class="form-field">
                                <label class="field-label" for="sys-email">System Email</label>
                                <input class="field-input" type="email" id="sys-email" name="sys_email"
                                       value="" placeholder="noreply@skonnect.gov.ph">
                                <span class="field-hint">Used for automated notifications.</span>
                            </div>

                            <div class="form-field form-field--full">
                                <label class="field-label" for="sys-tagline">Tagline / Motto</label>
                                <input class="field-input" type="text" id="sys-tagline" name="sys_tagline"
                                       value="" placeholder="Empowering the Youth of Barangay...">
                                <span class="field-hint">Displayed on login pages and public-facing areas.</span>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-settings-secondary" onclick="resetForm('form-system-info')">Reset</button>
                            <button type="submit" class="btn-settings-primary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </section>

                <!-- ── 2. BRANDING & LOGO ───────────────────── -->
                <section class="settings-panel" id="tab-branding">
                    <div class="panel-head">
                        <div class="panel-head-icon panel-head-icon--amber">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 8v4l3 3"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="panel-title">Branding &amp; Logo</h2>
                            <p class="panel-desc">Manage the visual identity of your SKonnect platform.</p>
                        </div>
                    </div>

                    <form class="settings-form" id="form-branding" novalidate>

                        <!-- Logo upload -->
                        <div class="form-field">
                            <label class="field-label">System Logo</label>
                            <div class="logo-upload-area" id="logo-drop-zone">
                                <div class="logo-preview-wrap" id="logo-preview-wrap">
                                    <div class="logo-placeholder" id="logo-placeholder">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                            <polyline points="21 15 16 10 5 21"/>
                                        </svg>
                                    </div>
                                    <img id="logo-img-preview" src="" alt="Logo preview" style="display:none;">
                                </div>
                                <div class="logo-upload-info">
                                    <p class="logo-upload-title">Drag &amp; drop your logo here</p>
                                    <p class="logo-upload-sub">PNG, JPG, SVG · Recommended 200×200 px · Max 2 MB</p>
                                    <label class="btn-settings-secondary btn-file-pick" for="logo-file-input">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                        Choose File
                                    </label>
                                    <input type="file" id="logo-file-input" name="logo" accept="image/*" style="display:none;">
                                    <button type="button" class="btn-logo-remove" id="btn-logo-remove" style="display:none;">Remove</button>
                                </div>
                            </div>
                            <span class="field-hint">The logo appears in the sidebar header and emails.</span>
                        </div>

                        <!-- Favicon upload -->
                        <div class="form-field" style="margin-top:22px;">
                            <label class="field-label">Favicon</label>
                            <div class="favicon-row">
                                <div class="favicon-preview" id="favicon-preview">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <polyline points="21 15 16 10 5 21"/>
                                    </svg>
                                </div>
                                <div>
                                    <label class="btn-settings-secondary btn-file-pick" for="favicon-file-input" style="display:inline-flex;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                        Upload Favicon
                                    </label>
                                    <input type="file" id="favicon-file-input" name="favicon" accept="image/x-icon,image/png" style="display:none;">
                                    <p class="field-hint" style="margin-top:6px;">ICO or PNG · 32×32 px recommended.</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-settings-secondary">Reset to Default</button>
                            <button type="submit" class="btn-settings-primary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </section>

                <!-- ── 3. BARANGAY INFO ─────────────────────── -->
                <section class="settings-panel" id="tab-barangay">
                    <div class="panel-head">
                        <div class="panel-head-icon panel-head-icon--teal">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="panel-title">Barangay Information</h2>
                            <p class="panel-desc">Details about your Sangguniang Kabataan's barangay.</p>
                        </div>
                    </div>

                    <form class="settings-form" id="form-barangay" novalidate>
                        <div class="form-grid form-grid--2">
                            <div class="form-field form-field--full">
                                <label class="field-label" for="brgy-name">Barangay Name <span class="req">*</span></label>
                                <input class="field-input" type="text" id="brgy-name" name="brgy_name"
                                       value="" placeholder="e.g. Barangay San Isidro" required>
                            </div>

                            <div class="form-field">
                                <label class="field-label" for="brgy-municipality">Municipality / City <span class="req">*</span></label>
                                <input class="field-input" type="text" id="brgy-municipality" name="brgy_municipality"
                                       value="" placeholder="e.g. Quezon City" required>
                            </div>

                            <div class="form-field">
                                <label class="field-label" for="brgy-province">Province / Region</label>
                                <input class="field-input" type="text" id="brgy-province" name="brgy_province"
                                       value="" placeholder="e.g. Metro Manila">
                            </div>

                            <div class="form-field">
                                <label class="field-label" for="brgy-contact">Contact Number</label>
                                <input class="field-input" type="tel" id="brgy-contact" name="brgy_contact"
                                       value="" placeholder="+63 9XX XXX XXXX">
                            </div>

                            <div class="form-field">
                                <label class="field-label" for="brgy-email">Barangay Email</label>
                                <input class="field-input" type="email" id="brgy-email" name="brgy_email"
                                       value="" placeholder="brgy@example.gov.ph">
                            </div>

                            <div class="form-field form-field--full">
                                <label class="field-label" for="brgy-address">Full Address</label>
                                <textarea class="field-input field-textarea" id="brgy-address" name="brgy_address"
                                          rows="3" placeholder="Street, Barangay, City, Province, ZIP Code"></textarea>
                            </div>

                            <div class="form-field form-field--full">
                                <label class="field-label" for="brgy-about">About / Description</label>
                                <textarea class="field-input field-textarea" id="brgy-about" name="brgy_about"
                                          rows="4" placeholder="Short description of the barangay and the SK chapter..."></textarea>
                                <span class="field-hint">Shown on the public landing page.</span>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-settings-secondary" onclick="resetForm('form-barangay')">Reset</button>
                            <button type="submit" class="btn-settings-primary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </section>

                <!-- ── 4. ADMIN PROFILE ────────────────────── -->
                <section class="settings-panel" id="tab-admin-info">
                    <div class="panel-head">
                        <div class="panel-head-icon panel-head-icon--indigo">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="panel-title">Admin Profile</h2>
                            <p class="panel-desc">Update your personal administrator information.</p>
                        </div>
                    </div>

                    <form class="settings-form" id="form-admin-info" novalidate>

                        <!-- Avatar -->
                        <div class="form-field">
                            <label class="field-label">Profile Photo</label>
                            <div class="avatar-row">
                                <div class="avatar-circle" id="avatar-preview-circle">
                                    <span class="avatar-initials" id="avatar-initials">
                                        <?= strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 2)) ?>
                                    </span>
                                    <img id="avatar-img" src="" alt="" style="display:none; width:100%; height:100%; object-fit:cover; border-radius:50%;">
                                </div>
                                <div class="avatar-actions">
                                    <label class="btn-settings-secondary btn-file-pick" for="avatar-file-input">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                        Upload Photo
                                    </label>
                                    <input type="file" id="avatar-file-input" name="avatar" accept="image/*" style="display:none;">
                                    <button type="button" class="btn-avatar-remove" id="btn-avatar-remove" style="display:none;">Remove</button>
                                    <p class="field-hint" style="margin-top:4px;">JPG, PNG · Max 2 MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-grid form-grid--2" style="margin-top:20px;">
                            <div class="form-field">
                                <label class="field-label" for="admin-fname">First Name <span class="req">*</span></label>
                                <input class="field-input" type="text" id="admin-fname" name="first_name"
                                       value="<?= htmlspecialchars(explode(' ', $_SESSION['user_name'] ?? '')[0]) ?>" required>
                            </div>

                            <div class="form-field">
                                <label class="field-label" for="admin-lname">Last Name <span class="req">*</span></label>
                                <input class="field-input" type="text" id="admin-lname" name="last_name"
                                       value="<?= htmlspecialchars(explode(' ', $_SESSION['user_name'] ?? '')[1] ?? '') ?>" required>
                            </div>

                            <div class="form-field form-field--full">
                                <label class="field-label" for="admin-email">Email Address <span class="req">*</span></label>
                                <input class="field-input" type="email" id="admin-email" name="email"
                                       value="" placeholder="admin@skonnect.gov.ph" required>
                            </div>

                            <div class="form-field">
                                <label class="field-label" for="admin-phone">Phone Number</label>
                                <input class="field-input" type="tel" id="admin-phone" name="phone"
                                       value="" placeholder="+63 9XX XXX XXXX">
                            </div>

                            <div class="form-field">
                                <label class="field-label" for="admin-position">Position / Title</label>
                                <input class="field-input" type="text" id="admin-position" name="position"
                                       value="System Admin" placeholder="e.g. SK Chairperson">
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-settings-secondary" onclick="resetForm('form-admin-info')">Reset</button>
                            <button type="submit" class="btn-settings-primary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </section>

                <!-- ── 5. CHANGE PASSWORD ──────────────────── -->
                <section class="settings-panel" id="tab-password">
                    <div class="panel-head">
                        <div class="panel-head-icon panel-head-icon--red">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="panel-title">Change Password</h2>
                            <p class="panel-desc">Keep your account secure with a strong, unique password.</p>
                        </div>
                    </div>

                    <!-- Password strength tips -->
                    <div class="pw-tips-box">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        <p>Use at least <strong>8 characters</strong> with a mix of uppercase, lowercase, numbers, and symbols.</p>
                    </div>

                    <form class="settings-form" id="form-password" novalidate autocomplete="off">
                        <div class="form-grid form-grid--1">

                            <div class="form-field">
                                <label class="field-label" for="pw-current">Current Password <span class="req">*</span></label>
                                <div class="pw-input-wrap">
                                    <input class="field-input" type="password" id="pw-current" name="current_password"
                                           placeholder="Enter your current password" required autocomplete="current-password">
                                    <button type="button" class="pw-toggle" data-target="pw-current" aria-label="Toggle visibility">
                                        <svg class="eye-icon eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        <svg class="eye-icon eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="form-field">
                                <label class="field-label" for="pw-new">New Password <span class="req">*</span></label>
                                <div class="pw-input-wrap">
                                    <input class="field-input" type="password" id="pw-new" name="new_password"
                                           placeholder="Enter your new password" required autocomplete="new-password">
                                    <button type="button" class="pw-toggle" data-target="pw-new" aria-label="Toggle visibility">
                                        <svg class="eye-icon eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        <svg class="eye-icon eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                    </button>
                                </div>
                                <!-- Strength meter -->
                                <div class="pw-strength-wrap" id="pw-strength-wrap" style="display:none;">
                                    <div class="pw-strength-bar">
                                        <div class="pw-strength-fill" id="pw-strength-fill"></div>
                                    </div>
                                    <span class="pw-strength-label" id="pw-strength-label">Weak</span>
                                </div>
                                <ul class="pw-checklist" id="pw-checklist">
                                    <li class="pw-check" id="chk-len">At least 8 characters</li>
                                    <li class="pw-check" id="chk-upper">One uppercase letter</li>
                                    <li class="pw-check" id="chk-number">One number</li>
                                    <li class="pw-check" id="chk-symbol">One symbol (!@#$…)</li>
                                </ul>
                            </div>

                            <div class="form-field">
                                <label class="field-label" for="pw-confirm">Confirm New Password <span class="req">*</span></label>
                                <div class="pw-input-wrap">
                                    <input class="field-input" type="password" id="pw-confirm" name="confirm_password"
                                           placeholder="Re-enter your new password" required autocomplete="new-password">
                                    <button type="button" class="pw-toggle" data-target="pw-confirm" aria-label="Toggle visibility">
                                        <svg class="eye-icon eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        <svg class="eye-icon eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                    </button>
                                </div>
                                <span class="pw-match-msg" id="pw-match-msg" style="display:none;"></span>
                            </div>

                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-settings-secondary" onclick="resetForm('form-password')">Clear</button>
                            <button type="submit" class="btn-settings-primary btn-settings-primary--red">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Update Password
                            </button>
                        </div>
                    </form>
                </section>

            </div><!-- /.settings-panels -->
        </div><!-- /.settings-shell -->

        <!-- TOAST NOTIFICATION -->
        <div class="settings-toast" id="settings-toast" role="alert" aria-live="polite">
            <span class="toast-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </span>
            <span class="toast-msg" id="toast-msg">Settings saved successfully.</span>
        </div>

    </main>
</div>

<script src="../../../scripts/management/admin/admin_sidebar.js"></script>
<script src="../../../scripts/management/admin/admin_settings.js"></script>

</body>
</html>