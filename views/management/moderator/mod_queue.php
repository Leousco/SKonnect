<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireRole('moderator');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Moderation Queue</title>
    <link rel="stylesheet" href="../../../styles/management/moderator/mod_queue.css">
    <link rel="stylesheet" href="../../../styles/management/mod_mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/moderator/mod_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/moderator/mod_topbar.css">
</head>
<body>

<div class="mod-layout">

    <?php include __DIR__ . '/../../../components/management/moderator/mod_sidebar.php'; ?>

    <main class="mod-content">

    <?php
    $pageTitle      = 'Moderation Queue';
    $pageBreadcrumb = [['Home', '#'], ['Moderation Queue', null]];
    $modName        = $_SESSION['user_name'] ?? 'Moderator';
    $modRole        = 'Moderator';
    $notifCount     = 5;
    include __DIR__ . '/../../../components/management/moderator/mod_topbar.php';
    ?>

        <!-- STAT WIDGETS -->
        <section class="mod-widgets">

            <div class="mod-widget-card widget-red">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l1.664 1.664M21 21l-1.5-1.5m-5.485-1.242L12 17.25 4.5 21V8.742m.164-4.078a2.15 2.15 0 0 1 1.743-1.342 48.507 48.507 0 0 1 11.186 0c1.1.128 1.907 1.077 1.907 2.185V19.5M4.664 4.664 19.5 19.5"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Pending Reports</span>
                    <p class="widget-number">12</p>
                    <span class="widget-trend danger">&#9650; Needs review</span>
                </div>
            </div>

            <div class="mod-widget-card widget-amber">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Harassment</span>
                    <p class="widget-number">5</p>
                    <span class="widget-trend warning">&#9654; This week</span>
                </div>
            </div>

            <div class="mod-widget-card widget-teal">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Resolved Today</span>
                    <p class="widget-number">3</p>
                    <span class="widget-trend up">&#9650; Good progress</span>
                </div>
            </div>

            <div class="mod-widget-card widget-indigo">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Spam Reports</span>
                    <p class="widget-number">4</p>
                    <span class="widget-trend neutral">&#9654; This week</span>
                </div>
            </div>

        </section>

        <!-- FILTERS BAR -->
        <section class="mq-filters-bar">
            <div class="mq-filters-left">
                <button class="mq-filter-btn active" data-filter="all">All Reports</button>
                <button class="mq-filter-btn" data-filter="harassment">Harassment</button>
                <button class="mq-filter-btn" data-filter="spam">Spam</button>
                <button class="mq-filter-btn" data-filter="inappropriate">Inappropriate</button>
                <button class="mq-filter-btn" data-filter="misinformation">Misinformation</button>
            </div>
            <div class="mq-filters-right">
                <div class="mq-search-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                    <input type="text" id="mq-search" class="mq-search-input" placeholder="Search reports…">
                </div>
                <select class="mq-select" id="mq-sort">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                </select>
            </div>
        </section>

        <!-- REPORTS LIST -->
        <section class="mq-panel">

            <div class="panel-header">
                <h2 class="section-label">Reports Queue</h2>
                <span class="mq-count-label">Showing <strong id="mq-shown">4</strong> of <strong>12</strong> reports</span>
            </div>

            <div class="mq-list" id="mq-list">

                <!-- Report Item -->
                <div class="mq-item" data-reason="harassment">
                    <div class="mq-item-left">
                        <div class="mq-reason-badge badge-red">Harassment</div>
                        <div class="mq-avatar">JD</div>
                    </div>
                    <div class="mq-item-body">
                        <div class="mq-item-header">
                            <span class="mq-item-title">Thread: "Barangay officials are useless!"</span>
                            <span class="mq-item-time">2 hours ago</span>
                        </div>
                        <div class="mq-item-meta">
                            Reported by <strong>juan_d</strong> &middot; Target: <strong>@sk_official</strong>
                        </div>
                        <p class="mq-item-reason">Repeated personal attacks against officials with threatening language.</p>
                        <div class="mq-item-actions">
                            <a href="#" class="mq-action-btn mq-btn-view">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.641 0-8.573-3.007-9.964-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                View
                            </a>
                            <a href="#" class="mq-action-btn mq-btn-warn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                                Warn User
                            </a>
                            <a href="#" class="mq-action-btn mq-btn-delete">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                Delete
                            </a>
                            <a href="#" class="mq-action-btn mq-btn-resolve">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Resolve
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Report Item -->
                <div class="mq-item" data-reason="spam">
                    <div class="mq-item-left">
                        <div class="mq-reason-badge badge-orange">Spam</div>
                        <div class="mq-avatar">MS</div>
                    </div>
                    <div class="mq-item-body">
                        <div class="mq-item-header">
                            <span class="mq-item-title">"DM me for cheap phones!"</span>
                            <span class="mq-item-time">4 hours ago</span>
                        </div>
                        <div class="mq-item-meta">
                            Reported by <strong>maria_s</strong> &middot; Posted by: <strong>@seller123</strong>
                        </div>
                        <p class="mq-item-reason">Identical spam posts across multiple threads with external links.</p>
                        <div class="mq-item-actions">
                            <a href="#" class="mq-action-btn mq-btn-view">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.641 0-8.573-3.007-9.964-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                View
                            </a>
                            <a href="#" class="mq-action-btn mq-btn-warn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                                Warn User
                            </a>
                            <a href="#" class="mq-action-btn mq-btn-delete">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                Delete
                            </a>
                            <a href="#" class="mq-action-btn mq-btn-resolve">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Resolve
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Report Item -->
                <div class="mq-item" data-reason="inappropriate">
                    <div class="mq-item-left">
                        <div class="mq-reason-badge badge-red">Inappropriate</div>
                        <div class="mq-avatar">PC</div>
                    </div>
                    <div class="mq-item-body">
                        <div class="mq-item-header">
                            <span class="mq-item-title">Comment on "Road Repair Concern"</span>
                            <span class="mq-item-time">1 day ago</span>
                        </div>
                        <div class="mq-item-meta">
                            Reported by <strong>pedro_c</strong> &middot; Posted by: <strong>@troll_user</strong>
                        </div>
                        <p class="mq-item-reason">Contains profanity and off-topic personal attacks.</p>
                        <div class="mq-item-actions">
                            <a href="#" class="mq-action-btn mq-btn-view">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.641 0-8.573-3.007-9.964-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                View
                            </a>
                            <a href="#" class="mq-action-btn mq-btn-warn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                                Warn User
                            </a>
                            <a href="#" class="mq-action-btn mq-btn-delete">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                Delete
                            </a>
                            <a href="#" class="mq-action-btn mq-btn-resolve">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Resolve
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Report Item -->
                <div class="mq-item" data-reason="spam">
                    <div class="mq-item-left">
                        <div class="mq-reason-badge badge-orange">Spam</div>
                        <div class="mq-avatar">AL</div>
                    </div>
                    <div class="mq-item-body">
                        <div class="mq-item-header">
                            <span class="mq-item-title">Thread: "Selling products here"</span>
                            <span class="mq-item-time">1 day ago</span>
                        </div>
                        <div class="mq-item-meta">
                            Reported by <strong>ana_l</strong> &middot; Posted by: <strong>@vendor_99</strong>
                        </div>
                        <p class="mq-item-reason">Unsolicited product promotion in community thread.</p>
                        <div class="mq-item-actions">
                            <a href="#" class="mq-action-btn mq-btn-view">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.641 0-8.573-3.007-9.964-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                                View
                            </a>
                            <a href="#" class="mq-action-btn mq-btn-warn">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                                Warn User
                            </a>
                            <a href="#" class="mq-action-btn mq-btn-delete">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                Delete
                            </a>
                            <a href="#" class="mq-action-btn mq-btn-resolve">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Resolve
                            </a>
                        </div>
                    </div>
                </div>

            </div><!-- /mq-list -->

            <!-- Empty state -->
            <div class="mq-empty" id="mq-empty" style="display:none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                <p>No reports match your current filter.</p>
            </div>

        </section>

        <!-- PAGINATION -->
        <div class="mq-pagination">
            <button class="mq-page-btn" disabled>&#8249; Prev</button>
            <div class="mq-page-numbers">
                <button class="mq-page-num active">1</button>
                <button class="mq-page-num">2</button>
            </div>
            <button class="mq-page-btn">Next &#8250;</button>
        </div>

    </main>
</div>

<script src="../../../scripts/management/moderator/mod_queue.js"></script>

</body>
</html>