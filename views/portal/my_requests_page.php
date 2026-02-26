<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | My Requests</title>

    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/portal/sidebar.css">
    <link rel="stylesheet" href="../../styles/portal/topbar.css">
    <link rel="stylesheet" href="../../styles/portal/dashboard.css">
    <link rel="stylesheet" href="../../styles/portal/my_requests_page.css">
    <link rel="stylesheet" href="../../styles/portal/announcements_page.css">
</head>
<body>

<div class="dashboard-layout">

    <?php include __DIR__ . '/../../components/portal/sidebar.php'; ?>

    <main class="dashboard-content">

    <?php
    $pageTitle      = 'My Requests';
    $pageBreadcrumb = [['Home', '#'], ['My Requests', null]];
    $userName       = 'Juan Dela Cruz';
    $userRole       = 'SK Member';
    $notifCount     = 3;
    include __DIR__ . '/../../components/portal/topbar.php';
    ?>

        <!-- STAT WIDGETS -->
        <section class="dashboard-widgets">
            <div class="widget-card">
                <h3>Total Requests</h3>
                <p class="widget-number">5</p>
                <span class="widget-sub">All submissions</span>
            </div>
            <div class="widget-card">
                <h3>Under Review</h3>
                <p class="widget-number">2</p>
                <span class="widget-sub">Awaiting SK decision</span>
            </div>
            <div class="widget-card">
                <h3>Approved</h3>
                <p class="widget-number">2</p>
                <span class="widget-sub">Ready for claiming</span>
            </div>
            <div class="widget-card">
                <h3>Rejected</h3>
                <p class="widget-number">1</p>
                <span class="widget-sub">See details for reason</span>
            </div>
        </section>

        <!-- CONTROLS -->
        <section class="announcements-controls">
            <div class="controls-left">
                <div class="search-wrap">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="req-search" placeholder="Search requests..." class="ann-search-input">
                </div>
            </div>
            <div class="controls-right">
                <select id="req-status" class="ann-select">
                    <option value="all">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="under-review">Under Review</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
                <select id="req-category" class="ann-select">
                    <option value="all">All Categories</option>
                    <option value="medical">Medical</option>
                    <option value="education">Education</option>
                    <option value="scholarship">Scholarship</option>
                    <option value="livelihood">Livelihood</option>
                </select>
                <select id="req-sort" class="ann-select">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                </select>
            </div>
        </section>

        <!-- REQUESTS TABLE -->
        <section class="announcements-section">
            <h2 class="section-label">My Service Requests</h2>

            <!-- TABLE VIEW -->
            <div class="req-table-wrap">
                <table class="req-table" id="req-table">
                    <thead>
                        <tr>
                            <th>Reference No.</th>
                            <th>Service</th>
                            <th>Category</th>
                            <th>Date Submitted</th>
                            <th>Status</th>
                            <th>Last Update</th>
                            <th class="col-action">Action</th>
                        </tr>
                    </thead>
                    <tbody id="req-tbody">

                        <!-- ROW 1 -->
                        <tr class="req-row" data-status="approved" data-category="medical"
                            data-service="Medical Assistance"
                            data-ref="REQ-2026-0012"
                            data-submitted="Feb 10, 2026"
                            data-updated="Feb 15, 2026"
                            data-purpose="I am requesting financial assistance for my hospitalization last January 2026 due to dengue fever. Total hospital bill amounted to ₱12,400."
                            data-officer="SK Chairperson Maria Reyes"
                            data-officer-date="Feb 15, 2026"
                            data-officer-note="Request has been approved. Please visit the SK office on Feb 18–20, 2026 between 8AM–12PM to claim your assistance. Bring a valid ID and this reference number."
                            data-docs="Medical Certificate, Hospital Bill">
                            <td class="ref-col"><span class="ref-num">REQ-2026-0012</span></td>
                            <td><span class="svc-name">🏥 Medical Assistance</span></td>
                            <td><span class="req-cat-tag tag-medical">Medical</span></td>
                            <td>Feb 10, 2026</td>
                            <td><span class="req-status-badge status-approved">Approved</span></td>
                            <td class="update-col">Feb 15, 2026</td>
                            <td><button class="btn-view-req" data-row="0">View Details</button></td>
                        </tr>

                        <!-- ROW 2 -->
                        <tr class="req-row" data-status="under-review" data-category="scholarship"
                            data-service="Scholarship Program"
                            data-ref="REQ-2026-0018"
                            data-submitted="Feb 14, 2026"
                            data-updated="Feb 17, 2026"
                            data-purpose="Applying for the SK Scholarship Program for the 2nd semester of AY 2025–2026. I am currently enrolled at PLM Manila taking up BS Computer Science."
                            data-officer="SK Secretary Carlo Tan"
                            data-officer-date="Feb 17, 2026"
                            data-officer-note="Your application is currently under review. Please ensure that your Transcript of Records is certified true copy. We will notify you once a final decision is made."
                            data-docs="Transcript of Records, Enrollment Certificate, Endorsement Letter">
                            <td class="ref-col"><span class="ref-num">REQ-2026-0018</span></td>
                            <td><span class="svc-name">🏅 Scholarship Program</span></td>
                            <td><span class="req-cat-tag tag-scholarship">Scholarship</span></td>
                            <td>Feb 14, 2026</td>
                            <td><span class="req-status-badge status-under-review">Under Review</span></td>
                            <td class="update-col">Feb 17, 2026</td>
                            <td><button class="btn-view-req" data-row="1">View Details</button></td>
                        </tr>

                        <!-- ROW 3 -->
                        <tr class="req-row" data-status="pending" data-category="education"
                            data-service="Educational Support"
                            data-ref="REQ-2026-0021"
                            data-submitted="Feb 19, 2026"
                            data-updated="Feb 19, 2026"
                            data-purpose="Requesting assistance for school supplies and enrollment fees for the upcoming semester. I am a 3rd year student at PUP."
                            data-officer=""
                            data-officer-date=""
                            data-officer-note=""
                            data-docs="Enrollment Certificate, Valid ID">
                            <td class="ref-col"><span class="ref-num">REQ-2026-0021</span></td>
                            <td><span class="svc-name">🎓 Educational Support</span></td>
                            <td><span class="req-cat-tag tag-education">Education</span></td>
                            <td>Feb 19, 2026</td>
                            <td><span class="req-status-badge status-pending">Pending</span></td>
                            <td class="update-col">Feb 19, 2026</td>
                            <td><button class="btn-view-req" data-row="2">View Details</button></td>
                        </tr>

                        <!-- ROW 4 -->
                        <tr class="req-row" data-status="rejected" data-category="livelihood"
                            data-service="Livelihood Support"
                            data-ref="REQ-2026-0009"
                            data-submitted="Feb 5, 2026"
                            data-updated="Feb 12, 2026"
                            data-purpose="Requesting financial support and training for a small food stall business I plan to start near our barangay."
                            data-officer="SK Treasurer Ana Lim"
                            data-officer-date="Feb 12, 2026"
                            data-officer-note="We regret to inform you that your request has been rejected at this time. The current livelihood fund has been fully allocated. You may reapply once the next funding cycle opens in April 2026. We encourage you to attend the upcoming livelihood seminar on March 5."
                            data-docs="Project Proposal, Valid ID, Barangay Certificate">
                            <td class="ref-col"><span class="ref-num">REQ-2026-0009</span></td>
                            <td><span class="svc-name">📚 Livelihood Support</span></td>
                            <td><span class="req-cat-tag tag-livelihood">Livelihood</span></td>
                            <td>Feb 5, 2026</td>
                            <td><span class="req-status-badge status-rejected">Rejected</span></td>
                            <td class="update-col">Feb 12, 2026</td>
                            <td><button class="btn-view-req" data-row="3">View Details</button></td>
                        </tr>

                        <!-- ROW 5 -->
                        <tr class="req-row" data-status="approved" data-category="medical"
                            data-service="Dental Assistance"
                            data-ref="REQ-2026-0005"
                            data-submitted="Jan 28, 2026"
                            data-updated="Feb 3, 2026"
                            data-purpose="Requesting dental assistance for tooth extraction and filling. I have not been able to afford dental care for over a year."
                            data-officer="SK Chairperson Maria Reyes"
                            data-officer-date="Feb 3, 2026"
                            data-officer-note="Approved. You are scheduled for dental assistance on Feb 10, 2026 at 9AM at the Barangay Health Center. Please bring your Valid ID and this reference number."
                            data-docs="Valid ID, Dental History Form">
                            <td class="ref-col"><span class="ref-num">REQ-2026-0005</span></td>
                            <td><span class="svc-name">🩺 Dental Assistance</span></td>
                            <td><span class="req-cat-tag tag-medical">Medical</span></td>
                            <td>Jan 28, 2026</td>
                            <td><span class="req-status-badge status-approved">Approved</span></td>
                            <td class="update-col">Feb 3, 2026</td>
                            <td><button class="btn-view-req" data-row="4">View Details</button></td>
                        </tr>

                    </tbody>
                </table>

                <div class="no-results" id="no-results" style="display:none;">
                    <p>No requests found matching your search.</p>
                </div>
            </div>

            <!-- PAGINATION -->
            <div class="pagination-section" style="margin-top: 24px;">
                <button class="page-btn" id="prev-btn" disabled>&#8249; Previous</button>
                <div class="page-numbers">
                    <button class="page-num active">1</button>
                    <button class="page-num">2</button>
                    <button class="page-num">3</button>
                </div>
                <button class="page-btn" id="next-btn">Next &#8250;</button>
            </div>
        </section>

    </main>
