<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireRole('moderator');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Community Feed — Moderator</title>
    <link rel="stylesheet" href="../../../styles/management/mod_mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/moderator/mod_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/moderator/mod_topbar.css">
    <link rel="stylesheet" href="../../../styles/management/moderator/mod_feed.css">
</head>
<body>

<div class="mod-layout">

    <?php include __DIR__ . '/../../../components/management/moderator/mod_sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="mod-content">

    <?php
    $pageTitle      = 'Community Feed';
    $pageBreadcrumb = [['Home', '#'], ['Moderation', null], ['Community Feed', null]];
    $modName        = $_SESSION['user_name'] ?? 'Moderator';
    $modRole        = 'Moderator';
    $notifCount     = 5;
    include __DIR__ . '/../../../components/management/moderator/mod_topbar.php';
    ?>

        <!-- CONTROLS -->
        <section class="mod-feed-controls">
            <div class="mod-feed-controls-left">
                <div class="mod-search-wrap">
                    <svg class="mod-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                    <input type="text" id="mod-feed-search" placeholder="Search threads…" class="mod-search-input">
                </div>
            </div>
            <div class="mod-feed-controls-right">
                <select id="mod-feed-category" class="mod-feed-select">
                    <option value="all">All Categories</option>
                    <option value="program">Program</option>
                    <option value="complaint">Complaint</option>
                    <option value="event">Event</option>
                    <option value="inquiry">Inquiry</option>
                    <option value="other">Other</option>
                </select>
                <select id="mod-feed-status" class="mod-feed-select">
                    <option value="all">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="responded">Responded</option>
                    <option value="resolved">Resolved</option>
                </select>
                <select id="mod-feed-priority" class="mod-feed-select">
                    <option value="all">All Priorities</option>
                    <option value="normal">Normal</option>
                    <option value="urgent">Urgent</option>
                    <option value="critical">Critical</option>
                </select>
                <select id="mod-feed-sort" class="mod-feed-select">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="comments">Most Comments</option>
                    <option value="reports">Most Reported</option>
                </select>
            </div>
        </section>

        <!-- FEED GRID -->
        <section class="mod-feed-section">
            <div class="panel-header">
                <h2 class="section-label">Community Threads</h2>
                <span class="mod-feed-count" id="mod-feed-count">Showing 9 threads</span>
            </div>

            <div class="mod-feed-grid" id="mod-feed-grid">

                <!-- THREAD 1 -->
                <article class="mod-feed-card" data-category="program" data-status="pending" data-priority="urgent">
                    <div class="mod-feed-card-body">
                        <div class="mod-feed-badges">
                            <span class="mod-cat-badge category-program">Program</span>
                            <span class="mod-pri-badge priority-urgent">Urgent</span>
                            <span class="mod-status-badge status-pending">Pending</span>
                        </div>
                        <h3 class="mod-feed-title">Scholarship Application Inquiry</h3>
                        <p class="mod-feed-excerpt">Can SK provide guidance on how to submit the scholarship application for 2026? Many youth residents are confused about the requirements.</p>
                        <div class="mod-feed-meta">
                            <span class="mod-feed-author">
                                <span class="mod-feed-avatar">MS</span>
                                Maria Santos
                            </span>
                            <time datetime="2026-02-10">Feb 10, 2026</time>
                            <span class="mod-feed-comments">💬 3</span>
                        </div>
                    </div>
                    <div class="mod-feed-card-footer">
                        <a href="mod_thread_view.php?id=1" class="btn-mod-sm">View Thread</a>
                        <div class="mod-thread-actions">
                            <button class="mod-action-btn mod-action-lock" title="Lock Thread" data-id="1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                Lock
                            </button>
                            <button class="mod-action-btn mod-action-flag" title="Flag for Review" data-id="1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></svg>
                                Flag
                            </button>
                            <button class="mod-action-btn mod-action-remove" title="Remove Thread" data-id="1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                Remove
                            </button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 2 -->
                <article class="mod-feed-card" data-category="complaint" data-status="responded" data-priority="normal">
                    <div class="mod-feed-card-body">
                        <div class="mod-feed-badges">
                            <span class="mod-cat-badge category-complaint">Complaint</span>
                            <span class="mod-pri-badge priority-normal">Normal</span>
                            <span class="mod-status-badge status-responded">Responded</span>
                        </div>
                        <h3 class="mod-feed-title">Street Lighting Issue</h3>
                        <p class="mod-feed-excerpt">The street lights near Barangay Hall are not working. Please fix them as soon as possible before an accident occurs.</p>
                        <div class="mod-feed-meta">
                            <span class="mod-feed-author">
                                <span class="mod-feed-avatar">JD</span>
                                Juan Dela Cruz
                            </span>
                            <time datetime="2026-02-08">Feb 8, 2026</time>
                            <span class="mod-feed-comments">💬 2</span>
                        </div>
                    </div>
                    <div class="mod-feed-card-footer">
                        <a href="mod_thread_view.php?id=2" class="btn-mod-sm">View Thread</a>
                        <div class="mod-thread-actions">
                            <button class="mod-action-btn mod-action-lock" title="Lock Thread" data-id="2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                Lock
                            </button>
                            <button class="mod-action-btn mod-action-flag" title="Flag for Review" data-id="2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></svg>
                                Flag
                            </button>
                            <button class="mod-action-btn mod-action-remove" title="Remove Thread" data-id="2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                Remove
                            </button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 3 -->
                <article class="mod-feed-card mod-feed-card--flagged" data-category="event" data-status="resolved" data-priority="critical">
                    <div class="mod-feed-card-body">
                        <div class="mod-feed-badges">
                            <span class="mod-cat-badge category-event">Event</span>
                            <span class="mod-pri-badge priority-critical">Critical</span>
                            <span class="mod-status-badge status-resolved">Resolved</span>
                            <span class="mod-flag-indicator">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></svg>
                                Flagged
                            </span>
                        </div>
                        <h3 class="mod-feed-title">Community Clean-Up Drive Schedule</h3>
                        <p class="mod-feed-excerpt">Requesting confirmation of the cleanup schedule for March. Many volunteers are waiting for the final schedule to be posted.</p>
                        <div class="mod-feed-meta">
                            <span class="mod-feed-author">
                                <span class="mod-feed-avatar">AR</span>
                                Ana Reyes
                            </span>
                            <time datetime="2026-02-12">Feb 12, 2026</time>
                            <span class="mod-feed-comments">💬 5</span>
                        </div>
                    </div>
                    <div class="mod-feed-card-footer">
                        <a href="mod_thread_view.php?id=3" class="btn-mod-sm">View Thread</a>
                        <div class="mod-thread-actions">
                            <button class="mod-action-btn mod-action-lock" title="Lock Thread" data-id="3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                Lock
                            </button>
                            <button class="mod-action-btn mod-action-flag mod-action-flag--active" title="Unflag Thread" data-id="3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M3 2.25a.75.75 0 0 1 .75.75v.54l1.838-.46a9.75 9.75 0 0 1 6.725.738l.108.054A8.25 8.25 0 0 0 18 4.524l3.11-.732a.75.75 0 0 1 .917.81 47.784 47.784 0 0 0 .005 10.337.75.75 0 0 1-.574.812l-3.114.733a9.75 9.75 0 0 1-6.594-.77l-.108-.054a8.25 8.25 0 0 0-5.69-.625l-2.202.55V21a.75.75 0 0 1-1.5 0V3A.75.75 0 0 1 3 2.25Z" clip-rule="evenodd"/></svg>
                                Unflag
                            </button>
                            <button class="mod-action-btn mod-action-remove" title="Remove Thread" data-id="3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                Remove
                            </button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 4 -->
                <article class="mod-feed-card" data-category="complaint" data-status="pending" data-priority="normal">
                    <div class="mod-feed-card-body">
                        <div class="mod-feed-badges">
                            <span class="mod-cat-badge category-complaint">Complaint</span>
                            <span class="mod-pri-badge priority-normal">Normal</span>
                            <span class="mod-status-badge status-pending">Pending</span>
                        </div>
                        <h3 class="mod-feed-title">Broken Street Light on Sauyo Road</h3>
                        <p class="mod-feed-excerpt">The street light near the barangay hall entrance has been out for two weeks. It's a safety hazard at night for residents walking home.</p>
                        <div class="mod-feed-meta">
                            <span class="mod-feed-author">
                                <span class="mod-feed-avatar">MS</span>
                                Marco Santos
                            </span>
                            <time datetime="2026-02-17">Feb 17, 2026</time>
                            <span class="mod-feed-comments">💬 4</span>
                        </div>
                    </div>
                    <div class="mod-feed-card-footer">
                        <a href="mod_thread_view.php?id=4" class="btn-mod-sm">View Thread</a>
                        <div class="mod-thread-actions">
                            <button class="mod-action-btn mod-action-lock" title="Lock Thread" data-id="4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                Lock
                            </button>
                            <button class="mod-action-btn mod-action-flag" title="Flag for Review" data-id="4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></svg>
                                Flag
                            </button>
                            <button class="mod-action-btn mod-action-remove" title="Remove Thread" data-id="4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                Remove
                            </button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 5 -->
                <article class="mod-feed-card mod-feed-card--locked" data-category="inquiry" data-status="responded" data-priority="normal">
                    <div class="mod-feed-card-body">
                        <div class="mod-feed-badges">
                            <span class="mod-cat-badge category-inquiry">Inquiry</span>
                            <span class="mod-pri-badge priority-normal">Normal</span>
                            <span class="mod-status-badge status-responded">Responded</span>
                            <span class="mod-lock-indicator">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                Locked
                            </span>
                        </div>
                        <h3 class="mod-feed-title">Barangay ID Renewal Schedule</h3>
                        <p class="mod-feed-excerpt">I would like to know when the barangay ID renewal schedule is. My ID expires next month and I need to update it for my senior citizen benefits.</p>
                        <div class="mod-feed-meta">
                            <span class="mod-feed-author">
                                <span class="mod-feed-avatar">LP</span>
                                Lita Punzalan
                            </span>
                            <time datetime="2026-02-20">Feb 20, 2026</time>
                            <span class="mod-feed-comments">💬 1</span>
                        </div>
                    </div>
                    <div class="mod-feed-card-footer">
                        <a href="mod_thread_view.php?id=5" class="btn-mod-sm">View Thread</a>
                        <div class="mod-thread-actions">
                            <button class="mod-action-btn mod-action-lock mod-action-lock--active" title="Unlock Thread" data-id="5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                Unlock
                            </button>
                            <button class="mod-action-btn mod-action-flag" title="Flag for Review" data-id="5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></svg>
                                Flag
                            </button>
                            <button class="mod-action-btn mod-action-remove" title="Remove Thread" data-id="5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                Remove
                            </button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 6 -->
                <article class="mod-feed-card" data-category="other" data-status="pending" data-priority="urgent">
                    <div class="mod-feed-card-body">
                        <div class="mod-feed-badges">
                            <span class="mod-cat-badge category-other">Other</span>
                            <span class="mod-pri-badge priority-urgent">Urgent</span>
                            <span class="mod-status-badge status-pending">Pending</span>
                        </div>
                        <h3 class="mod-feed-title">Flooding Near Purok 4 During Heavy Rain</h3>
                        <p class="mod-feed-excerpt">Every time it rains heavily, Purok 4 floods badly. Residents are asking for drainage improvements to prevent property damage and health risks.</p>
                        <div class="mod-feed-meta">
                            <span class="mod-feed-author">
                                <span class="mod-feed-avatar">RG</span>
                                Roberto Gomez
                            </span>
                            <time datetime="2026-02-22">Feb 22, 2026</time>
                            <span class="mod-feed-comments">💬 11</span>
                        </div>
                    </div>
                    <div class="mod-feed-card-footer">
                        <a href="mod_thread_view.php?id=6" class="btn-mod-sm">View Thread</a>
                        <div class="mod-thread-actions">
                            <button class="mod-action-btn mod-action-lock" title="Lock Thread" data-id="6">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                Lock
                            </button>
                            <button class="mod-action-btn mod-action-flag" title="Flag for Review" data-id="6">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></svg>
                                Flag
                            </button>
                            <button class="mod-action-btn mod-action-remove" title="Remove Thread" data-id="6">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                Remove
                            </button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 7 -->
                <article class="mod-feed-card" data-category="program" data-status="resolved" data-priority="normal">
                    <div class="mod-feed-card-body">
                        <div class="mod-feed-badges">
                            <span class="mod-cat-badge category-program">Program</span>
                            <span class="mod-pri-badge priority-normal">Normal</span>
                            <span class="mod-status-badge status-resolved">Resolved</span>
                        </div>
                        <h3 class="mod-feed-title">Livelihood Training Registration</h3>
                        <p class="mod-feed-excerpt">Is there still a slot available for the upcoming livelihood training? I missed the announcement and would like to know how to register for the next batch.</p>
                        <div class="mod-feed-meta">
                            <span class="mod-feed-author">
                                <span class="mod-feed-avatar">CM</span>
                                Carlo Mendoza
                            </span>
                            <time datetime="2026-02-24">Feb 24, 2026</time>
                            <span class="mod-feed-comments">💬 6</span>
                        </div>
                    </div>
                    <div class="mod-feed-card-footer">
                        <a href="mod_thread_view.php?id=7" class="btn-mod-sm">View Thread</a>
                        <div class="mod-thread-actions">
                            <button class="mod-action-btn mod-action-lock" title="Lock Thread" data-id="7">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                Lock
                            </button>
                            <button class="mod-action-btn mod-action-flag" title="Flag for Review" data-id="7">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></svg>
                                Flag
                            </button>
                            <button class="mod-action-btn mod-action-remove" title="Remove Thread" data-id="7">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                Remove
                            </button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 8 — reported -->
                <article class="mod-feed-card mod-feed-card--reported" data-category="complaint" data-status="pending" data-priority="critical">
                    <div class="mod-feed-card-body">
                        <div class="mod-feed-badges">
                            <span class="mod-cat-badge category-complaint">Complaint</span>
                            <span class="mod-pri-badge priority-critical">Critical</span>
                            <span class="mod-status-badge status-pending">Pending</span>
                            <span class="mod-report-indicator">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                                3 Reports
                            </span>
                        </div>
                        <h3 class="mod-feed-title">Noise Complaint Against Neighbor</h3>
                        <p class="mod-feed-excerpt">My neighbor has been playing loud music past midnight every weekend. I've tried talking to them but they refuse to stop. I need barangay assistance.</p>
                        <div class="mod-feed-meta">
                            <span class="mod-feed-author">
                                <span class="mod-feed-avatar">SV</span>
                                Sofia Villanueva
                            </span>
                            <time datetime="2026-02-26">Feb 26, 2026</time>
                            <span class="mod-feed-comments">💬 7</span>
                        </div>
                    </div>
                    <div class="mod-feed-card-footer">
                        <a href="mod_thread_view.php?id=8" class="btn-mod-sm">View Thread</a>
                        <div class="mod-thread-actions">
                            <button class="mod-action-btn mod-action-lock" title="Lock Thread" data-id="8">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                Lock
                            </button>
                            <button class="mod-action-btn mod-action-flag" title="Flag for Review" data-id="8">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></svg>
                                Flag
                            </button>
                            <button class="mod-action-btn mod-action-remove" title="Remove Thread" data-id="8">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                Remove
                            </button>
                        </div>
                    </div>
                </article>

                <!-- THREAD 9 -->
                <article class="mod-feed-card" data-category="other" data-status="responded" data-priority="critical">
                    <div class="mod-feed-card-body">
                        <div class="mod-feed-badges">
                            <span class="mod-cat-badge category-other">Other</span>
                            <span class="mod-pri-badge priority-critical">Critical</span>
                            <span class="mod-status-badge status-responded">Responded</span>
                        </div>
                        <h3 class="mod-feed-title">Stray Dogs Roaming Near Elementary School</h3>
                        <p class="mod-feed-excerpt">Several stray dogs have been seen roaming near the elementary school entrance during dismissal hours. Parents are concerned about student safety.</p>
                        <div class="mod-feed-meta">
                            <span class="mod-feed-author">
                                <span class="mod-feed-avatar">JG</span>
                                Josephine Garcia
                            </span>
                            <time datetime="2026-02-25">Feb 25, 2026</time>
                            <span class="mod-feed-comments">💬 8</span>
                        </div>
                    </div>
                    <div class="mod-feed-card-footer">
                        <a href="mod_thread_view.php?id=9" class="btn-mod-sm">View Thread</a>
                        <div class="mod-thread-actions">
                            <button class="mod-action-btn mod-action-lock" title="Lock Thread" data-id="9">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                Lock
                            </button>
                            <button class="mod-action-btn mod-action-flag" title="Flag for Review" data-id="9">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></svg>
                                Flag
                            </button>
                            <button class="mod-action-btn mod-action-remove" title="Remove Thread" data-id="9">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                Remove
                            </button>
                        </div>
                    </div>
                </article>

            </div>

            <!-- NO RESULTS -->
            <div class="mod-no-results" id="mod-no-results" style="display:none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                <p>No threads found matching your filters.</p>
            </div>
        </section>

        <!-- PAGINATION -->
        <section class="mod-pagination">
            <button class="mod-page-btn" id="mod-prev-btn" disabled>&#8249; Previous</button>
            <div class="mod-page-numbers" id="mod-page-numbers">
                <button class="mod-page-num active">1</button>
                <button class="mod-page-num">2</button>
                <button class="mod-page-num">3</button>
            </div>
            <button class="mod-page-btn" id="mod-next-btn">Next &#8250;</button>
        </section>

    </main>
</div>

<!-- CONFIRM ACTION MODAL -->
<div class="mod-confirm-overlay" id="mod-confirm-overlay" style="display:none;" aria-modal="true" role="dialog">
    <div class="mod-confirm-box">
        <div class="mod-confirm-icon" id="mod-confirm-icon">⚠️</div>
        <h3 class="mod-confirm-title" id="mod-confirm-title">Confirm Action</h3>
        <p class="mod-confirm-body" id="mod-confirm-body">Are you sure you want to perform this action?</p>
        <div class="mod-confirm-footer">
            <button class="btn-mod-sm" id="mod-confirm-cancel">Cancel</button>
            <button class="mod-confirm-ok" id="mod-confirm-ok">Confirm</button>
        </div>
    </div>
</div>

<!-- TOAST NOTIFICATION -->
<div class="mod-toast" id="mod-toast" aria-live="polite"></div>

<script src="../../../scripts/management/moderator/mod_feed.js"></script>

</body>
</html>