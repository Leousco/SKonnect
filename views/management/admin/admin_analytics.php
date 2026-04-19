<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireAdmin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect Admin | Analytics</title>
    <link rel="stylesheet" href="../../../styles/management/mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_topbar.css">
    <link rel="stylesheet" href="../../../styles/management/admin/admin_analytics.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
<div class="admin-layout">

    <?php include __DIR__ . '/../../../components/management/admin/admin_sidebar.php'; ?>

    <main class="admin-content">

        <?php
        $pageTitle      = 'Analytics';
        $pageBreadcrumb = [['Home', '#'], ['Reports & Logs', '#'], ['Analytics', null]];
        $adminName      = $_SESSION['user_name'] ?? 'Admin';
        $adminRole      = 'System Admin';
        $notifCount     = 7;
        include __DIR__ . '/../../../components/management/admin/admin_topbar.php';
        ?>

        <!-- STAT CARDS -->
        <section class="an-stats">

            <div class="an-stat-card">
                <div class="an-stat-icon icon-violet">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                    </svg>
                </div>
                <div class="an-stat-body">
                    <span class="an-stat-label">Total Users</span>
                    <p class="an-stat-value" data-target="348">0</p>
                    <span class="an-stat-sub trend-up">&#9650; 12 this month</span>
                </div>
            </div>

            <div class="an-stat-card">
                <div class="an-stat-icon icon-amber">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                    </svg>
                </div>
                <div class="an-stat-body">
                    <span class="an-stat-label">Total Service Requests</span>
                    <p class="an-stat-value" data-target="142">0</p>
                    <span class="an-stat-sub trend-up">&#9650; 24 this month</span>
                </div>
            </div>

            <div class="an-stat-card">
                <div class="an-stat-icon icon-green">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>
                    </svg>
                </div>
                <div class="an-stat-body">
                    <span class="an-stat-label">Most Requested Service</span>
                    <p class="an-stat-value an-stat-value--text">Scholarship</p>
                    <span class="an-stat-sub">18 requests this month</span>
                </div>
            </div>

            <div class="an-stat-card">
                <div class="an-stat-icon icon-indigo">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"/>
                    </svg>
                </div>
                <div class="an-stat-body">
                    <span class="an-stat-label">Active Users</span>
                    <p class="an-stat-value" data-target="327">0</p>
                    <span class="an-stat-sub">21 inactive</span>
                </div>
            </div>

        </section>

        <!-- CHARTS ROW -->
        <div class="an-charts-row">

            <!-- Requests Per Month (Bar) -->
            <section class="an-chart-panel an-chart-panel--wide">
                <div class="an-panel-header">
                    <div>
                        <h2 class="an-panel-title">Service Requests Per Month</h2>
                        <p class="an-panel-sub">Monthly volume across all service types</p>
                    </div>
                    <select class="an-select" id="reqYearFilter">
                        <option value="2026">2026</option>
                        <option value="2025">2025</option>
                    </select>
                </div>
                <div class="an-chart-wrap">
                    <canvas id="requestsBarChart"></canvas>
                </div>
            </section>

            <!-- Service Type Breakdown (Donut) -->
            <section class="an-chart-panel">
                <div class="an-panel-header">
                    <div>
                        <h2 class="an-panel-title">Requests by Service Type</h2>
                        <p class="an-panel-sub">Distribution for Feb 2026</p>
                    </div>
                </div>
                <div class="an-chart-wrap an-chart-wrap--donut">
                    <canvas id="serviceDonutChart"></canvas>
                </div>
                <ul class="an-legend">
                    <li><span class="an-legend-dot" style="background:#7c3aed"></span>Scholarship <strong>18</strong></li>
                    <li><span class="an-legend-dot" style="background:#f59e0b"></span>Medical Assist. <strong>11</strong></li>
                    <li><span class="an-legend-dot" style="background:#6366f1"></span>Livelihood <strong>7</strong></li>
                    <li><span class="an-legend-dot" style="background:#0d9488"></span>Legal Aid <strong>4</strong></li>
                    <li><span class="an-legend-dot" style="background:#94a3b8"></span>Others <strong>2</strong></li>
                </ul>
            </section>

        </div>

        <!-- SECOND CHARTS ROW -->
        <div class="an-charts-row">

            <!-- User Growth (Line) -->
            <section class="an-chart-panel an-chart-panel--wide">
                <div class="an-panel-header">
                    <div>
                        <h2 class="an-panel-title">User Growth</h2>
                        <p class="an-panel-sub">Cumulative registered users — last 12 months</p>
                    </div>
                </div>
                <div class="an-chart-wrap">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </section>

            <!-- Active vs Inactive (Horizontal Bar) -->
            <section class="an-chart-panel">
                <div class="an-panel-header">
                    <div>
                        <h2 class="an-panel-title">Active vs Inactive Users</h2>
                        <p class="an-panel-sub">Current user status breakdown</p>
                    </div>
                </div>
                <div class="an-active-display">
                    <div class="an-active-ring-wrap">
                        <canvas id="activeDonutChart"></canvas>
                        <div class="an-active-center">
                            <span class="an-active-pct">94%</span>
                            <span class="an-active-lbl">Active</span>
                        </div>
                    </div>
                </div>
                <div class="an-active-stats">
                    <div class="an-active-stat">
                        <span class="an-active-dot dot-green"></span>
                        <div>
                            <strong>327</strong>
                            <span>Active users</span>
                        </div>
                    </div>
                    <div class="an-active-stat">
                        <span class="an-active-dot dot-red"></span>
                        <div>
                            <strong>21</strong>
                            <span>Inactive users</span>
                        </div>
                    </div>
                </div>
            </section>

        </div>

    </main>
</div>

<script src="../../../scripts/management/admin/admin_analytics.js"></script>
</body>
</html>