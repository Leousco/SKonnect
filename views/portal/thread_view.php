<?php
require_once __DIR__ . '/../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireAuth();

require_once __DIR__ . '/../../backend/config/database.php';
require_once __DIR__ . '/../../backend/models/ThreadModel.php';
require_once __DIR__ . '/../../backend/models/CommentModel.php';

$db      = new Database();
$conn    = $db->getConnection();
$user_id = $_SESSION['user_id'] ?? null;

$threadModel  = new ThreadModel($conn);
$commentModel = new CommentModel($conn);

$thread_id = (int)($_GET['id'] ?? 0);
if (!$thread_id) {
    header('Location: feed_page.php');
    exit;
}

$thread = $threadModel->getThreadById($thread_id, (int)$user_id);
if (!$thread) {
    header('Location: feed_page.php');
    exit;
}

$images   = $threadModel->getThreadImages($thread_id);
$comments = $commentModel->getCommentsByThread($thread_id, (int)$user_id);

// Mod / SK Official comments always appear first; preserve original order within each group
usort($comments, fn ($a, $b) => (int)!empty($b['is_mod_comment']) - (int)!empty($a['is_mod_comment']));

// --- Helpers ---
$cat_labels = [
    'inquiry'        => 'Inquiry',
    'complaint'      => 'Complaint',
    'suggestion'     => 'Suggestion',
    'event_question' => 'Event',
    'other'          => 'Other',
];
$cat_key   = $thread['category'];
$cat_label = $cat_labels[$cat_key] ?? 'Other';
$date_fmt  = date('F j, Y · g:i A', strtotime($thread['created_at']));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | <?= htmlspecialchars($thread['subject']) ?></title>

    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/portal/sidebar.css">
    <link rel="stylesheet" href="../../styles/portal/topbar.css">
    <link rel="stylesheet" href="../../styles/portal/feed_page.css">
    <link rel="stylesheet" href="../../styles/portal/thread_view.css">
</head>

