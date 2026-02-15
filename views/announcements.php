<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Announcements</title>

    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/announcements.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/footer.css">
</head>
<body>

<div id="navbar"></div>

<main class="announcements-page">

    <!-- HEADER SECTION -->
    <section class="announcements-header">
        <div class="header-text">
            <h1>Community Announcements</h1>
            <p>Stay updated with official announcements from the SK of Barangay Sauyo.</p>
        </div>

        <div class="header-controls">
            <input type="text" placeholder="Search announcements..." class="search-input">

            <select class="filter-category">
                <option value="all">All Categories</option>
                <option value="programs">Programs</option>
                <option value="events">Events</option>
                <option value="emergency">Emergency</option>
                <option value="meetings">Meetings</option>
                <option value="notices">Public Notices</option>
            </select>

            <select class="sort-order">
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="views">Most Viewed</option>
            </select>
        </div>
    </section>

    <!-- FEATURED ANNOUNCEMENT -->
    <section class="featured-section">
        <article class="featured-announcement">
            <span class="badge urgent">URGENT</span>

            <h2>Emergency Youth Assembly</h2>

            <p>
                All registered SK members are required to attend on February 20, 2026 at 3:00 PM 
                at the Barangay Hall.
            </p>

            <div class="meta">
                <span>Posted by: SK Chairperson</span>
                <time datetime="2026-02-14">February 14, 2026</time>
            </div>

            <a href="announcement-view.html" class="btn-primary">View Full Details</a>
        </article>
    </section>

    <!-- ANNOUNCEMENTS LIST -->
    <section class="announcements-list">
        <div class="announcements-grid">

            <!-- ANNOUNCEMENT CARD 1 -->
            <article class="announcement-card">
                <div class="card-image">
                    <img src="../assets/img/scholar.jpg" alt="Scholarship Program">
                </div>

                <div class="card-content">
                    <span class="badge program">Program</span>

                    <h3>Scholarship Program 2026</h3>

                    <p class="excerpt">
                        The SK Scholarship Program is now open for eligible youth residents 
                        of Barangay Sauyo. Submit your applications before March 10, 2026.
                    </p>

                    <div class="card-meta">
                        <span>By: SK Secretary</span>
                        <time datetime="2026-02-10">Feb 10, 2026</time>
                        <span>👁 124 views</span>
                    </div>

                    <div class="card-actions">
                        <a href="announcement-view.html" class="btn-secondary">Read More</a>
                        <button class="bookmark-btn">🔖</button>
                    </div>
                </div>
            </article>

            <!-- ANNOUNCEMENT CARD 2 -->
            <article class="announcement-card">
                <div class="card-image">
                    <img src="../assets/img/medical.jpg" alt="Medical Assistance Program">
                </div>

                <div class="card-content">
                    <span class="badge event">Event</span>

                    <h3>Medical Assistance Program</h3>

                    <p class="excerpt">
                        Youth residents may now submit medical assistance requests online 
                        through the SK Transparency System.
                    </p>

                    <div class="card-meta">
                        <span>By: SK Treasurer</span>
                        <time datetime="2026-01-25">Jan 25, 2026</time>
                        <span>👁 89 views</span>
                    </div>

                    <div class="card-actions">
                        <a href="announcement-view.html" class="btn-secondary">Read More</a>
                        <button class="bookmark-btn">🔖</button>
                    </div>
                </div>
            </article>

        </div>
    </section>

    <!-- PAGINATION -->
    <section class="pagination">
        <button class="page-btn">Previous</button>
        <span class="page-number">Page 1 of 5</span>
        <button class="page-btn">Next</button>
    </section>

</main>

<div id="footer"></div>

<script src="../scripts/main.js"></script>

</body>
</html>
