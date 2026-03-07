<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Announcements Page</title>
    <link rel="stylesheet" href="../../styles/portal/announcements_page.css">
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/portal/sidebar.css">
    <link rel="stylesheet" href="../../styles/portal/topbar.css">
</head>
<body>

<div class="dashboard-layout">

    <?php include __DIR__ . '/../../components/portal/sidebar.php'; ?>

    <main class="dashboard-content">

    <?php
    $pageTitle      = 'Announcements';
    $pageBreadcrumb = [['Home', '#'], ['Announcements', null]];
    $userName       = $_SESSION['user_name'] ?? 'Juan Dela Cruz';
    $userRole       = $_SESSION['user_role'] ?? 'SK Member';
    $notifCount     = 3;
    include __DIR__ . '/../../components/portal/topbar.php';

    // Load data server-side for initial render (SSR)
    require_once __DIR__ . '/../../backend/models/AnnouncementModel.php';
    $annModel  = new AnnouncementModel();
    $annModel->archiveExpired();   // auto-expire on page load
    $featured  = $annModel->getFeatured();
    $annList   = $annModel->getActive();
    ?>

        <!-- FEATURED ANNOUNCEMENT -->
        <section class="featured-section">
            <h2 class="section-label">Featured Announcement</h2>

            <?php if ($featured): ?>
            <article class="featured-card">
                <div class="featured-badge-wrap">
                    <span class="ann-badge featured">FEATURED</span>
                    <span class="ann-badge category-<?= htmlspecialchars($featured['category']) ?>">
                        <?= ucfirst(htmlspecialchars($featured['category'])) ?>
                    </span>
                </div>
                <div class="featured-body">
                    <h3 class="featured-title"><?= htmlspecialchars($featured['title']) ?></h3>
                    <p class="featured-excerpt">
                        <?= nl2br(htmlspecialchars(mb_substr($featured['content'], 0, 300))) ?>…
                    </p>
                    <div class="featured-meta">
                        <span class="meta-author">📌 Posted by: <?= htmlspecialchars($featured['author_name']) ?></span>
                        <time class="meta-date" datetime="<?= date('Y-m-d', strtotime($featured['published_at'])) ?>">
                            <?= date('F j, Y', strtotime($featured['published_at'])) ?>
                        </time>
                    </div>
                </div>
                <div class="featured-action">
                    <a href="announcement_view.php?id=<?= (int)$featured['id'] ?>" class="btn-primary-portal">View Full Details</a>
                </div>
            </article>
            <?php else: ?>
            <p class="no-featured-msg">No featured announcement at this time.</p>
            <?php endif; ?>
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
                    <option value="event">Events</option>
                    <option value="program">Programs</option>
                    <option value="meeting">Meetings</option>
                    <option value="notice">Notices</option>
                    <option value="urgent">Urgent</option>
                </select>
                <select id="ann-sort" class="ann-select">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                </select>
            </div>
        </section>

        <!-- ANNOUNCEMENTS GRID -->
        <section class="announcements-section">
            <h2 class="section-label">All Announcements</h2>

            <div class="announcements-grid" id="announcements-grid">

                <?php if (empty($annList)): ?>
                <p class="no-results-msg">No announcements available.</p>
                <?php else: ?>

                <?php foreach ($annList as $ann): ?>
                <article class="ann-card" data-category="<?= htmlspecialchars($ann['category']) ?>"
                         data-title="<?= htmlspecialchars(strtolower($ann['title'])) ?>"
                         data-date="<?= htmlspecialchars($ann['published_at']) ?>">

                    <div class="ann-card-image">
                        <?php if ($ann['banner_img']): ?>
                            <img src="<?= htmlspecialchars($ann['banner_img']) ?>" alt="<?= htmlspecialchars($ann['title']) ?>">
                        <?php else: ?>
                            <div class="ann-card-placeholder-img"></div>
                        <?php endif; ?>
                        <span class="ann-badge category-<?= htmlspecialchars($ann['category']) ?> img-badge">
                            <?= ucfirst(htmlspecialchars($ann['category'])) ?>
                        </span>
                    </div>

                    <div class="ann-card-body">
                        <h3 class="ann-card-title"><?= htmlspecialchars($ann['title']) ?></h3>
                        <p class="ann-card-excerpt">
                            <?= htmlspecialchars(mb_substr($ann['content'], 0, 160)) ?>…
                        </p>
                        <div class="ann-card-meta">
                            <span>By: <?= htmlspecialchars($ann['author_name']) ?></span>
                            <time datetime="<?= date('Y-m-d', strtotime($ann['published_at'])) ?>">
                                <?= date('M j, Y', strtotime($ann['published_at'])) ?>
                            </time>
                        </div>
                        <div class="ann-card-actions">
                            <a href="announcement_view.php?id=<?= (int)$ann['id'] ?>" class="btn-secondary-portal">Read More</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
                <?php endif; ?>

            </div>

            <!-- NO RESULTS MESSAGE -->
            <div class="no-results" id="no-results" style="display:none;">
                <p>No announcements found matching your search.</p>
            </div>
        </section>

        <!-- PAGINATION -->
        <section class="pagination-section">
            <button class="page-btn" id="prev-btn" disabled>&#8249; Previous</button>
            <div class="page-numbers" id="page-numbers"></div>
            <button class="page-btn" id="next-btn">Next &#8250;</button>
        </section>

    </main>
</div>

<script src="../../scripts/portal/announcements_page.js"></script>
</body>
</html>