<body>

    <div class="dashboard-layout">

        <?php include __DIR__ . '/../../components/portal/sidebar.php'; ?>

        <main class="dashboard-content">

            <?php
            $pageTitle      = 'Thread';
            $pageBreadcrumb = [['Home', '#'], ['Community Feed', 'feed_page.php'], [$thread['subject'], null]];
            $userName       = $_SESSION['user_name'] ?? 'Guest';
            $userRole       = 'Resident';
            $notifCount     = 3;
            include __DIR__ . '/../../components/portal/topbar.php';
            ?>

            <!-- THREAD CONTAINER -->
            <div class="thread-container">

                <!-- BACK LINK -->
                <a href="feed_page.php" class="thread-back-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Back to Community Feed
                </a>

                <!-- THREAD CARD -->
                <article class="thread-main-card">

                    <!-- BADGES: category + status only (priority removed) -->
                    <div class="feed-card-badges">
                        <span class="ann-badge category-<?= $cat_key ?>"><?= $cat_label ?></span>
                        <span class="feed-badge status-<?= $thread['status'] ?>"><?= ucfirst($thread['status']) ?></span>
                    </div>

                    <!-- TITLE -->
                    <h1 class="thread-title"><?= htmlspecialchars($thread['subject']) ?></h1>

                    <!-- META -->
                    <div class="thread-meta">
                        <div class="thread-author-avatar">
                            <?= strtoupper(substr($thread['author_name'], 0, 1)) ?>
                        </div>
                        <div>
                            <span class="thread-author-name"><?= htmlspecialchars($thread['author_name']) ?></span>
                            <time class="thread-date" datetime="<?= $thread['created_at'] ?>"><?= $date_fmt ?></time>
                        </div>
                        <div class="thread-meta-counts">
                            <span>💬 <?= (int)$thread['comment_count'] ?> <?= $thread['comment_count'] == 1 ? 'comment' : 'comments' ?></span>
                        </div>
                    </div>

                    <!-- BODY -->
                    <div class="thread-body">
                        <?= nl2br(htmlspecialchars($thread['message'])) ?>
                    </div>

                    <!-- IMAGES (only shown on thread view, not on cards) -->
                    <?php if (!empty($images)) : ?>
                        <div class="thread-images-grid">
                            <?php foreach ($images as $img) : ?>
                                <div class="thread-image-item" data-src="../../<?= htmlspecialchars($img['file_path']) ?>">
                                    <img src="../../<?= htmlspecialchars($img['file_path']) ?>" alt="<?= htmlspecialchars($img['file_name']) ?>" loading="lazy">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- ACTIONS -->
                    <div class="thread-actions">
                        <button class="support-btn <?= $thread['user_supported'] ? 'active' : '' ?>" id="thread-support-btn" data-thread-id="<?= $thread_id ?>" title="<?= $thread['user_supported'] ? 'Remove support' : 'I support this' ?>">
                            <img src="../../assets/img/handshake-icon.png" alt="Support" class="support-icon">
                            <span id="thread-support-count"><?= (int)$thread['support_count'] ?></span>
                            <span><?= $thread['user_supported'] ? 'Supported' : 'Support' ?></span>
                        </button>

                        <button class="thread-bookmark-btn <?= $thread['is_bookmarked'] ? 'active' : '' ?>" id="thread-bookmark-btn" data-thread-id="<?= $thread_id ?>" title="<?= $thread['is_bookmarked'] ? 'Remove bookmark' : 'Bookmark this thread' ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="bm-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                            </svg>
                            <span class="bm-label"><?= $thread['is_bookmarked'] ? 'Bookmarked' : 'Bookmark' ?></span>
                        </button>
                    </div>

                </article>

                <!-- COMMENTS SECTION -->
                <section class="comments-section">
                    <h2 class="comments-heading">
                        Comments
                        <span class="comments-count" id="comments-count"><?= count($comments) ?></span>
                    </h2>

                    <!-- MAIN REPLY BOX -->
                    <div class="reply-box">
                        <div class="reply-avatar">
                            <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                        </div>
                        <div class="reply-input-wrap">
                            <textarea id="reply-textarea" class="concern-textarea reply-textarea" rows="3" placeholder="Write a comment…"></textarea>
                            <div class="reply-footer">
                                <span class="reply-hint">Contribute to a helpful and inclusive conversation.</span>
                                <button class="btn-primary-portal reply-submit-btn" id="reply-submit-btn" type="button">
                                    <span id="reply-label">Post Comment</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- COMMENT LIST -->
                    <div class="comment-list" id="comment-list">

                        <?php if (empty($comments)) : ?>
                            <div class="no-comments" id="no-comments">
                                No comments yet. Be the first to reply!
                            </div>
                        <?php else : ?>

                            <?php foreach ($comments as $c) :
                                $c_date   = date('M j, Y · g:i A', strtotime($c['created_at']));
                                $initials = strtoupper(substr($c['author_name'], 0, 1));
                            ?>
                                <div class="comment-item <?= !empty($c['is_mod_comment']) ? 'comment-item--mod' : '' ?>" id="comment-<?= (int)$c['id'] ?>">
                                    <div class="comment-avatar"><?= $initials ?></div>
                                    <div class="comment-body">
                                        <div class="comment-header">
                                            <span class="comment-author"><?= htmlspecialchars($c['author_name']) ?></span>
                                            <?php if (!empty($c['is_mod_comment'])) : ?>
                                                <span class="mod-reply-badge">SK Official</span>
                                            <?php endif; ?>
                                            <time class="comment-date" datetime="<?= $c['created_at'] ?>"><?= $c_date ?></time>
                                        </div>
                                        <div class="comment-text"><?= nl2br(htmlspecialchars($c['message'])) ?></div>
                                        <div class="comment-actions">
                                            <button class="comment-support-btn <?= $c['user_supported'] ? 'active' : '' ?>" data-comment-id="<?= (int)$c['id'] ?>" title="Support this comment">
                                                <img src="../../assets/img/handshake-icon.png" alt="Support" class="comment-support-icon"> <span class="comment-support-count"><?= (int)$c['support_count'] ?></span>
                                            </button>
                                            <button class="reply-toggle-btn" data-comment-id="<?= (int)$c['id'] ?>" title="Reply to this comment">
                                                💬 Reply
                                            </button>
                                        </div>

                                        <!-- REPLIES -->
                                        <?php if (!empty($c['replies'])) : ?>
                                            <div class="reply-list" id="reply-list-<?= (int)$c['id'] ?>">
                                                <?php foreach ($c['replies'] as $r) :
                                                    $r_date     = date('M j, Y · g:i A', strtotime($r['created_at']));
                                                    $r_initials = strtoupper(substr($r['author_name'], 0, 1));
                                                ?>
                                                    <div class="reply-item <?= !empty($r['is_mod_comment']) ? 'reply-item--mod' : '' ?>" id="reply-<?= (int)$r['id'] ?>">
                                                        <div class="reply-avatar"><?= $r_initials ?></div>
                                                        <div class="reply-body">
                                                            <div class="comment-header">
                                                                <span class="comment-author"><?= htmlspecialchars($r['author_name']) ?></span>
                                                                <?php if (!empty($r['is_mod_comment'])) : ?>
                                                                    <span class="mod-reply-badge">SK Official</span>
                                                                <?php endif; ?>
                                                                <time class="comment-date" datetime="<?= $r['created_at'] ?>"><?= $r_date ?></time>
                                                            </div>
                                                            <div class="comment-text"><?= nl2br(htmlspecialchars($r['message'])) ?></div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="reply-list" id="reply-list-<?= (int)$c['id'] ?>"></div>
                                        <?php endif; ?>

                                        <!-- INLINE REPLY BOX (hidden by default) -->
                                        <div class="inline-reply-box" id="reply-box-<?= (int)$c['id'] ?>" style="display:none;">
                                            <textarea class="concern-textarea reply-textarea inline-reply-textarea" rows="2" placeholder="Write a reply…" data-comment-id="<?= (int)$c['id'] ?>"></textarea>
                                            <div class="inline-reply-footer">
                                                <button class="btn-cancel-reply" data-comment-id="<?= (int)$c['id'] ?>">Cancel</button>
                                                <button class="btn-submit-reply btn-primary-portal" data-comment-id="<?= (int)$c['id'] ?>">
                                                    <span class="reply-submit-label">Post Reply</span>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php endforeach; ?>

                        <?php endif; ?>
                    </div>

                </section>

            </div><!-- /.thread-container -->

        </main>
    </div>

    <!-- LIGHTBOX -->
    <div class="lightbox-overlay" id="lightbox-overlay" style="display:none;">
        <button class="lightbox-close" id="lightbox-close">&times;</button>
        <img class="lightbox-img" id="lightbox-img" src="" alt="Image preview">
    </div>

    <!-- TOAST -->
    <div id="feed-toast" class="feed-toast" aria-live="polite"></div>

    <script>
        const THREAD_ID = <?= (int)$thread_id ?>;
        const FEED_USER_ID = <?= (int)$user_id ?>;
    </script>
    <script src="../../scripts/portal/thread_view.js"></script>

</body>

</html>