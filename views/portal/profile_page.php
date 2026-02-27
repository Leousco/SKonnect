<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Profile</title>

    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/portal/sidebar.css">
    <link rel="stylesheet" href="../../styles/portal/topbar.css">

    <link rel="stylesheet" href="../../styles/portal/profile_page.css">
</head>
<body>

<div class="dashboard-layout">

    <?php include __DIR__ . '/../../components/portal/sidebar.php'; ?>

    <main class="dashboard-content">

    <?php
    $pageTitle      = 'My Profile';
    $pageBreadcrumb = [['Home', '#'], ['Profile', null]];
    $userName       = 'Juan Dela Cruz';
    $userRole       = 'SK Member';
    $notifCount     = 3;
    include __DIR__ . '/../../components/portal/topbar.php';
    ?>

        <!-- PROFILE HERO CARD -->
        <section class="profile-hero-card">
            <div class="profile-hero-bg"></div>
            <div class="profile-hero-body">
                <div class="profile-avatar-wrap">
                    <div class="profile-avatar" id="profile-avatar">
                        <span class="profile-initials" id="profile-initials">JD</span>
                        <img src="" alt="" class="profile-avatar-img" id="profile-avatar-img" style="display:none;">
                    </div>
                    <button class="avatar-change-btn" id="avatar-change-btn" title="Change photo">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    </button>
                    <input type="file" id="avatar-file-input" accept="image/*" style="display:none;">
                </div>

                <div class="profile-hero-info">
                    <div class="profile-hero-name-row">
                        <h2 class="profile-hero-name" id="hero-fullname">Juan Dela Cruz</h2>
                        <span class="profile-role-badge">SK Member</span>
                        <span class="profile-verified-badge" title="Verified account">✓ Verified</span>
                    </div>
                    <p class="profile-hero-sub" id="hero-sub">Barangay Sauyo, Novaliches, Quezon City &nbsp;·&nbsp; Member since January 2025</p>
                    <div class="profile-hero-tags">
                        <span class="hero-tag">🗳️ Registered Voter</span>
                        <span class="hero-tag">🎓 Student</span>
                        <span class="hero-tag">📍 Purok 3</span>
                    </div>
                </div>

                <button class="btn-primary-portal profile-edit-trigger" id="profile-edit-trigger">
                    ✏️ Edit Profile
                </button>
            </div>
        </section>

        <!-- STAT WIDGETS -->
        <section class="dashboard-widgets" style="margin-top: 24px;">
            <div class="widget-card">
                <h3>Service Requests</h3>
                <p class="widget-number">5</p>
                <span class="widget-sub">Total submitted</span>
            </div>
            <div class="widget-card">
                <h3>Community Posts</h3>
                <p class="widget-number">4</p>
                <span class="widget-sub">Threads & concerns</span>
            </div>
            <div class="widget-card">
                <h3>Approved</h3>
                <p class="widget-number">2</p>
                <span class="widget-sub">Assistance received</span>
            </div>
            <div class="widget-card">
                <h3>Member Since</h3>
                <p class="widget-number" style="font-size:22px;">Jan '25</p>
                <span class="widget-sub">Portal member</span>
            </div>
        </section>

        <!-- TWO-COLUMN LOWER -->
        <div class="profile-lower">

            <!-- LEFT COL -->
            <div class="profile-left-col">

                <!-- PERSONAL INFORMATION -->
                <section class="profile-card" id="card-personal">
                    <div class="profile-card-header">
                        <h2 class="section-label">Personal Information</h2>
                        <button class="card-edit-btn" data-target="personal">✏️ Edit</button>
                    </div>
                    <div class="profile-fields" id="view-personal">
                        <div class="profile-field-row">
                            <span class="field-label">Full Name</span>
                            <span class="field-value" id="pf-fullname">Juan Dela Cruz</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">Date of Birth</span>
                            <span class="field-value" id="pf-dob">March 15, 2002</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">Age</span>
                            <span class="field-value" id="pf-age">23 years old</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">Sex</span>
                            <span class="field-value" id="pf-sex">Male</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">Civil Status</span>
                            <span class="field-value" id="pf-civil">Single</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">Nationality</span>
                            <span class="field-value" id="pf-nationality">Filipino</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">Religion</span>
                            <span class="field-value" id="pf-religion">Roman Catholic</span>
                        </div>
                    </div>

                    <!-- EDIT FORM (hidden by default) -->
                    <form class="profile-edit-form" id="form-personal" style="display:none;" novalidate>
                        <div class="form-row-half">
                            <div class="form-group">
                                <label class="modal-label">First Name <span class="required-star">*</span></label>
                                <input type="text" class="ann-search-input" id="e-firstname" value="Juan">
                                <span class="field-error" id="err-firstname"></span>
                            </div>
                            <div class="form-group">
                                <label class="modal-label">Last Name <span class="required-star">*</span></label>
                                <input type="text" class="ann-search-input" id="e-lastname" value="Dela Cruz">
                                <span class="field-error" id="err-lastname"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="modal-label">Middle Name</label>
                            <input type="text" class="ann-search-input" id="e-middlename" value="Santos">
                        </div>
                        <div class="form-row-half">
                            <div class="form-group">
                                <label class="modal-label">Date of Birth <span class="required-star">*</span></label>
                                <input type="date" class="ann-search-input" id="e-dob" value="2002-03-15">
                            </div>
                            <div class="form-group">
                                <label class="modal-label">Sex</label>
                                <select class="ann-select" id="e-sex" style="width:100%">
                                    <option value="Male" selected>Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Prefer not to say">Prefer not to say</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row-half">
                            <div class="form-group">
                                <label class="modal-label">Civil Status</label>
                                <select class="ann-select" id="e-civil" style="width:100%">
                                    <option value="Single" selected>Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="modal-label">Religion</label>
                                <input type="text" class="ann-search-input" id="e-religion" value="Roman Catholic">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-secondary-portal cancel-edit-btn" data-target="personal">Cancel</button>
                            <button type="button" class="btn-primary-portal save-edit-btn" data-target="personal">Save Changes</button>
                        </div>
                    </form>
                </section>

                <!-- CONTACT & ADDRESS -->
                <section class="profile-card" id="card-contact">
                    <div class="profile-card-header">
                        <h2 class="section-label">Contact & Address</h2>
                        <button class="card-edit-btn" data-target="contact">✏️ Edit</button>
                    </div>
                    <div class="profile-fields" id="view-contact">
                        <div class="profile-field-row">
                            <span class="field-label">Email Address</span>
                            <span class="field-value" id="pf-email">juandelacruz@email.com</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">Mobile Number</span>
                            <span class="field-value" id="pf-mobile">0917 123 4567</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">Purok / Zone</span>
                            <span class="field-value" id="pf-purok">Purok 3</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">Street Address</span>
                            <span class="field-value" id="pf-street">123 Sampaguita Street</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">Barangay</span>
                            <span class="field-value">Barangay Sauyo</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">City / Municipality</span>
                            <span class="field-value">Novaliches, Quezon City</span>
                        </div>
                    </div>

                    <form class="profile-edit-form" id="form-contact" style="display:none;" novalidate>
                        <div class="form-group">
                            <label class="modal-label">Email Address <span class="required-star">*</span></label>
                            <input type="email" class="ann-search-input" id="e-email" value="juandelacruz@email.com">
                            <span class="field-error" id="err-email"></span>
                        </div>
                        <div class="form-group">
                            <label class="modal-label">Mobile Number <span class="required-star">*</span></label>
                            <input type="tel" class="ann-search-input" id="e-mobile" value="0917 123 4567">
                            <span class="field-error" id="err-mobile"></span>
                        </div>
                        <div class="form-row-half">
                            <div class="form-group">
                                <label class="modal-label">Purok / Zone</label>
                                <input type="text" class="ann-search-input" id="e-purok" value="Purok 3">
                            </div>
                            <div class="form-group">
                                <label class="modal-label">Street Address</label>
                                <input type="text" class="ann-search-input" id="e-street" value="123 Sampaguita Street">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-secondary-portal cancel-edit-btn" data-target="contact">Cancel</button>
                            <button type="button" class="btn-primary-portal save-edit-btn" data-target="contact">Save Changes</button>
                        </div>
                    </form>
                </section>

                <!-- SK MEMBERSHIP INFO -->
                <section class="profile-card" id="card-membership">
                    <div class="profile-card-header">
                        <h2 class="section-label">SK Membership</h2>
                    </div>
                    <div class="profile-fields">
                        <div class="profile-field-row">
                            <span class="field-label">Member ID</span>
                            <span class="field-value mono">SKN-2025-00084</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">Date Joined</span>
                            <span class="field-value">January 10, 2025</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">Member Status</span>
                            <span class="field-value"><span class="req-status-badge status-approved">Active</span></span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">Registered Voter</span>
                            <span class="field-value"><span class="req-status-badge status-approved">Yes</span></span>
                        </div>
                        <!-- <div class="profile-field-row">
                            <span class="field-label">Precinct Number</span>
                            <span class="field-value mono">0123-A</span>
                        </div> -->
                        <div class="profile-field-row">
                            <span class="field-label">Educational Attainment</span>
                            <span class="field-value">College Level</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">School / Institution</span>
                            <span class="field-value">Quezon City University</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">Course / Strand</span>
                            <span class="field-value">BS Information Technology</span>
                        </div>
                        <div class="profile-field-row">
                            <span class="field-label">Employment Status</span>
                            <span class="field-value">Student</span>
                        </div>
                    </div>
                </section>

            </div>

            <!-- RIGHT COL -->
            <div class="profile-right-col">

                <!-- ACTIVITY SUMMARY -->
                <section class="profile-card">
                    <div class="profile-card-header">
                        <h2 class="section-label">Activity Summary</h2>
                    </div>

                    <div class="activity-summary-grid">
                        <div class="activity-summary-item">
                            <div class="act-icon act-icon-service">📋</div>
                            <div class="act-body">
                                <span class="act-label">Total Requests</span>
                                <span class="act-value">5</span>
                            </div>
                        </div>
                        <div class="activity-summary-item">
                            <div class="act-icon act-icon-approved">✅</div>
                            <div class="act-body">
                                <span class="act-label">Approved</span>
                                <span class="act-value">2</span>
                            </div>
                        </div>
                        <div class="activity-summary-item">
                            <div class="act-icon act-icon-pending">🔍</div>
                            <div class="act-body">
                                <span class="act-label">Pending / Review</span>
                                <span class="act-value">2</span>
                            </div>
                        </div>
                        <div class="activity-summary-item">
                            <div class="act-icon act-icon-rejected">❌</div>
                            <div class="act-body">
                                <span class="act-label">Rejected</span>
                                <span class="act-value">1</span>
                            </div>
                        </div>
                        <div class="activity-summary-item">
                            <div class="act-icon act-icon-thread">💬</div>
                            <div class="act-body">
                                <span class="act-label">Threads Posted</span>
                                <span class="act-value">4</span>
                            </div>
                        </div>
                        <div class="activity-summary-item">
                            <div class="act-icon act-icon-notif">🔔</div>
                            <div class="act-body">
                                <span class="act-label">Notifications</span>
                                <span class="act-value">14</span>
                            </div>
                        </div>
                    </div>

                    <!-- RECENT SERVICES -->
                    <h3 class="profile-sub-heading">Recent Service Requests</h3>
                    <ul class="profile-recent-list">
                        <li class="profile-recent-item">
                            <span class="profile-recent-icon">🏥</span>
                            <div class="profile-recent-body">
                                <span class="profile-recent-title">Medical Assistance</span>
                                <span class="profile-recent-meta">REQ-2026-0012 · Feb 10, 2026</span>
                            </div>
                            <span class="req-status-badge status-approved">Approved</span>
                        </li>
                        <li class="profile-recent-item">
                            <span class="profile-recent-icon">🏅</span>
                            <div class="profile-recent-body">
                                <span class="profile-recent-title">Scholarship Program</span>
                                <span class="profile-recent-meta">REQ-2026-0018 · Feb 14, 2026</span>
                            </div>
                            <span class="req-status-badge status-under-review">Under Review</span>
                        </li>
                        <li class="profile-recent-item">
                            <span class="profile-recent-icon">🎓</span>
                            <div class="profile-recent-body">
                                <span class="profile-recent-title">Educational Support</span>
                                <span class="profile-recent-meta">REQ-2026-0021 · Feb 19, 2026</span>
                            </div>
                            <span class="req-status-badge status-pending">Pending</span>
                        </li>
                    </ul>
                    <a href="my_requests_page.php" class="btn-small" style="margin-top: 4px;">View All Requests ›</a>
                </section>

                <!-- ACCOUNT SETTINGS -->
                <section class="profile-card" id="card-settings">
                    <div class="profile-card-header">
                        <h2 class="section-label">Account Settings</h2>
                    </div>

                    <!-- CHANGE PASSWORD -->
                    <div class="settings-block" id="block-password">
                        <div class="settings-block-header" id="toggle-password">
                            <div class="settings-block-left">
                                <div class="settings-icon">🔒</div>
                                <div>
                                    <strong>Change Password</strong>
                                    <p>Update your account password</p>
                                </div>
                            </div>
                            <svg class="settings-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                        <div class="settings-block-body" id="body-password" style="display:none;">
                            <form class="profile-edit-form" id="form-password" novalidate>
                                <div class="form-group">
                                    <label class="modal-label">Current Password <span class="required-star">*</span></label>
                                    <input type="password" class="ann-search-input" id="e-cur-pass" placeholder="Enter current password">
                                    <span class="field-error" id="err-cur-pass"></span>
                                </div>
                                <div class="form-group">
                                    <label class="modal-label">New Password <span class="required-star">*</span></label>
                                    <input type="password" class="ann-search-input" id="e-new-pass" placeholder="At least 8 characters">
                                    <span class="field-error" id="err-new-pass"></span>
                                </div>
                                <div class="form-group">
                                    <label class="modal-label">Confirm New Password <span class="required-star">*</span></label>
                                    <input type="password" class="ann-search-input" id="e-conf-pass" placeholder="Re-enter new password">
                                    <span class="field-error" id="err-conf-pass"></span>
                                </div>
                                <!-- Password strength indicator -->
                                <div class="password-strength" id="pass-strength" style="display:none;">
                                    <div class="strength-bar">
                                        <div class="strength-fill" id="strength-fill"></div>
                                    </div>
                                    <span class="strength-label" id="strength-label">Weak</span>
                                </div>
                                <div class="form-actions">
                                    <button type="button" class="btn-primary-portal" id="save-password-btn">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- NOTIFICATION PREFERENCES -->
                    <div class="settings-block" id="block-notif-pref">
                        <div class="settings-block-header" id="toggle-notif-pref">
                            <div class="settings-block-left">
                                <div class="settings-icon">🔔</div>
                                <div>
                                    <strong>Notification Preferences</strong>
                                    <p>Choose what you get notified about</p>
                                </div>
                            </div>
                            <svg class="settings-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                        <div class="settings-block-body" id="body-notif-pref" style="display:none;">
                            <div class="toggle-pref-list">
                                <label class="toggle-pref-item">
                                    <div class="toggle-pref-text">
                                        <strong>Service Request Updates</strong>
                                        <span>Approvals, rejections, and status changes</span>
                                    </div>
                                    <div class="toggle-switch" data-pref="service">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </div>
                                </label>
                                <label class="toggle-pref-item">
                                    <div class="toggle-pref-text">
                                        <strong>New Announcements</strong>
                                        <span>SK posts and official notices</span>
                                    </div>
                                    <div class="toggle-switch" data-pref="announcement">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </div>
                                </label>
                                <label class="toggle-pref-item">
                                    <div class="toggle-pref-text">
                                        <strong>Community Thread Replies</strong>
                                        <span>Replies and comments on your posts</span>
                                    </div>
                                    <div class="toggle-switch" data-pref="thread">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </div>
                                </label>
                                <label class="toggle-pref-item">
                                    <div class="toggle-pref-text">
                                        <strong>System Notifications</strong>
                                        <span>Account updates and portal news</span>
                                    </div>
                                    <div class="toggle-switch" data-pref="system">
                                        <input type="checkbox">
                                        <span class="toggle-slider"></span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- PRIVACY -->
                    <div class="settings-block" id="block-privacy">
                        <div class="settings-block-header" id="toggle-privacy">
                            <div class="settings-block-left">
                                <div class="settings-icon">🛡️</div>
                                <div>
                                    <strong>Privacy Settings</strong>
                                    <p>Control your profile visibility</p>
                                </div>
                            </div>
                            <svg class="settings-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                        <div class="settings-block-body" id="body-privacy" style="display:none;">
                            <div class="toggle-pref-list">
                                <label class="toggle-pref-item">
                                    <div class="toggle-pref-text">
                                        <strong>Show Profile to SK Officers</strong>
                                        <span>Allows officers to view your full info</span>
                                    </div>
                                    <div class="toggle-switch">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </div>
                                </label>
                                <label class="toggle-pref-item">
                                    <div class="toggle-pref-text">
                                        <strong>Show Name on Community Posts</strong>
                                        <span>Your name appears on threads you post</span>
                                    </div>
                                    <div class="toggle-switch">
                                        <input type="checkbox" checked>
                                        <span class="toggle-slider"></span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- DANGER ZONE -->
                    <div class="settings-block settings-block-danger" id="block-danger">
                        <div class="settings-block-header" id="toggle-danger">
                            <div class="settings-block-left">
                                <div class="settings-icon">⚠️</div>
                                <div>
                                    <strong>Danger Zone</strong>
                                    <p>Irreversible account actions</p>
                                </div>
                            </div>
                            <svg class="settings-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                        <div class="settings-block-body" id="body-danger" style="display:none;">
                            <div class="danger-zone-body">
                                <div class="danger-item">
                                    <div>
                                        <strong>Deactivate Account</strong>
                                        <p>Temporarily suspend your portal access. You can reactivate by contacting the SK office.</p>
                                    </div>
                                    <button class="btn-danger-outline" id="deactivate-btn">Deactivate</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>

            </div>
        </div>

    </main>
