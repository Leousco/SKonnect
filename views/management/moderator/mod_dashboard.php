<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireRole('moderator');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Moderator Dashboard</title>
    <link rel="stylesheet" href="../../../styles/management/moderator/mod_dashboard.css">
    <link rel="stylesheet" href="../../../styles/management/mod_mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/moderator/mod_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/moderator/mod_topbar.css">
</head>
<body>

<div class="mod-layout">

    <?php include __DIR__ . '/../../../components/management/moderator/mod_sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="mod-content">

    <?php
    $pageTitle      = 'Dashboard';
    $pageBreadcrumb = [['Home', '#'], ['Dashboard', null]];
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
                    <p class="widget-number">5</p>
                    <span class="widget-trend danger">&#9650; Needs review</span>
                </div>
            </div>

            <div class="mod-widget-card widget-teal">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Active Threads</span>
                    <p class="widget-number">38</p>
                    <span class="widget-trend up">&#9650; 4 new today</span>
                </div>
            </div>

            <div class="mod-widget-card widget-amber">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Locked Threads</span>
                    <p class="widget-number">4</p>
                    <span class="widget-trend neutral">No change</span>
                </div>
            </div>

            <div class="mod-widget-card widget-indigo">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Warnings Issued</span>
                    <p class="widget-number">9</p>
                    <span class="widget-trend warning">&#9654; This month</span>
                </div>
            </div>

        </section>

        <div class="mod-lower">

            <!-- LEFT COLUMN -->
            <div class="mod-left-col">

                <!-- PENDING REPORTS TABLE -->
                <section class="mod-reports-panel">
                    <div class="panel-header">
                        <h2 class="section-label">Pending Reports</h2>
                        <a href="mod_reports.php" class="btn-mod-sm">View All &rsaquo;</a>
                    </div>
                    <div class="requests-table-wrap">
                        <table class="requests-table">
                            <thead>
                                <tr>
                                    <th>Reporter</th>
                                    <th>Content</th>
                                    <th>Reason</th>
                                    <th>Submitted</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="req-name">
                                            <div class="req-avatar">JD</div>
                                            juan_d
                                        </div>
                                    </td>
                                    <td>Thread: "Is the barangay doing anything?"</td>
                                    <td><span class="req-badge badge-red">Harassment</span></td>
                                    <td>Mar 5, 2026</td>
                                    <td><a href="mod_reports.php?id=1" class="action-link">Review</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="req-name">
                                            <div class="req-avatar">MS</div>
                                            maria_s
                                        </div>
                                    </td>
                                    <td>Post: "Free items, dm me"</td>
                                    <td><span class="req-badge badge-orange">Spam</span></td>
                                    <td>Mar 5, 2026</td>
                                    <td><a href="mod_reports.php?id=2" class="action-link">Review</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="req-name">
                                            <div class="req-avatar">PC</div>
                                            pedro_c
                                        </div>
                                    </td>
                                    <td>Comment on "Road Repair Concern"</td>
                                    <td><span class="req-badge badge-red">Inappropriate</span></td>
                                    <td>Mar 4, 2026</td>
                                    <td><a href="mod_reports.php?id=3" class="action-link">Review</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="req-name">
                                            <div class="req-avatar">AL</div>
                                            ana_l
                                        </div>
                                    </td>
                                    <td>Thread: "Selling products here"</td>
                                    <td><span class="req-badge badge-orange">Spam</span></td>
                                    <td>Mar 4, 2026</td>
                                    <td><a href="mod_reports.php?id=4" class="action-link">Review</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- REPORTS BY REASON -->
                <section class="chart-panel">
                    <div class="panel-header">
                        <h2 class="section-label">Reports by Reason</h2>
                        <span class="chart-period">Mar 2026</span>
                    </div>
                    <div class="bar-chart-wrap">
                        <div class="bar-row">
                            <span class="bar-label">Harassment</span>
                            <div class="bar-track"><div class="bar-fill bar-red" style="width:60%"></div></div>
                            <span class="bar-count">9</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">Spam</span>
                            <div class="bar-track"><div class="bar-fill bar-orange" style="width:47%"></div></div>
                            <span class="bar-count">7</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">Inappropriate</span>
                            <div class="bar-track"><div class="bar-fill bar-teal" style="width:33%"></div></div>
                            <span class="bar-count">5</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">Misinformation</span>
                            <div class="bar-track"><div class="bar-fill bar-indigo" style="width:20%"></div></div>
                            <span class="bar-count">3</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">Others</span>
                            <div class="bar-track"><div class="bar-fill bar-muted" style="width:7%"></div></div>
                            <span class="bar-count">1</span>
                        </div>
                    </div>
                </section>

            </div>

            <!-- RIGHT COLUMN -->
            <aside class="mod-right-col">

                <section class="quick-actions-panel">
                    <h2 class="section-label">Quick Actions</h2>
                    <div class="quick-actions-grid">
                        <a href="mod_reports.php" class="quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l1.664 1.664M21 21l-1.5-1.5m-5.485-1.242L12 17.25 4.5 21V8.742m.164-4.078a2.15 2.15 0 0 1 1.743-1.342 48.507 48.507 0 0 1 11.186 0c1.1.128 1.907 1.077 1.907 2.185V19.5M4.664 4.664 19.5 19.5"/></svg>
                            Review Reports
                        </a>
                        <a href="mod_threads.php" class="quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/></svg>
                            Browse Threads
                        </a>
                        <a href="mod_warnings.php" class="quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                            Issue Warning
                        </a>
                        <a href="mod_locked.php" class="quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                            Locked Threads
                        </a>
                    </div>
                </section>

                <section class="mod-activity-panel">
                    <h2 class="section-label">Moderator Activity Log</h2>
                    <div class="activity-feed">

                        <div class="activity-entry">
                            <div class="activity-icon icon-red">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                            </div>
                            <div class="activity-info">
                                <p>Deleted spam post by <strong>user_xyz</strong></p>
                                <span>Mar 5, 2026 · 10:15 AM</span>
                            </div>
                        </div>

                        <div class="activity-entry">
                            <div class="activity-icon icon-amber">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
                            </div>
                            <div class="activity-info">
                                <p>Issued warning to <strong>pedro_c</strong> for offensive language</p>
                                <span>Mar 4, 2026 · 3:40 PM</span>
                            </div>
                        </div>

                        <div class="activity-entry">
                            <div class="activity-icon icon-teal">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                            </div>
                            <div class="activity-info">
                                <p>Locked thread: <strong>"Off-topic political debate"</strong></p>
                                <span>Mar 4, 2026 · 1:00 PM</span>
                            </div>
                        </div>

                        <div class="activity-entry">
                            <div class="activity-icon icon-green">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                            </div>
                            <div class="activity-info">
                                <p>Resolved report on <strong>juan_d's</strong> thread</p>
                                <span>Mar 3, 2026 · 9:20 AM</span>
                            </div>
                        </div>

                    </div>
                </section>

            </aside>
        </div>

        <div class="mod-bottom-row">

            <!-- THREAD ACTIVITY CHART -->
            <section class="chart-panel chart-panel--stretch">
                <div class="panel-header">
                    <h2 class="section-label">Thread Activity</h2>
                    <span class="chart-period">Last 6 months</span>
                </div>
                <div class="sparkline-wrap sparkline-wrap--grow">
                    <svg class="sparkline-svg sparkline-svg--tall" viewBox="0 0 560 120" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="modSparkGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#0d9488" stop-opacity="0.25"/>
                                <stop offset="100%" stop-color="#0d9488" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <path d="M0,95 L93,80 L186,65 L280,50 L373,35 L466,20 L560,10"
                              fill="none" stroke="#0d9488" stroke-width="2.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M0,95 L93,80 L186,65 L280,50 L373,35 L466,20 L560,10 L560,120 L0,120 Z"
                              fill="url(#modSparkGrad)"/>
                    </svg>
                    <div class="sparkline-labels">
                        <span>Sep</span><span>Oct</span><span>Nov</span><span>Dec</span><span>Jan</span><span>Feb</span>
                    </div>
                    <div class="sparkline-stats sparkline-stats--quad">
                        <div class="spark-stat">
                            <span class="spark-val">+4</span>
                            <span class="spark-lbl">New today</span>
                        </div>
                        <div class="spark-stat">
                            <span class="spark-val">38</span>
                            <span class="spark-lbl">Active threads</span>
                        </div>
                        <div class="spark-stat">
                            <span class="spark-val">25</span>
                            <span class="spark-lbl">Reports resolved</span>
                        </div>
                        <div class="spark-stat">
                            <span class="spark-val">4</span>
                            <span class="spark-lbl">Locked this month</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- RECENT COMMUNITY POSTS -->
            <section class="chart-panel chart-panel--stretch">
                <div class="panel-header">
                    <h2 class="section-label">Recent Community Posts</h2>
                    <a href="mod_threads.php" class="btn-mod-sm">Manage &rsaquo;</a>
                </div>
                <ul class="mod-threads-list mod-threads-list--grow">
                    <li class="mod-thread-item">
                        <div class="thread-meta-badge">
                            <span class="thread-replies">12</span>
                            <span class="thread-replies-lbl">replies</span>
                        </div>
                        <div class="thread-info">
                            <strong>When is the next livelihood training?</strong>
                            <span>Posted by rey_s · 2 hrs ago</span>
                        </div>
                    </li>
                    <li class="mod-thread-item">
                        <div class="thread-meta-badge">
                            <span class="thread-replies">5</span>
                            <span class="thread-replies-lbl">replies</span>
                        </div>
                        <div class="thread-info">
                            <strong>Streetlight on Calle Uno is broken</strong>
                            <span>Posted by carlo_m · 5 hrs ago</span>
                        </div>
                    </li>
                    <li class="mod-thread-item">
                        <div class="thread-meta-badge">
                            <span class="thread-replies">8</span>
                            <span class="thread-replies-lbl">replies</span>
                        </div>
                        <div class="thread-info">
                            <strong>Lost dog — brown Aspin near purok 3</strong>
                            <span>Posted by ana_r · Yesterday</span>
                        </div>
                    </li>
                    <li class="mod-thread-item">
                        <div class="thread-meta-badge">
                            <span class="thread-replies">3</span>
                            <span class="thread-replies-lbl">replies</span>
                        </div>
                        <div class="thread-info">
                            <strong>Request for basketball court repair</strong>
                            <span>Posted by lito_g · Yesterday</span>
                        </div>
                    </li>
                </ul>
            </section>

        </div>

    </main>
</div>

<script src="../../../scripts/management/moderator/mod_dashboard.js"></script>

</body>
</html>