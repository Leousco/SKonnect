<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireRole('sk_officer');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | SK Officer Dashboard</title>
    <link rel="stylesheet" href="../../../styles/management/officer/officer_dashboard.css">
    <link rel="stylesheet" href="../../../styles/management/officer_mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/officer/officer_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/officer/officer_topbar.css">
</head>
<body>

<div class="off-layout">

    <?php include __DIR__ . '/../../../components/management/officer/officer_sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="off-content">

    <?php
    $pageTitle      = 'Dashboard';
    $pageBreadcrumb = [['Home', '#'], ['Dashboard', null]];
    $officerName    = $_SESSION['user_name'] ?? 'SK Officer';
    $officerRole    = 'SK Officer';
    $notifCount     = 3;
    include __DIR__ . '/../../../components/management/officer/officer_topbar.php';
    ?>

        <!-- STAT WIDGETS -->
        <section class="off-widgets">

            <div class="off-widget-card widget-amber">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Pending Requests</span>
                    <p class="widget-number">8</p>
                    <span class="widget-trend warning">&#9650; Needs attention</span>
                </div>
            </div>

            <div class="off-widget-card widget-cyan">
                <div class="widget-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>                </div>
                <div class="widget-body">
                    <span class="widget-label">Announcements</span>
                    <p class="widget-number">3</p>
                    <span class="widget-trend neutral">1 expiring soon</span>
                </div>
            </div>

            <div class="off-widget-card widget-green">
                <div class="widget-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="12" y1="18" x2="12" y2="12"/>
                        <line x1="9" y1="15" x2="15" y2="15"/>
                    </svg>                </div>
                <div class="widget-body">
                    <span class="widget-label">Available Services</span>
                    <p class="widget-number">6</p>
                    <span class="widget-trend up">&#9650; All active</span>
                </div>
            </div>

            <div class="off-widget-card widget-indigo">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Total Residents</span>
                    <p class="widget-number">124</p>
                    <span class="widget-trend up">&#9650; 6 new this month</span>
                </div>
            </div>

        </section>

        <div class="off-lower">

            <!-- LEFT COLUMN -->
            <div class="off-left-col">

                <!-- PENDING SERVICE REQUESTS TABLE -->
                <section class="off-requests-panel">
                    <div class="panel-header">
                        <h2 class="section-label">Pending Service Requests</h2>
                        <a href="requests_mgmt.php" class="btn-off-sm">View All &rsaquo;</a>
                    </div>
                    <div class="requests-table-wrap">
                        <table class="requests-table">
                            <thead>
                                <tr>
                                    <th>Resident</th>
                                    <th>Service Type</th>
                                    <th>Submitted</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="req-name">
                                            <div class="req-avatar">PC</div>
                                            Pedro Cruz
                                        </div>
                                    </td>
                                    <td><span class="req-badge badge-clearance">Barangay Clearance</span></td>
                                    <td>Mar 5, 2026</td>
                                    <td><span class="status-pill status-pending">Pending</span></td>
                                    <td><a href="requests_mgmt.php?id=1" class="action-link">Review</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="req-name">
                                            <div class="req-avatar">AR</div>
                                            Ana Reyes
                                        </div>
                                    </td>
                                    <td><span class="req-badge badge-residency">Cert. of Residency</span></td>
                                    <td>Mar 5, 2026</td>
                                    <td><span class="status-pill status-processing">Processing</span></td>
                                    <td><a href="requests_mgmt.php?id=2" class="action-link">Review</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="req-name">
                                            <div class="req-avatar">JL</div>
                                            Jose Lim
                                        </div>
                                    </td>
                                    <td><span class="req-badge badge-indigency">Indigency Cert.</span></td>
                                    <td>Mar 4, 2026</td>
                                    <td><span class="status-pill status-pending">Pending</span></td>
                                    <td><a href="requests_mgmt.php?id=3" class="action-link">Review</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="req-name">
                                            <div class="req-avatar">MS</div>
                                            Maria Santos
                                        </div>
                                    </td>
                                    <td><span class="req-badge badge-clearance">Barangay Clearance</span></td>
                                    <td>Mar 4, 2026</td>
                                    <td><span class="status-pill status-approved">Approved</span></td>
                                    <td><a href="requests_mgmt.php?id=4" class="action-link">View</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- SERVICE ANALYTICS BAR CHART -->
                <section class="chart-panel">
                    <div class="panel-header">
                        <h2 class="section-label">Requests by Service Type</h2>
                        <span class="chart-period">Mar 2026</span>
                    </div>
                    <div class="bar-chart-wrap">
                        <div class="bar-row">
                            <span class="bar-label">Barangay Clearance</span>
                            <div class="bar-track"><div class="bar-fill bar-cyan" style="width:85%"></div></div>
                            <span class="bar-count">42</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">Cert. of Residency</span>
                            <div class="bar-track"><div class="bar-fill bar-indigo" style="width:56%"></div></div>
                            <span class="bar-count">28</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">Indigency Cert.</span>
                            <div class="bar-track"><div class="bar-fill bar-green" style="width:30%"></div></div>
                            <span class="bar-count">15</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">Business Permit</span>
                            <div class="bar-track"><div class="bar-fill bar-amber" style="width:18%"></div></div>
                            <span class="bar-count">9</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">Others</span>
                            <div class="bar-track"><div class="bar-fill bar-muted" style="width:8%"></div></div>
                            <span class="bar-count">4</span>
                        </div>
                    </div>
                </section>

            </div>

            <!-- RIGHT COLUMN -->
            <aside class="off-right-col">

                <section class="quick-actions-panel">
                    <h2 class="section-label">Quick Actions</h2>
                    <div class="quick-actions-grid">
                        <a href="officer_announcements.php" class="quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            New Announcement
                        </a>
                        <a href="officer_requests.php" class="quick-action-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                            </svg>                            
                            Manage Requests
                        </a>
                        <a href="officer_analytics.php" class="quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"/></svg>
                            View Analytics
                        </a>
                        <a href="reports_mgmt.php" class="quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            Export Reports
                        </a>
                    </div>
                </section>

                <section class="off-activity-panel">
                    <h2 class="section-label">Recent Activity</h2>
                    <div class="activity-feed">

                        <div class="activity-entry">
                            <div class="activity-icon icon-green">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                            </div>
                            <div class="activity-info">
                                <p>Approved clearance for <strong>Maria Santos</strong></p>
                                <span>Mar 5, 2026 · 11:30 AM</span>
                            </div>
                        </div>

                        <div class="activity-entry">
                            <div class="activity-icon icon-cyan">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            </div>
                            <div class="activity-info">
                                <p>Published announcement: <strong>Community Clean-up Drive</strong></p>
                                <span>Mar 3, 2026 · 9:00 AM</span>
                            </div>
                        </div>

                        <div class="activity-entry">
                            <div class="activity-icon icon-amber">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
                            </div>
                            <div class="activity-info">
                                <p>Flagged request from <strong>Jose Lim</strong> for review</p>
                                <span>Mar 4, 2026 · 2:15 PM</span>
                            </div>
                        </div>

                        <div class="activity-entry">
                            <div class="activity-icon icon-indigo">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5"/></svg>
                            </div>
                            <div class="activity-info">
                                <p>Created event: <strong>Barangay Assembly — March 10</strong></p>
                                <span>Mar 2, 2026 · 4:00 PM</span>
                            </div>
                        </div>

                    </div>
                </section>

            </aside>
        </div>

        <div class="off-bottom-row">

            <!-- REQUEST VOLUME CHART -->
            <section class="chart-panel chart-panel--stretch">
                <div class="panel-header">
                    <h2 class="section-label">Request Volume</h2>
                    <span class="chart-period">Last 6 months</span>
                </div>
                <div class="sparkline-wrap--grow">
                    <svg class="sparkline-svg sparkline-svg--tall" viewBox="0 0 560 120" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="offSparkGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%"   stop-color="#0891b2" stop-opacity="0.25"/>
                                <stop offset="100%" stop-color="#0891b2" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <path d="M0,90 L93,75 L186,60 L280,45 L373,30 L466,18 L560,8"
                              fill="none" stroke="#0891b2" stroke-width="2.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M0,90 L93,75 L186,60 L280,45 L373,30 L466,18 L560,8 L560,120 L0,120 Z"
                              fill="url(#offSparkGrad)"/>
                    </svg>
                    <div class="sparkline-labels">
                        <span>Sep</span><span>Oct</span><span>Nov</span><span>Dec</span><span>Jan</span><span>Feb</span>
                    </div>
                    <div class="sparkline-stats sparkline-stats--quad">
                        <div class="spark-stat">
                            <span class="spark-val">8</span>
                            <span class="spark-lbl">Pending</span>
                        </div>
                        <div class="spark-stat">
                            <span class="spark-val">42</span>
                            <span class="spark-lbl">This month</span>
                        </div>
                        <div class="spark-stat">
                            <span class="spark-val">38</span>
                            <span class="spark-lbl">Resolved</span>
                        </div>
                        <div class="spark-stat">
                            <span class="spark-val">98%</span>
                            <span class="spark-lbl">Approval rate</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- RECENT ANNOUNCEMENTS -->
            <section class="chart-panel chart-panel--stretch">
                <div class="panel-header">
                    <h2 class="section-label">Recent Announcements</h2>
                    <a href="announcements_mgmt.php" class="btn-off-sm">Manage &rsaquo;</a>
                </div>
                <ul class="off-ann-list--grow">
                    <li class="off-ann-item">
                        <div class="ann-date-badge">
                            <span class="ann-day">3</span>
                            <span class="ann-mon">Mar</span>
                        </div>
                        <div class="ann-info">
                            <strong>Community Clean-up Drive</strong>
                            <span>Published · Active</span>
                        </div>
                    </li>
                    <li class="off-ann-item">
                        <div class="ann-date-badge">
                            <span class="ann-day">2</span>
                            <span class="ann-mon">Mar</span>
                        </div>
                        <div class="ann-info">
                            <strong>Barangay Assembly — March 10</strong>
                            <span>Published · Active</span>
                        </div>
                    </li>
                    <li class="off-ann-item">
                        <div class="ann-date-badge">
                            <span class="ann-day">1</span>
                            <span class="ann-mon">Mar</span>
                        </div>
                        <div class="ann-info">
                            <strong>Livelihood Training Program</strong>
                            <span>Published · Active</span>
                        </div>
                    </li>
                    <li class="off-ann-item">
                        <div class="ann-date-badge">
                            <span class="ann-day">28</span>
                            <span class="ann-mon">Feb</span>
                        </div>
                        <div class="ann-info">
                            <strong>Youth Sports Fest Registration Open</strong>
                            <span>Published · Expiring soon</span>
                        </div>
                    </li>
                </ul>
            </section>

        </div>

    </main>
</div>

<script src="../../../scripts/management/officer/officer_dashboard.js"></script>

</body>
</html>