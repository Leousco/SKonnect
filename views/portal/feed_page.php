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
    <!-- <link rel="stylesheet" href="../../styles/portal/announcements_page.css"> -->
</head>
<body>

<div class="dashboard-layout">

    <?php include __DIR__ . '/../../components/portal/sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="dashboard-content">

    <?php
    $pageTitle      = 'Community Feed';
    $pageBreadcrumb = [['Home', '#'], ['Community Feed', null]];
    $userName       = 'Juan Dela Cruz';
    $userRole       = 'SK Member';
    $notifCount     = 3;
    include __DIR__ . '/../../components/portal/topbar.php';
    ?>

        <!-- CONTROLS -->
        <section class="announcements-controls">
            <div class="controls-left">
                <button class="btn-primary-portal" id="submit-concern-btn">Post a thread</button>
                <div class="search-wrap">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="feed-search" placeholder="Search threads..." class="ann-search-input">
                </div>
            </div>
            <div class="controls-right">
                <select id="feed-category" class="ann-select">
                    <option value="all">All Categories</option>
                    <option value="program">Program</option>
                    <option value="complaint">Complaint</option>
                    <option value="event">Event</option>
                    <option value="inquiry">Inquiry</option>
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
                </select>
            </div>
        </section>

        <!-- FEED GRID -->
        <section class="announcements-section">
            <h2 class="section-label">Community Threads</h2>

            <div class="announcements-grid" id="feed-grid">

                <!-- THREAD 1 -->
                <article class="ann-card feed-card" data-category="program" data-status="pending">
                    <div class="ann-card-body">
                        <div class="feed-card-badges">
                            <span class="ann-badge category-program">Program</span>
                            <span class="feed-badge priority-urgent">Urgent</span>
                            <span class="feed-badge status-pending">Pending</span>
                        </div>
                        <h3 class="ann-card-title">Scholarship Application Inquiry</h3>
                        <p class="ann-card-excerpt">Can SK provide guidance on how to submit the scholarship application for 2026? Many youth residents are confused about the requirements.</p>
                        <div class="ann-card-meta">
                            <span>By: Maria Santos</span>
                            <time datetime="2026-02-10">Feb 10, 2026</time>
                            <span>💬 3 comments</span>
                        </div>
                        <div class="ann-card-actions">
                            <a href="thread-view.php" class="btn-secondary-portal">View &amp; Comment</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 2 -->
                <article class="ann-card feed-card" data-category="complaint" data-status="responded">
                    <div class="ann-card-body">
                        <div class="feed-card-badges">
                            <span class="ann-badge category-complaint">Complaint</span>
                            <span class="feed-badge priority-normal">Normal</span>
                            <span class="feed-badge status-responded">Responded</span>
                        </div>
                        <h3 class="ann-card-title">Street Lighting Issue</h3>
                        <p class="ann-card-excerpt">The street lights near Barangay Hall are not working. Please fix them as soon as possible before an accident occurs.</p>
                        <div class="ann-card-meta">
                            <span>By: Juan Dela Cruz</span>
                            <time datetime="2026-02-08">Feb 8, 2026</time>
                            <span>💬 2 comments</span>
                        </div>
                        <div class="ann-card-actions">
                            <a href="thread-view.php" class="btn-secondary-portal">View &amp; Comment</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 3 -->
                <article class="ann-card feed-card" data-category="event" data-status="resolved">
                    <div class="ann-card-body">
                        <div class="feed-card-badges">
                            <span class="ann-badge category-event">Event</span>
                            <span class="feed-badge priority-critical">Critical</span>
                            <span class="feed-badge status-resolved">Resolved</span>
                        </div>
                        <h3 class="ann-card-title">Community Clean-Up Drive Schedule</h3>
                        <p class="ann-card-excerpt">Requesting confirmation of the cleanup schedule for March. Many volunteers are waiting for the final schedule to be posted.</p>
                        <div class="ann-card-meta">
                            <span>By: Ana Reyes</span>
                            <time datetime="2026-02-12">Feb 12, 2026</time>
                            <span>💬 5 comments</span>
                        </div>
                        <div class="ann-card-actions">
                            <a href="thread-view.php" class="btn-secondary-portal">View &amp; Comment</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 4 -->
                <article class="ann-card feed-card" data-category="complaint" data-status="pending">
                    <div class="ann-card-body">
                        <div class="feed-card-badges">
                            <span class="ann-badge category-complaint">Complaint</span>
                            <span class="feed-badge priority-normal">Normal</span>
                            <span class="feed-badge status-pending">Pending</span>
                        </div>
                        <h3 class="ann-card-title">Broken Street Light on Sauyo Road</h3>
                        <p class="ann-card-excerpt">The street light near the barangay hall entrance has been out for two weeks. It's a safety hazard at night for residents walking home.</p>
                        <div class="ann-card-meta">
                            <span>By: Marco Santos</span>
                            <time datetime="2026-02-17">Feb 17, 2026</time>
                            <span>💬 12 comments</span>
                        </div>
                        <div class="ann-card-actions">
                            <a href="thread-view.php" class="btn-secondary-portal">View &amp; Comment</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 5 -->
                <article class="ann-card feed-card" data-category="other" data-status="pending">
                    <div class="ann-card-body">
                        <div class="feed-card-badges">
                            <span class="ann-badge category-other">Other</span>
                            <span class="feed-badge priority-normal">Normal</span>
                            <span class="feed-badge status-pending">Pending</span>
                        </div>
                        <h3 class="ann-card-title">Request for Basketball Court Repairs</h3>
                        <p class="ann-card-excerpt">The flooring on the covered court has cracks causing injuries during games. Requesting the SK to prioritize repairs before the sports league starts.</p>
                        <div class="ann-card-meta">
                            <span>By: Carlo Mendoza</span>
                            <time datetime="2026-02-19">Feb 19, 2026</time>
                            <span>💬 8 comments</span>
                        </div>
                        <div class="ann-card-actions">
                            <a href="thread-view.php" class="btn-secondary-portal">View &amp; Comment</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 6 -->
                <article class="ann-card feed-card" data-category="complaint" data-status="responded">
                    <div class="ann-card-body">
                        <div class="feed-card-badges">
                            <span class="ann-badge category-complaint">Complaint</span>
                            <span class="feed-badge priority-critical">Critical</span>
                            <span class="feed-badge status-responded">Responded</span>
                        </div>
                        <h3 class="ann-card-title">Flooding Near Purok 4 During Heavy Rain</h3>
                        <p class="ann-card-excerpt">Every time it rains heavily, the drainage near Purok 4 overflows and floods the pathway. Residents are asking if this can be raised to the barangay.</p>
                        <div class="ann-card-meta">
                            <span>By: Liza Bautista</span>
                            <time datetime="2026-02-20">Feb 20, 2026</time>
                            <span>💬 3 comments</span>
                        </div>
                        <div class="ann-card-actions">
                            <a href="thread-view.php" class="btn-secondary-portal">View &amp; Comment</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 7 -->
                <article class="ann-card feed-card" data-category="inquiry" data-status="pending">
                    <div class="ann-card-body">
                        <div class="feed-card-badges">
                            <span class="ann-badge category-inquiry">Inquiry</span>
                            <span class="feed-badge priority-normal">Normal</span>
                            <span class="feed-badge status-pending">Pending</span>
                        </div>
                        <h3 class="ann-card-title">Schedule for Upcoming Barangay Clearance Processing</h3>
                        <p class="ann-card-excerpt">
                            May we know the updated schedule for barangay clearance processing this March? 
                            Some residents are unsure if walk-ins are still allowed.
                        </p>
                        <div class="ann-card-meta">
                            <span>By: Marco Dela Cruz</span>
                            <time datetime="2026-02-22">Feb 22, 2026</time>
                            <span>💬 1 comment</span>
                        </div>
                        <div class="ann-card-actions">
                            <a href="thread-view.php" class="btn-secondary-portal">View &amp; Comment</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 8 -->
                <article class="ann-card feed-card" data-category="complaint" data-status="resolved">
                    <div class="ann-card-body">
                        <div class="feed-card-badges">
                            <span class="ann-badge category-complaint">Complaint</span>
                            <span class="feed-badge priority-urgent">Urgent</span>
                            <span class="feed-badge status-resolved">Resolved</span>
                        </div>
                        <h3 class="ann-card-title">Streetlight Not Working Along Mabini Street</h3>
                        <p class="ann-card-excerpt">
                            The streetlight near the corner of Mabini Street was not functioning for several nights, 
                            causing visibility issues. It appears to have been fixed yesterday.
                        </p>
                        <div class="ann-card-meta">
                            <span>By: Ana Reyes</span>
                            <time datetime="2026-02-18">Feb 18, 2026</time>
                            <span>💬 5 comments</span>
                        </div>
                        <div class="ann-card-actions">
                            <a href="thread-view.php" class="btn-secondary-portal">View &amp; Comment</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 9 -->
                <article class="ann-card feed-card" data-category="other" data-status="responded">
                    <div class="ann-card-body">
                        <div class="feed-card-badges">
                            <span class="ann-badge category-other">Other</span>
                            <span class="feed-badge priority-critical">Critical</span>
                            <span class="feed-badge status-responded">Responded</span>
                        </div>
                        <h3 class="ann-card-title">Stray Dogs Roaming Near Elementary School</h3>
                        <p class="ann-card-excerpt">
                            Several stray dogs have been seen roaming near the elementary school entrance during 
                            dismissal hours. Parents are concerned about student safety.
                        </p>
                        <div class="ann-card-meta">
                            <span>By: Josephine Garcia</span>
                            <time datetime="2026-02-25">Feb 25, 2026</time>
                            <span>💬 8 comments</span>
                        </div>
                        <div class="ann-card-actions">
                            <a href="thread-view.php" class="btn-secondary-portal">View &amp; Comment</a>
                            <button class="bookmark-btn" title="Bookmark">🔖</button>
                        </div>
                    </div>
                </article>

            </div>

            <!-- NO RESULTS -->
            <div class="no-results" id="no-results" style="display:none;">
                <p>No threads found matching your search.</p>
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