</div>

<!-- TOAST NOTIFICATION -->
<div class="profile-toast" id="profile-toast" style="display:none;">
    <span class="toast-icon" id="toast-icon">✅</span>
    <span class="toast-text" id="toast-text">Changes saved.</span>
</div>

<!-- CONFIRM MODAL (for Deactivate) -->
<div class="modal-overlay" id="confirm-overlay" style="display:none;" aria-modal="true" role="dialog">
    <div class="modal-box" style="max-width:440px;">
        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon" style="background:#fee2e2; font-size:20px;">⚠️</div>
                <div>
                    <h3 style="color:#991b1b;">Deactivate Account</h3>
                    <p class="modal-subtitle">This action requires confirmation.</p>
                </div>
            </div>
            <button class="modal-close" id="confirm-close">&times;</button>
        </div>
        <div class="modal-body" style="padding:24px;">
            <p style="font-size:14px; color:var(--text-body); line-height:1.7;">
                Are you sure you want to <strong>deactivate your account</strong>? Your profile and requests will be hidden until you reactivate by visiting the SK office in person.
            </p>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary-portal" id="confirm-cancel">Cancel</button>
            <button class="btn-danger" id="confirm-deactivate">Yes, Deactivate</button>
        </div>
    </div>
</div>

<script src="../../scripts/portal/profile_page.js"></script>

</body>
</html>