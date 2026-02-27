<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Notifications</title>

    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/portal/sidebar.css">
    <link rel="stylesheet" href="../../styles/portal/topbar.css">

    <link rel="stylesheet" href="../../styles/portal/notifications_page.css">
</head>
<body>

<div class="dashboard-layout">

    <?php include __DIR__ . '/../../components/portal/sidebar.php'; ?>

    <main class="dashboard-content">

    <?php
    $pageTitle      = 'Notifications';
    $pageBreadcrumb = [['Home', '#'], ['Notifications', null]];
    $userName       = 'Juan Dela Cruz';
    $userRole       = 'SK Member';
    $notifCount     = 3;
    include __DIR__ . '/../../components/portal/topbar.php';
    ?>

        <!-- STAT WIDGETS -->
        <section class="dashboard-widgets">
            <div class="widget-card">
                <h3>Total</h3>
                <p class="widget-number">14</p>
                <span class="widget-sub">All notifications</span>
            </div>
            <div class="widget-card">
                <h3>Unread</h3>
                <p class="widget-number">3</p>
                <span class="widget-sub">Needs your attention</span>
            </div>
            <div class="widget-card">
                <h3>This Week</h3>
                <p class="widget-number">6</p>
                <span class="widget-sub">Since Feb 20, 2026</span>
            </div>
            <div class="widget-card">
                <h3>Archived</h3>
                <p class="widget-number">5</p>
                <span class="widget-sub">Dismissed notifications</span>
            </div>
        </section>

        <!-- CONTROLS -->
        <section class="announcements-controls">
            <div class="controls-left">
                <div class="search-wrap">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="notif-search" placeholder="Search notifications..." class="ann-search-input">
                </div>
            </div>
            <div class="controls-right">
                <select id="notif-type" class="ann-select">
                    <option value="all">All Types</option>
                    <option value="service">Service Updates</option>
                    <option value="announcement">Announcements</option>
                    <option value="thread">Community Threads</option>
                    <option value="system">System</option>
                </select>
                <select id="notif-read" class="ann-select">
                    <option value="all">All</option>
                    <option value="unread">Unread Only</option>
                    <option value="read">Read Only</option>
                </select>
                <button class="btn-secondary-portal" id="mark-all-btn" title="Mark all as read">✓ Mark All Read</button>
            </div>
        </section>

        <!-- NOTIFICATIONS LIST -->
        <section class="announcements-section">
            <div class="notif-list-header">
                <h2 class="section-label">All Notifications</h2>
                <span class="notif-unread-count" id="unread-count-label">3 unread</span>
            </div>

            <div class="notif-list-wrap" id="notif-list">

                <!-- ── UNREAD ── -->

                <!-- NOTIF 1: Service Approved -->
                <div class="notif-item-row notif-unread" data-type="service" data-read="false" data-id="1"
                     data-title="Medical Assistance Request Approved"
                     data-body="Your Medical Assistance request (REF: REQ-2026-0012) has been approved by SK Chairperson Maria Reyes. Please visit the SK office on Feb 18–20, 2026 between 8AM–12PM to claim your assistance. Bring a valid ID and your reference number."
                     data-time="2026-02-15T10:30:00"
                     data-link="my_requests_page.php">
                    <div class="notif-type-indicator type-service"></div>
                    <div class="notif-icon-wrap icon-service">✅</div>
                    <div class="notif-content-wrap">
                        <div class="notif-row-top">
                            <span class="notif-type-tag tag-service">Service Update</span>
                            <span class="notif-unread-dot" aria-label="Unread"></span>
                        </div>
                        <p class="notif-title">Medical Assistance Request Approved</p>
                        <p class="notif-preview">Your Medical Assistance request (REF: REQ-2026-0012) has been approved by SK Chairperson Maria Reyes...</p>
                        <div class="notif-meta">
                            <time class="notif-time" datetime="2026-02-15T10:30:00">Feb 15, 2026 · 10:30 AM</time>
                            <a href="my_requests_page.php" class="notif-link">View Request →</a>
                        </div>
                    </div>
                    <div class="notif-actions">
                        <button class="notif-action-btn mark-read-btn" title="Mark as read" data-id="1">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </button>
                        <button class="notif-action-btn dismiss-btn" title="Dismiss" data-id="1">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </div>

                <!-- NOTIF 2: Announcement -->
                <div class="notif-item-row notif-unread" data-type="announcement" data-read="false" data-id="2"
                     data-title="Emergency Youth Assembly — Feb 22, 2026"
                     data-body="A mandatory Emergency Youth Assembly has been scheduled for February 22, 2026 at 2:00 PM at the Barangay Hall. All SK members are required to attend. Absence without valid reason will be noted in the attendance record."
                     data-time="2026-02-14T08:00:00"
                     data-link="announcements_page.php">
                    <div class="notif-type-indicator type-announcement"></div>
                    <div class="notif-icon-wrap icon-announcement">📣</div>
                    <div class="notif-content-wrap">
                        <div class="notif-row-top">
                            <span class="notif-type-tag tag-announcement">Announcement</span>
                            <span class="notif-unread-dot" aria-label="Unread"></span>
                        </div>
                        <p class="notif-title">Emergency Youth Assembly — Feb 22, 2026</p>
                        <p class="notif-preview">A mandatory Emergency Youth Assembly has been scheduled for February 22, 2026 at 2:00 PM at the Barangay Hall...</p>
                        <div class="notif-meta">
                            <time class="notif-time" datetime="2026-02-14T08:00:00">Feb 14, 2026 · 8:00 AM</time>
                            <a href="announcements_page.php" class="notif-link">View Announcement →</a>
                        </div>
                    </div>
                    <div class="notif-actions">
                        <button class="notif-action-btn mark-read-btn" title="Mark as read" data-id="2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </button>
                        <button class="notif-action-btn dismiss-btn" title="Dismiss" data-id="2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </div>

                <!-- NOTIF 3: Thread Reply (Unread) -->
                <div class="notif-item-row notif-unread" data-type="thread" data-read="false" data-id="3"
                     data-title="SK Officer Replied to Your Thread"
                     data-body="SK Secretary Carlo Tan replied to your community thread 'Scholarship Application Inquiry': 'Thank you for raising this. The scholarship application guide has been posted on the portal. You may also visit the SK office for assistance during office hours.'"
                     data-time="2026-02-13T14:15:00"
                     data-link="feed_page.php">
                    <div class="notif-type-indicator type-thread"></div>
                    <div class="notif-icon-wrap icon-thread">💬</div>
                    <div class="notif-content-wrap">
                        <div class="notif-row-top">
                            <span class="notif-type-tag tag-thread">Community Thread</span>
                            <span class="notif-unread-dot" aria-label="Unread"></span>
                        </div>
                        <p class="notif-title">SK Officer Replied to Your Thread</p>
                        <p class="notif-preview">SK Secretary Carlo Tan replied to "Scholarship Application Inquiry": Thank you for raising this...</p>
                        <div class="notif-meta">
                            <time class="notif-time" datetime="2026-02-13T14:15:00">Feb 13, 2026 · 2:15 PM</time>
                            <a href="feed_page.php" class="notif-link">View Thread →</a>
                        </div>
                    </div>
                    <div class="notif-actions">
                        <button class="notif-action-btn mark-read-btn" title="Mark as read" data-id="3">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </button>
                        <button class="notif-action-btn dismiss-btn" title="Dismiss" data-id="3">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </div>

                <!-- ── READ ── -->

                <!-- NOTIF 4: Service Under Review -->
                <div class="notif-item-row" data-type="service" data-read="true" data-id="4"
                     data-title="Scholarship Request Now Under Review"
                     data-body="Your Scholarship Program application (REF: REQ-2026-0018) is now under review by an SK officer. You will be notified once a final decision has been made. Please ensure your Transcript of Records is a certified true copy."
                     data-time="2026-02-17T09:00:00"
                     data-link="my_requests_page.php">
                    <div class="notif-type-indicator type-service"></div>
                    <div class="notif-icon-wrap icon-service">🔍</div>
                    <div class="notif-content-wrap">
                        <div class="notif-row-top">
                            <span class="notif-type-tag tag-service">Service Update</span>
                        </div>
                        <p class="notif-title">Scholarship Request Now Under Review</p>
                        <p class="notif-preview">Your Scholarship Program application (REF: REQ-2026-0018) is now under review by an SK officer...</p>
                        <div class="notif-meta">
                            <time class="notif-time" datetime="2026-02-17T09:00:00">Feb 17, 2026 · 9:00 AM</time>
                            <a href="my_requests_page.php" class="notif-link">View Request →</a>
                        </div>
                    </div>
                    <div class="notif-actions">
                        <button class="notif-action-btn dismiss-btn" title="Dismiss" data-id="4">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </div>

                <!-- NOTIF 5: Service Rejected -->
                <div class="notif-item-row" data-type="service" data-read="true" data-id="5"
                     data-title="Livelihood Support Request Rejected"
                     data-body="We regret to inform you that your Livelihood Support request (REF: REQ-2026-0009) has been rejected at this time. The current livelihood fund has been fully allocated. You may reapply once the next funding cycle opens in April 2026."
                     data-time="2026-02-12T11:45:00"
                     data-link="my_requests_page.php">
                    <div class="notif-type-indicator type-service type-rejected"></div>
                    <div class="notif-icon-wrap icon-rejected">❌</div>
                    <div class="notif-content-wrap">
                        <div class="notif-row-top">
                            <span class="notif-type-tag tag-service">Service Update</span>
                        </div>
                        <p class="notif-title">Livelihood Support Request Rejected</p>
                        <p class="notif-preview">Your Livelihood Support request (REF: REQ-2026-0009) has been rejected. The current fund has been fully allocated...</p>
                        <div class="notif-meta">
                            <time class="notif-time" datetime="2026-02-12T11:45:00">Feb 12, 2026 · 11:45 AM</time>
                            <a href="my_requests_page.php" class="notif-link">View Request →</a>
                        </div>
                    </div>
                    <div class="notif-actions">
                        <button class="notif-action-btn dismiss-btn" title="Dismiss" data-id="5">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </div>

                <!-- NOTIF 6: New Announcement -->
                <div class="notif-item-row" data-type="announcement" data-read="true" data-id="6"
                     data-title="Scholarship Program 2026 Now Open"
                     data-body="The SK Scholarship Program for 2026 is now open for applications. Eligible youth residents may submit their applications at the SK office or online through the portal. Deadline for submission is March 10, 2026."
                     data-time="2026-02-10T07:30:00"
                     data-link="announcements_page.php">
                    <div class="notif-type-indicator type-announcement"></div>
                    <div class="notif-icon-wrap icon-announcement">📣</div>
                    <div class="notif-content-wrap">
                        <div class="notif-row-top">
                            <span class="notif-type-tag tag-announcement">Announcement</span>
                        </div>
                        <p class="notif-title">Scholarship Program 2026 Now Open</p>
                        <p class="notif-preview">The SK Scholarship Program for 2026 is now open for applications. Deadline is March 10, 2026...</p>
                        <div class="notif-meta">
                            <time class="notif-time" datetime="2026-02-10T07:30:00">Feb 10, 2026 · 7:30 AM</time>
                            <a href="announcements_page.php" class="notif-link">View Announcement →</a>
                        </div>
                    </div>
                    <div class="notif-actions">
                        <button class="notif-action-btn dismiss-btn" title="Dismiss" data-id="6">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </div>

                <!-- NOTIF 7: Thread comment -->
                <div class="notif-item-row" data-type="thread" data-read="true" data-id="7"
                     data-title="New Comment on Your Thread"
                     data-body="Carlo Mendoza commented on your community thread 'Scholarship Application Inquiry': 'I have the same question! Would be great if the SK could post the full requirements list on the portal.'"
                     data-time="2026-02-11T16:00:00"
                     data-link="feed_page.php">
                    <div class="notif-type-indicator type-thread"></div>
                    <div class="notif-icon-wrap icon-thread">💬</div>
                    <div class="notif-content-wrap">
                        <div class="notif-row-top">
                            <span class="notif-type-tag tag-thread">Community Thread</span>
                        </div>
                        <p class="notif-title">New Comment on Your Thread</p>
                        <p class="notif-preview">Carlo Mendoza commented on "Scholarship Application Inquiry": I have the same question! Would be great if SK could post...</p>
                        <div class="notif-meta">
                            <time class="notif-time" datetime="2026-02-11T16:00:00">Feb 11, 2026 · 4:00 PM</time>
                            <a href="feed_page.php" class="notif-link">View Thread →</a>
                        </div>
                    </div>
                    <div class="notif-actions">
                        <button class="notif-action-btn dismiss-btn" title="Dismiss" data-id="7">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </div>

                <!-- NOTIF 8: System -->
                <div class="notif-item-row" data-type="system" data-read="true" data-id="8"
                     data-title="Welcome to SKonnect Portal"
                     data-body="Your account has been successfully verified and activated. You can now access all portal features including service requests, community threads, and announcements. If you have any concerns, please contact the SK office."
                     data-time="2026-01-28T09:00:00"
                     data-link="#">
                    <div class="notif-type-indicator type-system"></div>
                    <div class="notif-icon-wrap icon-system">🔔</div>
                    <div class="notif-content-wrap">
                        <div class="notif-row-top">
                            <span class="notif-type-tag tag-system">System</span>
                        </div>
                        <p class="notif-title">Welcome to SKonnect Portal</p>
                        <p class="notif-preview">Your account has been successfully verified and activated. You can now access all portal features...</p>
                        <div class="notif-meta">
                            <time class="notif-time" datetime="2026-01-28T09:00:00">Jan 28, 2026 · 9:00 AM</time>
                        </div>
                    </div>
                    <div class="notif-actions">
                        <button class="notif-action-btn dismiss-btn" title="Dismiss" data-id="8">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </div>

                <!-- NOTIF 9: Dental Approved -->
                <div class="notif-item-row" data-type="service" data-read="true" data-id="9"
                     data-title="Dental Assistance Request Approved"
                     data-body="Your Dental Assistance request (REF: REQ-2026-0005) has been approved. You are scheduled for Feb 10, 2026 at 9AM at the Barangay Health Center. Please bring your Valid ID and your reference number REQ-2026-0005."
                     data-time="2026-02-03T13:00:00"
                     data-link="my_requests_page.php">
                    <div class="notif-type-indicator type-service"></div>
                    <div class="notif-icon-wrap icon-service">✅</div>
                    <div class="notif-content-wrap">
                        <div class="notif-row-top">
                            <span class="notif-type-tag tag-service">Service Update</span>
                        </div>
                        <p class="notif-title">Dental Assistance Request Approved</p>
                        <p class="notif-preview">Your Dental Assistance request (REF: REQ-2026-0005) has been approved. Scheduled for Feb 10 at the Health Center...</p>
                        <div class="notif-meta">
                            <time class="notif-time" datetime="2026-02-03T13:00:00">Feb 3, 2026 · 1:00 PM</time>
                            <a href="my_requests_page.php" class="notif-link">View Request →</a>
                        </div>
                    </div>
                    <div class="notif-actions">
                        <button class="notif-action-btn dismiss-btn" title="Dismiss" data-id="9">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                </div>

            </div>

            <!-- EMPTY STATE -->
            <div class="notif-empty" id="notif-empty" style="display:none;">
                <div class="notif-empty-icon">🔔</div>
                <p class="notif-empty-title">No notifications found</p>
                <p class="notif-empty-sub">Try adjusting your filters or check back later.</p>
            </div>

            <!-- PAGINATION -->
            <div class="pagination-section" style="margin-top: 24px;">
                <button class="page-btn" id="prev-btn" disabled>&#8249; Previous</button>
                <div class="page-numbers">
                    <button class="page-num active">1</button>
                    <button class="page-num">2</button>
                </div>
                <button class="page-btn" id="next-btn">Next &#8250;</button>
            </div>
        </section>

    </main>
</div>

<!-- NOTIFICATION DETAIL MODAL -->
<div class="modal-overlay" id="modal-overlay" style="display:none;" aria-modal="true" role="dialog" aria-labelledby="modal-notif-title">
    <div class="modal-box">

        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon" id="modal-notif-icon">🔔</div>
                <div>
                    <h3 id="modal-notif-title">Notification</h3>
                    <p class="modal-subtitle" id="modal-notif-time">—</p>
                </div>
            </div>
            <button class="modal-close" id="modal-close" aria-label="Close">&times;</button>
        </div>

        <div class="modal-body" style="padding: 24px;">
            <div class="notif-modal-tag-row">
                <span class="notif-type-tag" id="modal-type-tag">—</span>
            </div>
            <p class="notif-modal-body-text" id="modal-body-text">—</p>
        </div>

        <div class="modal-footer">
            <button class="btn-secondary-portal" id="modal-close-btn">Close</button>
            <a href="#" class="btn-primary-portal" id="modal-action-link">Go to Page →</a>
        </div>

    </div>
</div>

<script src="../../scripts/portal/notifications_page.js"></script>

</body>
</html>