<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireRole('moderator');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | User Sanctions</title>
    <link rel="stylesheet" href="../../../styles/management/moderator/mod_sanctions.css">
    <link rel="stylesheet" href="../../../styles/management/mod_mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/moderator/mod_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/moderator/mod_topbar.css">
</head>
<body>

<div class="mod-layout">

    <?php include __DIR__ . '/../../../components/management/moderator/mod_sidebar.php'; ?>

    <main class="mod-content">

    <?php
    $pageTitle      = 'User Sanctions';
    $pageBreadcrumb = [['Home', '#'], ['User Sanctions', null]];
    $modName        = $_SESSION['user_name'] ?? 'Moderator';
    $modRole        = 'Moderator';
    $notifCount     = 5;
    include __DIR__ . '/../../../components/management/moderator/mod_topbar.php';
    ?>

        <!-- STAT WIDGETS -->
        <section class="mod-widgets">

            <div class="mod-widget-card widget-amber">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Total Warnings</span>
                    <p class="widget-number">15</p>
                    <span class="widget-trend warning">&#9654; Active sanctions</span>
                </div>
            </div>

            <div class="mod-widget-card widget-red">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.468 5.99 5.99 0 0 0-1.925 3.547 5.975 5.975 0 0 1-2.133-1.001A3.75 3.75 0 0 0 12 18Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Final Warnings</span>
                    <p class="widget-number">3</p>
                    <span class="widget-trend danger">&#9650; Needs attention</span>
                </div>
            </div>

            <div class="mod-widget-card widget-indigo">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Repeat Offenders</span>
                    <p class="widget-number">4</p>
                    <span class="widget-trend neutral">&#9654; Under monitoring</span>
                </div>
            </div>

            <div class="mod-widget-card widget-teal">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Issued Today</span>
                    <p class="widget-number">2</p>
                    <span class="widget-trend up">&#9654; This session</span>
                </div>
            </div>

        </section>

        <!-- ISSUE WARNING FORM -->
        <section class="ms-form-panel">
            <div class="panel-header">
                <h2 class="section-label">Issue New Warning</h2>
                <button class="btn-mod-sm" id="ms-form-toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                    Collapse
                </button>
            </div>

            <div class="ms-form-body" id="ms-form-body">
                <div class="ms-form-grid">
                    <div class="ms-field-group">
                        <label class="ms-label">Username</label>
                        <input type="text" class="ms-input" id="ms-username" placeholder="e.g. @juan_d">
                    </div>
                    <div class="ms-field-group">
                        <label class="ms-label">Warning Level</label>
                        <select class="ms-select" id="ms-level">
                            <option value="1">Level 1 — Verbal</option>
                            <option value="2">Level 2 — Written</option>
                            <option value="3">Level 3 — Final</option>
                        </select>
                    </div>
                    <div class="ms-field-group ms-field-full">
                        <label class="ms-label">Reason / Violation Details</label>
                        <textarea class="ms-input ms-textarea" id="ms-reason" placeholder="Describe the violation and context…"></textarea>
                    </div>
                </div>
                <div class="ms-form-actions">
                    <button type="button" class="ms-submit-btn" id="ms-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/></svg>
                        Issue Warning
                    </button>
                    <button type="button" class="ms-cancel-btn" id="ms-cancel">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                        Clear
                    </button>
                </div>
            </div>
        </section>

        <!-- FILTERS + WARNINGS LIST -->
        <section class="ms-list-panel">

            <div class="panel-header">
                <h2 class="section-label">Warnings Log</h2>
                <span class="ms-count-label">Showing <strong id="ms-shown">3</strong> of <strong>15</strong> warnings</span>
            </div>

            <!-- Filter bar -->
            <div class="ms-filter-bar">
                <div class="ms-filters-left">
                    <button class="ms-filter-btn active" data-filter="all">All</button>
                    <button class="ms-filter-btn" data-filter="3">Final (Lvl 3)</button>
                    <button class="ms-filter-btn" data-filter="2">Written (Lvl 2)</button>
                    <button class="ms-filter-btn" data-filter="1">Verbal (Lvl 1)</button>
                </div>
                <div class="ms-filters-right">
                    <div class="ms-search-wrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                        <input type="text" class="ms-search-input" id="ms-search" placeholder="Search by user or reason…">
                    </div>
                </div>
            </div>

            <!-- Warning items -->
            <div class="ms-list" id="ms-list">

                <div class="ms-item" data-level="3">
                    <div class="ms-item-left">
                        <div class="ms-level-badge level-3">Lvl 3</div>
                        <div class="ms-avatar">JD</div>
                    </div>
                    <div class="ms-item-body">
                        <div class="ms-item-header">
                            <div class="ms-item-user">
                                <span class="ms-username">@juan_d</span>
                                <span class="ms-violation">Harassment — 3rd warning</span>
                            </div>
                            <span class="ms-item-time">2 hours ago · by Moderator</span>
                        </div>
                        <p class="ms-item-reason">Repeated harassment against barangay officials despite two prior warnings. Thread has been locked pending review.</p>
                        <div class="ms-item-actions">
                            <a href="#" class="ms-action-btn ms-btn-view">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                                View Profile
                            </a>
                            <a href="#" class="ms-action-btn ms-btn-dismiss">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Dismiss
                            </a>
                            <a href="#" class="ms-action-btn ms-btn-ban">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                Ban User
                            </a>
                        </div>
                    </div>
                </div>

                <div class="ms-item" data-level="1">
                    <div class="ms-item-left">
                        <div class="ms-level-badge level-1">Lvl 1</div>
                        <div class="ms-avatar">S1</div>
                    </div>
                    <div class="ms-item-body">
                        <div class="ms-item-header">
                            <div class="ms-item-user">
                                <span class="ms-username">@seller123</span>
                                <span class="ms-violation">Spam</span>
                            </div>
                            <span class="ms-item-time">4 hours ago · by Moderator</span>
                        </div>
                        <p class="ms-item-reason">Multiple spam posts promoting external links across different threads. Reminded to follow community guidelines.</p>
                        <div class="ms-item-actions">
                            <a href="#" class="ms-action-btn ms-btn-view">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                                View Profile
                            </a>
                            <a href="#" class="ms-action-btn ms-btn-dismiss">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Dismiss
                            </a>
                        </div>
                    </div>
                </div>

                <div class="ms-item" data-level="2">
                    <div class="ms-item-left">
                        <div class="ms-level-badge level-2">Lvl 2</div>
                        <div class="ms-avatar">PC</div>
                    </div>
                    <div class="ms-item-body">
                        <div class="ms-item-header">
                            <div class="ms-item-user">
                                <span class="ms-username">@pedro_c</span>
                                <span class="ms-violation">Inappropriate Language</span>
                            </div>
                            <span class="ms-item-time">1 day ago · by Moderator</span>
                        </div>
                        <p class="ms-item-reason">Use of profanity in road repair discussion thread. Reminded to keep discussions civil and respectful.</p>
                        <div class="ms-item-actions">
                            <a href="#" class="ms-action-btn ms-btn-view">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                                View Profile
                            </a>
                            <a href="#" class="ms-action-btn ms-btn-dismiss">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Dismiss
                            </a>
                        </div>
                    </div>
                </div>

            </div><!-- /ms-list -->

            <!-- Empty state -->
            <div class="ms-empty" id="ms-empty" style="display:none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                <p>No warnings match your current filter.</p>
            </div>

        </section>

        <!-- PAGINATION -->
        <div class="ms-pagination">
            <button class="ms-page-btn" disabled>&#8249; Prev</button>
            <div class="ms-page-numbers">
                <button class="ms-page-num active">1</button>
                <button class="ms-page-num">2</button>
            </div>
            <button class="ms-page-btn">Next &#8250;</button>
        </div>

    </main>
</div>

<script src="../../../scripts/management/moderator/mod_sanctions.js"></script>

</body>
</html>