<!-- SUBMIT CONCERN MODAL -->
<div class="modal-overlay" id="modal-overlay" style="display:none;" aria-modal="true" role="dialog" aria-labelledby="modal-title">
    <div class="modal-box">

        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon">✉</div>
                <div>
                    <h3 id="modal-title">Submit a Concern</h3>
                    <p class="modal-subtitle">All fields marked <span class="required-star">*</span> are required.</p>
                </div>
            </div>
            <button class="modal-close" id="modal-close" aria-label="Close">&times;</button>
        </div>

        <div class="modal-body">
            <form class="concern-form" id="concern-form" enctype="multipart/form-data" novalidate>

                <!-- ROW: Category + Priority -->
                <div class="modal-row">
                    <div class="form-group">
                        <label class="modal-label" for="m-category">Category <span class="required-star">*</span></label>
                        <select class="ann-select modal-select" id="m-category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="program">Program</option>
                            <option value="event">Event</option>
                            <option value="complaint">Complaint</option>
                            <option value="inquiry">Inquiry</option>
                            <option value="other">Other</option>
                        </select>
                        <span class="field-error" id="err-category"></span>
                    </div>
                    <div class="form-group">
                        <label class="modal-label" for="m-priority">Priority <span class="required-star">*</span></label>
                        <select class="ann-select modal-select" id="m-priority" name="priority" required>
                            <option value="">Select Priority</option>
                            <option value="normal">Normal</option>
                            <option value="urgent">Urgent</option>
                            <option value="critical">Critical</option>
                        </select>
                        <span class="field-error" id="err-priority"></span>
                    </div>
                </div>

                <!-- Subject -->
                <div class="form-group">
                    <label class="modal-label" for="m-subject">Subject <span class="required-star">*</span></label>
                    <input
                        type="text"
                        class="ann-search-input modal-input"
                        id="m-subject"
                        name="subject"
                        placeholder="Enter a brief title for your concern"
                        maxlength="120"
                        required
                    >
                    <span class="field-error" id="err-subject"></span>
                </div>

                <!-- Message -->
                <div class="form-group">
                    <label class="modal-label" for="m-message">Message <span class="required-star">*</span></label>
                    <textarea
                        class="concern-textarea"
                        id="m-message"
                        name="message"
                        rows="5"
                        placeholder="Describe your concern in detail…"
                        required
                    ></textarea>
                    <span class="field-error" id="err-message"></span>
                </div>

                <!-- Attachments -->
                <div class="form-group">
                    <label class="modal-label" for="m-attachments">Attachments <span class="optional-tag">(optional)</span></label>
                    <div class="file-drop-zone" id="file-drop-zone">
                        <input type="file" id="m-attachments" name="attachments[]" multiple class="file-input-hidden" accept="image/*,.pdf,.doc,.docx">
                        <div class="file-drop-inner">
                            <span class="file-drop-icon">📎</span>
                            <span class="file-drop-text">Drag & drop files here or <button type="button" class="file-browse-btn" id="file-browse-btn">browse</button></span>
                            <span class="file-drop-hint">Accepted: Images, PDF, DOC — Max 5MB each</span>
                        </div>
                        <ul class="file-list" id="file-list"></ul>
                    </div>
                </div>

            </form>
        </div>

        <div class="modal-footer">
            <button class="btn-secondary-portal" id="modal-cancel" type="button">Cancel</button>
            <button class="btn-primary-portal" id="modal-submit" type="button">✉ Post Concern</button>
        </div>

    </div>
</div>

<script src="../../scripts/portal/feed_page.js"></script>

</body>
</html>