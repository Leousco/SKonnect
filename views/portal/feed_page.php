<?php
require_once __DIR__ . '/../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireAuth();

require_once __DIR__ . '/../../backend/config/database.php';
require_once __DIR__ . '/../../backend/models/ThreadModel.php';

$db      = new Database();
$conn    = $db->getConnection();
$user_id = $_SESSION['user_id'] ?? null;

$threadModel = new ThreadModel($conn);
$threads     = $threadModel->getFeedThreads((int)$user_id);

// Category label map
$cat_labels = [
    'inquiry'        => 'Inquiry',
    'complaint'      => 'Complaint',
    'suggestion'     => 'Suggestion',
    'event_question' => 'Event',
    'other'          => 'Other',
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Community Feed</title>

    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/portal/sidebar.css">
    <link rel="stylesheet" href="../../styles/portal/topbar.css">
    <link rel="stylesheet" href="../../styles/portal/feed_page.css">
</head>

<body>

    <div class="dashboard-layout">

        <?php include __DIR__ . '/../../components/portal/sidebar.php'; ?>

        <main class="dashboard-content">

            <?php
            $pageTitle      = 'Community Feed';
            $pageBreadcrumb = [['Home', '#'], ['Community Feed', null]];
            $userName       = $_SESSION['user_name'] ?? 'Guest';
            $userRole       = 'Resident';
            $notifCount     = 3;
            include __DIR__ . '/../../components/portal/topbar.php';
            ?>

            <!-- CONTROLS -->
            <section class="announcements-controls">
                <div class="controls-left">
                    <button class="btn-primary-portal" id="submit-concern-btn">
                        Post a Thread
                    </button>
                    <a href="bookmarks_page.php" class="btn-outline-portal" id="bookmarks-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#facc15" fill="#facc15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bmb-icon">
                            <path fill="inherit" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                        </svg> My Bookmarks
                    </a>
                    <div class="search-wrap">
                        <span class="search-icon">🔍</span>
                        <input type="text" id="feed-search" placeholder="Search threads…" class="ann-search-input">
                    </div>
                </div>
                <div class="controls-right">
                    <select id="feed-category" class="ann-select">
                        <option value="all">All Categories</option>
                        <option value="inquiry">Inquiry</option>
                        <option value="complaint">Complaint</option>
                        <option value="suggestion">Suggestion</option>
                        <option value="event_question">Event Question</option>
                        <option value="other">Other</option>
                    </select>
                    <select id="feed-status" class="ann-select">
                        <option value="all">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="responded">Responded</option>
                        <option value="resolved">Resolved</option>
                    </select>
                    <select id="feed-sort" class="ann-select">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="comments">Most Comments</option>
                        <option value="supports">Most Supported</option>
                    </select>
                </div>
            </section>

            <!-- FEED GRID -->
            <section class="announcements-section">
                <h2 class="section-label">Community Threads</h2>

                <div class="announcements-grid" id="feed-grid">

                    <?php if (empty($threads)) : ?>
                        <div class="no-results" id="no-results" style="display:block;">
                            <p>No threads yet. Be the first to post one!</p>
                        </div>
                    <?php else : ?>
                        <?php foreach ($threads as $t) :
                            $cat_key        = $t['category'];
                            $cat_label      = $cat_labels[$cat_key] ?? 'Other';
                            $is_bookmarked  = (bool)$t['is_bookmarked'];
                            $user_supported = (bool)$t['user_supported'];
                            $date_fmt       = date('M j, Y', strtotime($t['created_at']));
                        ?>
                            <article class="ann-card feed-card" onclick="if(!event.target.closest('button, a')){ window.location.href='thread_view.php?id=<?= (int)$t['id'] ?>'; }" style="cursor: pointer;" data-category="<?= htmlspecialchars($cat_key) ?>" data-status="<?= htmlspecialchars($t['status']) ?>" data-date="<?= $t['created_at'] ?>" data-comments="<?= (int)$t['comment_count'] ?>" data-supports="<?= (int)$t['support_count'] ?>" data-pinned="<?= !empty($t['is_pinned']) ? '1' : '0' ?>">
                                <div class="ann-card-body">

                                    <!-- BADGES: category + status only (priority removed) -->
                                    <div class="feed-card-badges">
                                        <?php if (!empty($t['is_pinned'])) : ?>
                                            <span class="feed-pin-badge">📌 Pinned</span>
                                        <?php endif; ?>
                                        <span class="ann-badge category-<?= $cat_key ?>"><?= $cat_label ?></span>
                                        <span class="feed-badge status-<?= $t['status'] ?>"><?= ucfirst($t['status']) ?></span>
                                    </div>

                                    <h3 class="ann-card-title"><?= htmlspecialchars($t['subject']) ?></h3>
                                    <p class="ann-card-excerpt"><?= htmlspecialchars(mb_substr($t['message'], 0, 160)) ?><?= mb_strlen($t['message']) > 160 ? '…' : '' ?></p>

                                    <div class="ann-card-meta">
                                        <span>By: <?= htmlspecialchars($t['author_name']) ?></span>
                                        <time datetime="<?= $t['created_at'] ?>"><?= $date_fmt ?></time>
                                    </div>

                                    <div class="ann-card-actions">

                                        <!-- LEFT: SUPPORT BUTTON (icon + count only) -->
                                        <button class="support-btn <?= $user_supported ? 'active' : '' ?>" data-thread-id="<?= (int)$t['id'] ?>" title="<?= $user_supported ? 'Remove support' : 'I support this' ?>">
                                            <img src="../../assets/img/handshake-icon.png" alt="Support" class="support-icon">
                                            <span class="support-count"><?= (int)$t['support_count'] ?></span>
                                        </button>

                                        <!-- RIGHT: COMMENT + BOOKMARK -->
                                        <div class="card-actions-right">
                                            <a href="thread_view.php?id=<?= (int)$t['id'] ?>" class="btn-secondary-portal">
                                                💬 <?= (int)$t['comment_count'] ?> <?= $t['comment_count'] == 1 ? 'Comment' : 'Comments' ?>
                                            </a>
                                            <button class="bookmark-btn <?= $is_bookmarked ? 'active' : '' ?>" data-thread-id="<?= (int)$t['id'] ?>" title="<?= $is_bookmarked ? 'Remove bookmark' : 'Bookmark' ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="bm-icon">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                                </svg>
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>

                <div class="no-results" id="no-results" style="display:none;">
                    <p>No threads found matching your search.</p>
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

    <!-- POST A THREAD MODAL -->
    <div class="modal-overlay" id="modal-overlay" style="display:none;" aria-modal="true" role="dialog" aria-labelledby="modal-title">
        <div class="modal-box">

            <div class="modal-header">
                <div class="modal-header-left">
                    <div class="modal-icon">✏️</div>
                    <div>
                        <h3 id="modal-title">Post a Thread</h3>
                        <p class="modal-subtitle">Fields marked <span class="required-star">*</span> are required.</p>
                    </div>
                </div>
                <button class="modal-close" id="modal-close" aria-label="Close">&times;</button>
            </div>

            <div class="modal-body">
                <form id="thread-form" novalidate>

                    <!-- Category (priority removed) -->
                    <div class="form-group">
                        <label class="modal-label" for="m-category">Category <span class="required-star">*</span></label>
                        <select class="ann-select modal-select" id="m-category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="inquiry">Inquiry</option>
                            <option value="complaint">Complaint</option>
                            <option value="suggestion">Suggestion</option>
                            <option value="event_question">Event Question</option>
                            <option value="other">Other</option>
                        </select>
                        <span class="field-error" id="err-category"></span>
                    </div>

                    <!-- Subject -->
                    <div class="form-group">
                        <label class="modal-label" for="m-subject">Subject <span class="required-star">*</span></label>
                        <input type="text" class="ann-search-input modal-input" id="m-subject" name="subject" placeholder="Enter a brief title for your thread" maxlength="120" required>
                        <span class="field-error" id="err-subject"></span>
                    </div>

                    <!-- Message -->
                    <div class="form-group">
                        <label class="modal-label" for="m-message">Message <span class="required-star">*</span></label>
                        <textarea class="concern-textarea" id="m-message" name="message" rows="5" placeholder="Describe your concern in detail…" required></textarea>
                        <span class="field-error" id="err-message"></span>
                    </div>

                    <!-- Image Attachments -->
                    <div class="form-group">
                        <label class="modal-label" for="m-images">
                            Images <span class="optional-tag">(optional · JPEG or PNG · max 5MB each)</span>
                        </label>
                        <div class="file-drop-zone" id="file-drop-zone">
                            <input type="file" id="m-images" name="images[]" multiple class="file-input-hidden" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                            <div class="file-drop-inner">
                                <span class="file-drop-icon">🖼️</span>
                                <span class="file-drop-text">
                                    Drag &amp; drop images here or
                                    <button type="button" class="file-browse-btn" id="file-browse-btn">browse</button>
                                </span>
                                <span class="file-drop-hint">JPEG &amp; PNG only — Max 5MB each</span>
                            </div>
                        </div>
                        <div class="image-preview-grid" id="image-preview-grid"></div>
                        <span class="field-error" id="err-images"></span>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn-secondary-portal" id="modal-cancel" type="button">Cancel</button>
                <button class="btn-primary-portal" id="modal-submit" type="button">
                    <span id="submit-label">Post Thread</span>
                </button>
            </div>

        </div>
    </div>

    <!-- TOAST -->
    <div id="feed-toast" class="feed-toast" aria-live="polite"></div>

    <script>
        const FEED_USER_ID = <?= (int)$user_id ?>;
    </script>
    <script src="../../scripts/portal/feed_page.js"></script>

</body>

</html>