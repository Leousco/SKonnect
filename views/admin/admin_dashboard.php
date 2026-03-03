<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect Admin | Dashboard</title>
    <link rel="stylesheet" href="../../styles/admin/admin_dashboard.css">
    <link rel="stylesheet" href="../../styles/admin/admin_global.css">
    <link rel="stylesheet" href="../../styles/admin/admin_sidebar.css">
    <link rel="stylesheet" href="../../styles/admin/admin_topbar.css">
</head>
<body>

<div class="admin-layout">

    <?php include __DIR__ . '/../../components/admin/admin_sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="admin-content">

    <?php
    $pageTitle      = 'Dashboard';
    $pageBreadcrumb = [['Home', '#'], ['Dashboard', null]];
    $adminName      = 'Maria Santos';
    $adminRole      = 'SK Super Admin';
    $notifCount     = 7;
    include __DIR__ . '/../../components/admin/admin_topbar.php';
    ?>

        <!-- STAT WIDGETS -->
        <section class="admin-widgets">

            <div class="admin-widget-card widget-violet">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Total Members</span>
                    <p class="widget-number">348</p>
                    <span class="widget-trend up">&#9650; 12 this month</span>
                </div>
            </div>

            <div class="admin-widget-card widget-amber">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Pending Requests</span>
                    <p class="widget-number">24</p>
                    <span class="widget-trend warning">&#9654; Needs attention</span>
                </div>
            </div>

            <div class="admin-widget-card widget-indigo">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 1 8.835-2.535m0 0A23.74 23.74 0 0 1 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Active Announcements</span>
                    <p class="widget-number">9</p>
                    <span class="widget-trend neutral">3 expiring soon</span>
                </div>
            </div>

            <div class="admin-widget-card widget-red">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Flagged Reports</span>
                    <p class="widget-number">3</p>
                    <span class="widget-trend danger">&#9650; Review required</span>
                </div>
            </div>

        </section>

        <div class="admin-lower">

            <!-- LEFT COLUMN: table stacked above bar chart -->
            <div class="admin-left-col">

                <!-- PENDING SERVICE REQUESTS TABLE -->
                <section class="admin-requests-panel">
                    <div class="panel-header">
                        <h2 class="section-label">Pending Service Requests</h2>
                        <a href="service-requests.php" class="btn-admin-sm">View All &rsaquo;</a>
                    </div>
                    <div class="requests-table-wrap">
                        <table class="requests-table">
                            <thead>
                                <tr>
                                    <th>Applicant</th>
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
                                            <div class="req-avatar">JD</div>
                                            Juan Dela Cruz
                                        </div>
                                    </td>
                                    <td><span class="req-badge badge-scholarship">Scholarship</span></td>
                                    <td>Feb 28, 2026</td>
                                    <td><span class="status-pill status-pending">Pending</span></td>
                                    <td><a href="service-requests.php?id=1" class="action-link">Review</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="req-name">
                                            <div class="req-avatar">AM</div>
                                            Ana Mayuga
                                        </div>
                                    </td>
                                    <td><span class="req-badge badge-medical">Medical Assist.</span></td>
                                    <td>Feb 27, 2026</td>
                                    <td><span class="status-pill status-review">Under Review</span></td>
                                    <td><a href="service-requests.php?id=2" class="action-link">Review</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="req-name">
                                            <div class="req-avatar">RG</div>
                                            Rico Gutierrez
                                        </div>
                                    </td>
                                    <td><span class="req-badge badge-livelihood">Livelihood</span></td>
                                    <td>Feb 25, 2026</td>
                                    <td><span class="status-pill status-pending">Pending</span></td>
                                    <td><a href="service-requests.php?id=3" class="action-link">Review</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="req-name">
                                            <div class="req-avatar">LC</div>
                                            Liza Cruz
                                        </div>
                                    </td>
                                    <td><span class="req-badge badge-scholarship">Scholarship</span></td>
                                    <td>Feb 24, 2026</td>
                                    <td><span class="status-pill status-pending">Pending</span></td>
                                    <td><a href="service-requests.php?id=4" class="action-link">Review</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- REQUESTS BY SERVICE TYPE — directly below the table -->
                <section class="chart-panel">
                    <div class="panel-header">
                        <h2 class="section-label">Requests by Service Type</h2>
                        <span class="chart-period">Feb 2026</span>
                    </div>
                    <div class="bar-chart-wrap">
                        <div class="bar-row">
                            <span class="bar-label">Scholarship</span>
                            <div class="bar-track"><div class="bar-fill bar-violet" style="width:72%"></div></div>
                            <span class="bar-count">18</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">Medical Assist.</span>
                            <div class="bar-track"><div class="bar-fill bar-amber" style="width:44%"></div></div>
                            <span class="bar-count">11</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">Livelihood</span>
                            <div class="bar-track"><div class="bar-fill bar-indigo" style="width:28%"></div></div>
                            <span class="bar-count">7</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">Legal Aid</span>
                            <div class="bar-track"><div class="bar-fill bar-teal" style="width:16%"></div></div>
                            <span class="bar-count">4</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">Others</span>
                            <div class="bar-track"><div class="bar-fill bar-muted" style="width:8%"></div></div>
                            <span class="bar-count">2</span>
                        </div>
                    </div>
                </section>

            </div>

            <!-- RIGHT COLUMN: quick actions + activity log -->
            <aside class="admin-right-col">

                <section class="quick-actions-panel">
                    <h2 class="section-label">Quick Actions</h2>
                    <div class="quick-actions-grid">
                        <a href="announcements-create.php" class="quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            New Announcement
                        </a>
                        <a href="events-create.php" class="quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                            Schedule Event
                        </a>
                        <a href="members.php?action=add" class="quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z"/></svg>
                            Add Member
                        </a>
                        <a href="reports.php" class="quick-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            Export Report
                        </a>
                    </div>
                </section>

                <section class="admin-activity-panel">
                    <h2 class="section-label">Admin Activity Log</h2>
                    <div class="activity-feed">

                        <div class="activity-entry">
                            <div class="activity-icon icon-green">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                            </div>
                            <div class="activity-info">
                                <p>Approved scholarship for <strong>Maria Reyes</strong></p>
                                <span>Mar 1, 2026 · 10:42 AM</span>
                            </div>
                        </div>

                        <div class="activity-entry">
                            <div class="activity-icon icon-violet">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 1 8.835-2.535m0 0A23.74 23.74 0 0 1 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46"/></svg>
                            </div>
                            <div class="activity-info">
                                <p>Published announcement: <strong>Scholarship Program 2026</strong></p>
                                <span>Feb 28, 2026 · 2:15 PM</span>
                            </div>
                        </div>

                        <div class="activity-entry">
                            <div class="activity-icon icon-amber">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>
                            </div>
                            <div class="activity-info">
                                <p>Flagged community post for review</p>
                                <span>Feb 27, 2026 · 9:00 AM</span>
                            </div>
                        </div>

                        <div class="activity-entry">
                            <div class="activity-icon icon-red">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                            </div>
                            <div class="activity-info">
                                <p>Declined medical request for <strong>Pedro Santos</strong></p>
                                <span>Feb 26, 2026 · 4:30 PM</span>
                            </div>
                        </div>

                    </div>
                </section>

            </aside>
        </div>

        <div class="admin-bottom-row">

            <!-- MEMBER REGISTRATIONS -->
            <section class="chart-panel chart-panel--stretch">
                <div class="panel-header">
                    <h2 class="section-label">Member Registrations</h2>
                    <span class="chart-period">Last 6 months</span>
                </div>
                <div class="sparkline-wrap sparkline-wrap--grow">
                    <svg class="sparkline-svg sparkline-svg--tall" viewBox="0 0 560 120" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="sparkGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#7c3aed" stop-opacity="0.25"/>
                                <stop offset="100%" stop-color="#7c3aed" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <path d="M0,90 L93,74 L186,60 L280,42 L373,26 L466,14 L560,4"
                              fill="none" stroke="#7c3aed" stroke-width="2.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M0,90 L93,74 L186,60 L280,42 L373,26 L466,14 L560,4 L560,120 L0,120 Z"
                              fill="url(#sparkGrad)"/>
                    </svg>
                    <div class="sparkline-labels">
                        <span>Sep</span><span>Oct</span><span>Nov</span><span>Dec</span><span>Jan</span><span>Feb</span>
                    </div>
                    <div class="sparkline-stats sparkline-stats--quad">
                        <div class="spark-stat">
                            <span class="spark-val">+12</span>
                            <span class="spark-lbl">This month</span>
                        </div>
                        <div class="spark-stat">
                            <span class="spark-val">348</span>
                            <span class="spark-lbl">Total members</span>
                        </div>
                        <div class="spark-stat">
                            <span class="spark-val">94%</span>
                            <span class="spark-lbl">Active rate</span>
                        </div>
                        <div class="spark-stat">
                            <span class="spark-val">+61</span>
                            <span class="spark-lbl">Since Sep</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- UPCOMING EVENTS -->
            <section class="chart-panel chart-panel--stretch">
                <div class="panel-header">
                    <h2 class="section-label">Upcoming Events</h2>
                    <a href="events.php" class="btn-admin-sm">Manage &rsaquo;</a>
                </div>
                <ul class="admin-events-list admin-events-list--grow">
                    <li class="admin-event-item">
                        <div class="event-date-badge">
                            <span class="event-day">10</span>
                            <span class="event-mon">Mar</span>
                        </div>
                        <div class="event-info">
                            <strong>SK General Assembly</strong>
                            <span>Barangay Hall · 9:00 AM</span>
                        </div>
                    </li>
                    <li class="admin-event-item">
                        <div class="event-date-badge">
                            <span class="event-day">15</span>
                            <span class="event-mon">Mar</span>
                        </div>
                        <div class="event-info">
                            <strong>Livelihood Training Workshop</strong>
                            <span>Community Center · 1:00 PM</span>
                        </div>
                    </li>
                    <li class="admin-event-item">
                        <div class="event-date-badge">
                            <span class="event-day">22</span>
                            <span class="event-mon">Mar</span>
                        </div>
                        <div class="event-info">
                            <strong>Medical Mission</strong>
                            <span>Barangay Plaza · 8:00 AM</span>
                        </div>
                    </li>
                    <li class="admin-event-item">
                        <div class="event-date-badge">
                            <span class="event-day">28</span>
                            <span class="event-mon">Mar</span>
                        </div>
                        <div class="event-info">
                            <strong>Youth Leadership Seminar</strong>
                            <span>Municipal Hall · 10:00 AM</span>
                        </div>
                    </li>
                </ul>
            </section>

        </div>

    </main>
</div>

<script src="../../scripts/admin/admin_dashboard.js"></script>

</body>
</html>