</div>

<!-- VIEW DETAILS MODAL -->
<div class="modal-overlay" id="modal-overlay" style="display:none;" aria-modal="true" role="dialog" aria-labelledby="modal-title">
    <div class="modal-box modal-box-lg">

        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon" id="modal-svc-icon">📋</div>
                <div>
                    <h3 id="modal-title">Request Details</h3>
                    <p class="modal-subtitle" id="modal-ref-num">REF: —</p>
                </div>
            </div>
            <button class="modal-close" id="modal-close" aria-label="Close">&times;</button>
        </div>

        <!-- STATUS STRIP -->
        <div class="modal-status-strip" id="modal-status-strip">
            <div class="strip-item">
                <span class="strip-label">Status</span>
                <span id="strip-status">—</span>
            </div>
            <div class="strip-item">
                <span class="strip-label">Date Submitted</span>
                <span id="strip-submitted">—</span>
            </div>
            <div class="strip-item">
                <span class="strip-label">Last Updated</span>
                <span id="strip-updated">—</span>
            </div>
            <div class="strip-item">
                <span class="strip-label">Documents Uploaded</span>
                <span id="strip-docs">—</span>
            </div>
        </div>

        <div class="modal-body">

            <!-- MY SUBMISSION -->
            <div class="req-detail-block">
                <h4 class="req-detail-heading">📝 My Submission</h4>
                <p class="req-detail-text" id="detail-purpose">—</p>
            </div>

            <!-- TIMELINE -->
            <div class="req-detail-block">
                <h4 class="req-detail-heading">📋 Request Timeline</h4>
                <div class="req-timeline" id="req-timeline">
                    <!-- Injected by JS -->
                </div>
            </div>

            <!-- SK RESPONSE (shown if exists) -->
            <div class="req-detail-block" id="sk-response-block" style="display:none;">
                <h4 class="req-detail-heading">💬 SK Officer Response</h4>
                <div class="sk-response-card">
                    <div class="sk-response-header">
                        <div class="sk-avatar">SK</div>
                        <div>
                            <strong id="resp-officer">—</strong>
                            <span class="resp-date" id="resp-date">—</span>
                        </div>
                    </div>
                    <p class="sk-response-text" id="resp-note">—</p>
                </div>
            </div>

            <!-- NO RESPONSE YET (shown if no response) -->
            <div class="req-detail-block" id="no-response-block" style="display:none;">
                <h4 class="req-detail-heading">💬 SK Officer Response</h4>
                <div class="no-response-yet">
                    <span>🕐</span>
                    <p>No response yet. You will be notified once an SK officer reviews your request.</p>
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button class="btn-secondary-portal" id="modal-close-btn" type="button">Close</button>
        </div>

    </div>
</div>

<script src="../../scripts/portal/my_requests_page.js"></script>

</body>
</html>