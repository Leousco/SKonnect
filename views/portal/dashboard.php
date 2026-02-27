<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Dashboard</title>
    <link rel="stylesheet" href="../../styles/portal/dashboard.css">

    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/portal/sidebar.css">
    <link rel="stylesheet" href="../../styles/portal/topbar.css">
</head>
<body>

<div class="dashboard-layout">

    <?php include __DIR__ . '/../../components/portal/sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="dashboard-content">

    <?php
    $pageTitle      = 'Dashboard';
    $pageBreadcrumb = [['Home', '#'], ['Dashboard', null]];
    $userName       = 'Juan Dela Cruz';
    $userRole       = 'SK Member';
    $notifCount     = 3;
    include __DIR__ . '/../../components/portal/topbar.php';
    ?>

        <!-- DASHBOARD WIDGETS -->
        <section class="dashboard-widgets">

            <div class="widget-card">
                <h3>Active Requests</h3>
                <p class="widget-number">2</p>
                <span class="widget-sub">Currently being reviewed</span>
            </div>

            <div class="widget-card">
                <h3>Community Posts</h3>
                <p class="widget-number">12</p>
                <span class="widget-sub">Your contributions</span>
            </div>

            <div class="widget-card">
                <h3>Unread Notifications</h3>
                <p class="widget-number">3</p>
                <span class="widget-sub">Check updates</span>
            </div>

            <div class="widget-card">
                <h3>Upcoming Events</h3>
                <p class="widget-number">1</p>
                <span class="widget-sub">This month</span>
            </div>

        </section>

        <!-- TWO-COLUMN: ACTIVITY + ANNOUNCEMENTS -->
        <div class="dashboard-lower">

            <!-- RECENT ACTIVITY -->
            <section class="recent-activity">
                <h2 class="section-label">Recent Activity</h2>

                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <div class="activity-meta">
                        <span class="activity-date">Feb 20, 2026</span>
                        <p>Your scholarship request has been approved.</p>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <div class="activity-meta">
                        <span class="activity-date">Feb 18, 2026</span>
                        <p>You commented on a community post.</p>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <div class="activity-meta">
                        <span class="activity-date">Feb 15, 2026</span>
                        <p>You submitted a medical assistance request.</p>
                    </div>
                </div>
            </section>

            <!-- MINI ANNOUNCEMENTS FEED -->
            <section class="mini-announcements">
                <h2 class="section-label">Latest Announcements</h2>
                <ul class="announcement-list">
                    <li>
                        <a href="announcements.php">Scholarship Program 2026 opens – Feb 10</a>
                    </li>
                    <li>
                        <a href="announcements.php">Medical Assistance Submission Deadline – Feb 20</a>
                    </li>
                    <li>
                        <a href="announcements.php">Emergency Youth Assembly – Feb 22</a>
                    </li>
                </ul>
                <a href="announcements.php" class="btn-small">View All Announcements &rsaquo;</a>
            </section>

        </div>

        <!-- CALENDAR SECTION -->
        <section class="calendar-section">
            <h2 class="section-label">Upcoming Events</h2>

            <div class="calendar">
                <div class="calendar-header">
                    <button class="calendar-nav-btn prev-month" aria-label="Previous month">&#8249;</button>
                    <span class="month-year"></span>
                    <button class="calendar-nav-btn next-month" aria-label="Next month">&#8250;</button>
                </div>

                <div class="calendar-days">
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                </div>

                <div class="calendar-dates">
                    <!-- Populated by JS -->
                </div>

                <div class="calendar-legend">
                    <div class="legend-item">
                        <div class="legend-dot today"></div>
                        <span>Today</span>
                    </div>
                    <div class="legend-item" id="legend-events">
                        <!-- color swatches injected by JS -->
                    </div>
                </div>
            </div>

            <!-- UPCOMING EVENTS LIST -->
            <div class="events-list-wrap">
                <h3 class="events-list-title">Events This Month</h3>
                <ul class="events-list" id="events-list">
                    <!-- Populated by JS -->
                </ul>
                <p class="events-empty" id="events-empty" style="display:none;">No events scheduled for this month.</p>
            </div>
        </section>

    </main>
</div>

<script src="../../scripts/portal/dashboard.js"></script>

</body>
</html>