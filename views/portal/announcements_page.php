<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Announcements Page</title>
    <link rel="stylesheet" href="../../styles/portal/announcements_page.css">

    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/portal/sidebar.css">
    <link rel="stylesheet" href="../../styles/portal/topbar.css">
    <link rel="stylesheet" href="../../styles/portal/dashboard.css">
</head>
<body>

<div class="dashboard-layout">

    <?php include __DIR__ . '/../../components/portal/sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="dashboard-content">

    <?php
    $pageTitle      = 'Announcements';
    $pageBreadcrumb = [['Home', '#'], ['Announcements', null]];
    $userName       = 'Juan Dela Cruz';
    $userRole       = 'SK Member';
    $notifCount     = 3;
    include __DIR__ . '/../../components/portal/topbar.php';
    ?>

        <!-- STATS WIDGETS -->
        <section class="dashboard-widgets">
            <div class="widget-card">
                <h3>Total Announcements</h3>
                <p class="widget-number">24</p>
                <span class="widget-sub">All categories</span>
            </div>
            <div class="widget-card">
                <h3>New This Month</h3>
                <p class="widget-number">5</p>
                <span class="widget-sub">Since Feb 1, 2026</span>
            </div>
            <div class="widget-card">
                <h3>Urgent Notices</h3>
                <p class="widget-number">1</p>
                <span class="widget-sub">Requires attention</span>
            </div>
            <div class="widget-card">
                <h3>Bookmarked</h3>
                <p class="widget-number">3</p>
                <span class="widget-sub">Saved by you</span>
            </div>
        </section>

        <!-- FEATURED ANNOUNCEMENT -->
        <section class="featured-section">
            <h2 class="section-label">Featured Announcement</h2>

            <article class="featured-card">
                <div class="featured-badge-wrap">
                    <span class="ann-badge urgent">URGENT</span>
                    <span class="ann-badge category-event">Event</span>
                </div>
                <div class="featured-body">
                    <h3 class="featured-title">Emergency Youth Assembly</h3>
                    <p class="featured-excerpt">
                        All registered SK members are required to attend an Emergency Youth Assembly 
                        on <strong>February 20, 2026 at 3:00 PM</strong> at the Barangay Hall. 
                        Attendance is mandatory for all SK officers and youth representatives.
                    </p>
                    <div class="featured-meta">
                        <span class="meta-author">📌 Posted by: SK Chairperson</span>
                        <time class="meta-date" datetime="2026-02-14">February 14, 2026</time>
                        <span class="meta-views">👁 312 views</span>
                    </div>
                </div>
                <div class="featured-action">
                    <a href="announcement-view.php" class="btn-primary-portal">View Full Details</a>
                </div>
            </article>
        </section>

        <!-- CONTROLS: SEARCH + FILTER + SORT -->
        <section class="announcements-controls">
            <div class="controls-left">
                <div class="search-wrap">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="ann-search" placeholder="Search announcements..." class="ann-search-input">
                </div>
            </div>
            <div class="controls-right">
                <select id="ann-category" class="ann-select">
                    <option value="all">All Categories</option>
                    <option value="programs">Programs</option>
                    <option value="events">Events</option>
                    <option value="emergency">Emergency</option>
                    <option value="meetings">Meetings</option>
                    <option value="notices">Public Notices</option>
                </select>
                <select id="ann-sort" class="ann-select">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="views">Most Viewed</option>
                </select>
            </div>
        </section>

        <!-- ANNOUNCEMENTS GRID -->
        <section class="announcements-section">
            <h2 class="section-label">All Announcements</h2>

            <div class="announcements-grid">

                <!-- CARD 1 -->
                <article class="ann-card" data-category="programs">
                    <div class="ann-card-image">
                        <img src="../../assets/img/scholar.jpg" alt="Scholarship Program">
                        <span class="ann-badge category-program img-badge">Program</span>
                    </div>
                    <div class="ann-card-body">
                        <h3 class="ann-card-title">Scholarship Program 2026</h3>
                        <p class="ann-card-excerpt">
                            The SK Scholarship Program is now open for eligible youth residents 
                            of Barangay Sauyo. Submit your applications before March 10, 2026.
                        </p>
                        <div class="ann-card-meta">
                            <span>By: SK Secretary</span>
                            <time datetime="2026-02-10">Feb 10, 2026</time>
                            <span>👁 124 views</span>
                        </div>
                        <div class="ann-card-actions">
                            <a href="announcement-view.php" class="btn-secondary-portal">Read More</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>

                <!-- CARD 2 -->
                <article class="ann-card" data-category="events">
                    <div class="ann-card-image">
                        <img src="../../assets/img/medical.jpg" alt="Medical Assistance Program">
                        <span class="ann-badge category-event img-badge">Event</span>
                    </div>
                    <div class="ann-card-body">
                        <h3 class="ann-card-title">Medical Assistance Program</h3>
                        <p class="ann-card-excerpt">
                            Youth residents may now submit medical assistance requests online 
                            through the SK Transparency System portal.
                        </p>
                        <div class="ann-card-meta">
                            <span>By: SK Treasurer</span>
                            <time datetime="2026-01-25">Jan 25, 2026</time>
                            <span>👁 89 views</span>
                        </div>
                        <div class="ann-card-actions">
                            <a href="announcement-view.php" class="btn-secondary-portal">Read More</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>

                <!-- CARD 3 -->
                <article class="ann-card" data-category="events">
                    <div class="ann-card-image">
                        <img src="../../assets/img/clean.jpg" alt="Community Clean-Up Drive">
                        <span class="ann-badge category-event img-badge">Event</span>
                    </div>
                    <div class="ann-card-body">
                        <h3 class="ann-card-title">Community Clean-Up Drive</h3>
                        <p class="ann-card-excerpt">
                            Join us for a barangay-wide clean-up drive on March 15, 2026. 
                            All SK youth volunteers are encouraged to participate.
                        </p>
                        <div class="ann-card-meta">
                            <span>By: SK Chairperson</span>
                            <time datetime="2026-03-15">Mar 15, 2026</time>
                            <span>👁 74 views</span>
                        </div>
                        <div class="ann-card-actions">
                            <a href="announcement-view.php" class="btn-secondary-portal">Read More</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>

                <!-- CARD 4 -->
                <article class="ann-card" data-category="events">
                    <div class="ann-card-image">
                        <img src="../../assets/img/assembly.jpg" alt="Emergency Youth Assembly">
                        <span class="ann-badge urgent img-badge">Urgent</span>
                    </div>
                    <div class="ann-card-body">
                        <h3 class="ann-card-title">Emergency Youth Assembly</h3>
                        <p class="ann-card-excerpt">
                            All SK constituents are invited to attend the Emergency Youth Assembly 
                            on February 22, 2026 at the Barangay Hall, 2:00 PM.
                        </p>
                        <div class="ann-card-meta">
                            <span>By: SK Chairperson</span>
                            <time datetime="2026-02-22">Feb 22, 2026</time>
                            <span>👁 217 views</span>
                        </div>
                        <div class="ann-card-actions">
                            <a href="announcement-view.php" class="btn-secondary-portal">Read More</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>

                <!-- CARD 5 -->
                <article class="ann-card" data-category="meetings">
                    <div class="ann-card-image placeholder-img">
                        <img src="../../assets/img/meeting.jpg" alt="Emergency Youth Assembly">
                        <span class="ann-badge category-meeting img-badge">Meeting</span>
                    </div>
                    <div class="ann-card-body">
                        <h3 class="ann-card-title">Monthly SK Officers Meeting</h3>
                        <p class="ann-card-excerpt">
                            The regular monthly meeting of SK officers will be held on 
                            March 5, 2026 at 9:00 AM at the SK Office.
                        </p>
                        <div class="ann-card-meta">
                            <span>By: SK Secretary</span>
                            <time datetime="2026-02-28">Feb 28, 2026</time>
                            <span>👁 41 views</span>
                        </div>
                        <div class="ann-card-actions">
                            <a href="announcement-view.php" class="btn-secondary-portal">Read More</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>

                <!-- CARD 6 -->
                <article class="ann-card" data-category="notices">
                    <div class="ann-card-image placeholder-img">
                        <img src="../../assets/img/annual.jpg" alt="Emergency Youth Assembly">
                        <span class="ann-badge category-notice img-badge">Public Notice</span>
                    </div>
                    <div class="ann-card-body">
                        <h3 class="ann-card-title">Annual Budget Transparency Report</h3>
                        <p class="ann-card-excerpt">
                            The SK Annual Budget Transparency Report for FY 2025 is now available 
                            for public viewing at the Barangay Hall and online portal.
                        </p>
                        <div class="ann-card-meta">
                            <span>By: SK Treasurer</span>
                            <time datetime="2026-02-01">Feb 1, 2026</time>
                            <span>👁 190 views</span>
                        </div>
                        <div class="ann-card-actions">
                            <a href="announcement-view.php" class="btn-secondary-portal">Read More</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>

            </div>

            <!-- NO RESULTS MESSAGE -->
            <div class="no-results" id="no-results" style="display:none;">
                <p>No announcements found matching your search.</p>
            </div>
        </section>

        <!-- PAGINATION -->
        <section class="pagination-section">
            <button class="page-btn" id="prev-btn" disabled>&#8249; Previous</button>
            <div class="page-numbers" id="page-numbers">
                <button class="page-num active">1</button>
                <button class="page-num">2</button>
                <button class="page-num">3</button>
                <button class="page-num">4</button>
                <button class="page-num">5</button>
            </div>
            <button class="page-btn" id="next-btn">Next &#8250;</button>
        </section>

    </main>
</div>

<script src="../../scripts/portal/announcements_page.js"></script>
</body>
</html>