<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Request Services</title>

    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/portal/sidebar.css">
    <link rel="stylesheet" href="../../styles/portal/topbar.css">

    <link rel="stylesheet" href="../../styles/portal/services_page.css">
</head>
<body>

<div class="dashboard-layout">

    <?php include __DIR__ . '/../../components/portal/sidebar.php'; ?>

    <main class="dashboard-content">

    <?php
    $pageTitle      = 'Request Services';
    $pageBreadcrumb = [['Home', '#'], ['Services', null]];
    $userName       = 'Juan Dela Cruz';
    $userRole       = 'SK Member';
    $notifCount     = 3;
    include __DIR__ . '/../../components/portal/topbar.php';
    ?>

        <!-- STATS WIDGETS -->
        <!-- <section class="dashboard-widgets">
            <div class="widget-card">
                <h3>Available Services</h3>
                <p class="widget-number">6</p>
                <span class="widget-sub">Active programs</span>
            </div>
            <div class="widget-card">
                <h3>My Requests</h3>
                <p class="widget-number">2</p>
                <span class="widget-sub">Submitted by you</span>
            </div>
            <div class="widget-card">
                <h3>Under Review</h3>
                <p class="widget-number">1</p>
                <span class="widget-sub">Awaiting SK decision</span>
            </div>
            <div class="widget-card">
                <h3>Approved</h3>
                <p class="widget-number">1</p>
                <span class="widget-sub">Ready for claiming</span>
            </div>
        </section> -->

        <!-- HOW IT WORKS -->
        <section class="how-it-works-section">
            <h2 class="section-label">How It Works</h2>
            <div class="steps-row">
                <div class="step-item">
                    <div class="step-num">1</div>
                    <div class="step-body">
                        <strong>Choose a Service</strong>
                        <p>Browse available programs and click "Request Service".</p>
                    </div>
                </div>
                <div class="step-arrow">›</div>
                <div class="step-item">
                    <div class="step-num">2</div>
                    <div class="step-body">
                        <strong>Fill Out the Form</strong>
                        <p>Complete the request form and upload required documents.</p>
                    </div>
                </div>
                <div class="step-arrow">›</div>
                <div class="step-item">
                    <div class="step-num">3</div>
                    <div class="step-body">
                        <strong>SK Review</strong>
                        <p>An SK officer reviews and verifies your submission.</p>
                    </div>
                </div>
                <div class="step-arrow">›</div>
                <div class="step-item">
                    <div class="step-num">4</div>
                    <div class="step-body">
                        <strong>Claim Assistance</strong>
                        <p>Get notified and claim your approved assistance.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTROLS -->
        <section class="announcements-controls">
            <div class="controls-left">
                <div class="search-wrap">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="svc-search" placeholder="Search services..." class="ann-search-input">
                </div>
            </div>
            <div class="controls-right">
                <select id="svc-category" class="ann-select">
                    <option value="all">All Categories</option>
                    <option value="medical">Medical</option>
                    <option value="education">Education</option>
                    <option value="livelihood">Livelihood</option>
                    <option value="scholarship">Scholarship</option>
                </select>
                <select id="svc-status" class="ann-select">
                    <option value="all">All Statuses</option>
                    <option value="open">Open</option>
                    <option value="limited">Limited Slots</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
        </section>

        <!-- SERVICES GRID -->
        <section class="announcements-section">
            <h2 class="section-label">Available Services</h2>

            <div class="announcements-grid" id="svc-grid">

                <!-- CARD 1 -->
                <article class="ann-card svc-card" data-category="medical" data-status="open">
                    <div class="ann-card-body">
                        <div class="svc-card-top">
                            <div class="svc-icon-wrap svc-icon-medical">🏥</div>
                            <span class="feed-badge status-open">Open</span>
                        </div>
                        <h3 class="ann-card-title">Medical Assistance</h3>
                        <p class="ann-card-excerpt">Financial assistance for medical bills, prescriptions, and emergency care for youth residents of Barangay Sauyo.</p>
                        <ul class="svc-details">
                            <li><span class="svc-detail-label">Eligibility</span>Registered youth resident</li>
                            <li><span class="svc-detail-label">Processing</span>3–5 working days</li>
                            <li><span class="svc-detail-label">Required</span>Valid ID, Medical Certificate</li>
                        </ul>
                        <div class="ann-card-actions">
                            <button class="btn-primary-portal svc-request-btn"
                                data-service="Medical Assistance"
                                data-icon="🏥"
                                data-eligibility="Registered youth resident"
                                data-processing="3–5 working days"
                                data-requirements="Valid ID, Medical Certificate">
                                Request Service
                            </button>
                            <span class="svc-category-tag tag-medical">Medical</span>
                        </div>
                    </div>
                </article>

                <!-- CARD 2 -->
                <article class="ann-card svc-card" data-category="education" data-status="open">
                    <div class="ann-card-body">
                        <div class="svc-card-top">
                            <div class="svc-icon-wrap svc-icon-education">🎓</div>
                            <span class="feed-badge status-open">Open</span>
                        </div>
                        <h3 class="ann-card-title">Educational Support</h3>
                        <p class="ann-card-excerpt">Assistance for school supplies, tuition fees, and academic-related expenses for currently enrolled students.</p>
                        <ul class="svc-details">
                            <li><span class="svc-detail-label">Eligibility</span>Currently enrolled student</li>
                            <li><span class="svc-detail-label">Processing</span>5–7 working days</li>
                            <li><span class="svc-detail-label">Required</span>Enrollment Certificate, Valid ID</li>
                        </ul>
                        <div class="ann-card-actions">
                            <button class="btn-primary-portal svc-request-btn"
                                data-service="Educational Support"
                                data-icon="🎓"
                                data-eligibility="Currently enrolled student"
                                data-processing="5–7 working days"
                                data-requirements="Enrollment Certificate, Valid ID">
                                Request Service
                            </button>
                            <span class="svc-category-tag tag-education">Education</span>
                        </div>
                    </div>
                </article>

                <!-- CARD 3 -->
                <article class="ann-card svc-card" data-category="scholarship" data-status="limited">
                    <div class="ann-card-body">
                        <div class="svc-card-top">
                            <div class="svc-icon-wrap svc-icon-scholarship">🏅</div>
                            <span class="feed-badge status-limited">Limited Slots</span>
                        </div>
                        <h3 class="ann-card-title">Scholarship Program</h3>
                        <p class="ann-card-excerpt">Apply for SK scholarship programs for qualified youth residents who meet the academic requirements and GPA threshold.</p>
                        <ul class="svc-details">
                            <li><span class="svc-detail-label">Eligibility</span>GPA 1.75 or higher</li>
                            <li><span class="svc-detail-label">Processing</span>2–3 weeks</li>
                            <li><span class="svc-detail-label">Required</span>Transcript of Records, Endorsement</li>
                        </ul>
                        <div class="ann-card-actions">
                            <button class="btn-primary-portal svc-request-btn"
                                data-service="Scholarship Program"
                                data-icon="🏅"
                                data-eligibility="GPA 1.75 or higher"
                                data-processing="2–3 weeks"
                                data-requirements="Transcript of Records, Endorsement Letter">
                                Apply Now
                            </button>
                            <span class="svc-category-tag tag-scholarship">Scholarship</span>
                        </div>
                    </div>
                </article>

                <!-- CARD 4 -->
                <article class="ann-card svc-card" data-category="livelihood" data-status="open">
                    <div class="ann-card-body">
                        <div class="svc-card-top">
                            <div class="svc-icon-wrap svc-icon-livelihood">📚</div>
                            <span class="feed-badge status-open">Open</span>
                        </div>
                        <h3 class="ann-card-title">Livelihood Support</h3>
                        <p class="ann-card-excerpt">Training programs and financial support for youth livelihood projects to help young residents become self-sufficient.</p>
                        <ul class="svc-details">
                            <li><span class="svc-detail-label">Eligibility</span>Youth residents, 15–30 yrs old</li>
                            <li><span class="svc-detail-label">Processing</span>1–2 weeks</li>
                            <li><span class="svc-detail-label">Required</span>Project Proposal, Valid ID</li>
                        </ul>
                        <div class="ann-card-actions">
                            <button class="btn-primary-portal svc-request-btn"
                                data-service="Livelihood Support"
                                data-icon="📚"
                                data-eligibility="Youth residents, 15–30 years old"
                                data-processing="1–2 weeks"
                                data-requirements="Project Proposal, Valid ID">
                                Apply Now
                            </button>
                            <span class="svc-category-tag tag-livelihood">Livelihood</span>
                        </div>
                    </div>
                </article>

                <!-- CARD 5 -->
                <article class="ann-card svc-card" data-category="medical" data-status="open">
                    <div class="ann-card-body">
                        <div class="svc-card-top">
                            <div class="svc-icon-wrap svc-icon-medical">🩺</div>
                            <span class="feed-badge status-open">Open</span>
                        </div>
                        <h3 class="ann-card-title">Dental Assistance</h3>
                        <p class="ann-card-excerpt">Free or subsidized dental check-ups and treatments for eligible youth residents of Barangay Sauyo.</p>
                        <ul class="svc-details">
                            <li><span class="svc-detail-label">Eligibility</span>Registered youth resident</li>
                            <li><span class="svc-detail-label">Processing</span>3–5 working days</li>
                            <li><span class="svc-detail-label">Required</span>Valid ID, Dental History</li>
                        </ul>
                        <div class="ann-card-actions">
                            <button class="btn-primary-portal svc-request-btn"
                                data-service="Dental Assistance"
                                data-icon="🩺"
                                data-eligibility="Registered youth resident"
                                data-processing="3–5 working days"
                                data-requirements="Valid ID, Dental History">
                                Request Service
                            </button>
                            <span class="svc-category-tag tag-medical">Medical</span>
                        </div>
                    </div>
                </article>

                <!-- CARD 6 -->
                <article class="ann-card svc-card" data-category="livelihood" data-status="closed">
                    <div class="ann-card-body">
                        <div class="svc-card-top">
                            <div class="svc-icon-wrap svc-icon-livelihood">🛠️</div>
                            <span class="feed-badge status-closed">Closed</span>
                        </div>
                        <h3 class="ann-card-title">Skills Training Program</h3>
                        <p class="ann-card-excerpt">Support for youth to learn new skills, attend workshops, and start livelihood projects. Next intake opens March 2026.</p>
                        <ul class="svc-details">
                            <li><span class="svc-detail-label">Eligibility</span>Youth residents, 15–30 yrs old</li>
                            <li><span class="svc-detail-label">Processing</span>1–2 weeks</li>
                            <li><span class="svc-detail-label">Required</span>Valid ID, Training Application Form</li>
                        </ul>
                        <div class="ann-card-actions">
                            <button class="btn-primary-portal svc-request-btn" disabled>
                                Currently Closed
                            </button>
                            <span class="svc-category-tag tag-livelihood">Livelihood</span>
                        </div>
                    </div>
                </article>

            </div>

            <div class="no-results" id="no-results" style="display:none;">
                <p>No services found matching your search.</p>
            </div>
        </section>

    </main>
</div>

<!-- REQUEST MODAL -->
<div class="modal-overlay" id="modal-overlay" style="display:none;" aria-modal="true" role="dialog" aria-labelledby="modal-title">
    <div class="modal-box">

        <div class="modal-header">
            <div class="modal-header-left">
                <div class="modal-icon" id="modal-svc-icon">🏥</div>
                <div>
                    <h3 id="modal-title">Service Request</h3>
                    <p class="modal-subtitle">All fields marked <span class="required-star">*</span> are required.</p>
                </div>
            </div>
            <button class="modal-close" id="modal-close" aria-label="Close">&times;</button>
        </div>

        <div class="modal-svc-summary" id="modal-svc-summary">
            <div class="svc-summary-item">
                <span class="svc-summary-label">Eligibility</span>
                <span id="sum-eligibility">—</span>
            </div>
            <div class="svc-summary-item">
                <span class="svc-summary-label">Processing Time</span>
                <span id="sum-processing">—</span>
            </div>
            <div class="svc-summary-item">
                <span class="svc-summary-label">Requirements</span>
                <span id="sum-requirements">—</span>
            </div>
        </div>

        <div class="modal-body">
            <form class="concern-form" id="svc-form" enctype="multipart/form-data" novalidate>

                <div class="modal-row">
                    <div class="form-group">
                        <label class="modal-label" for="r-name">Full Name <span class="required-star">*</span></label>
                        <input type="text" class="ann-search-input modal-input" id="r-name" name="full_name" placeholder="e.g. Juan Dela Cruz" required>
                        <span class="field-error" id="err-name"></span>
                    </div>
                    <div class="form-group">
                        <label class="modal-label" for="r-contact">Contact Number <span class="required-star">*</span></label>
                        <input type="tel" class="ann-search-input modal-input" id="r-contact" name="contact" placeholder="e.g. 09XX XXX XXXX" required>
                        <span class="field-error" id="err-contact"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="modal-label" for="r-address">Home Address <span class="required-star">*</span></label>
                    <input type="text" class="ann-search-input modal-input" id="r-address" name="address" placeholder="Purok/Street, Barangay Sauyo" required>
                    <span class="field-error" id="err-address"></span>
                </div>

                <div class="form-group">
                    <label class="modal-label" for="r-purpose">Purpose / Details <span class="required-star">*</span></label>
                    <textarea class="concern-textarea" id="r-purpose" name="purpose" rows="4"
                        placeholder="Briefly explain why you are requesting this service and how it will help you…" required></textarea>
                    <span class="field-error" id="err-purpose"></span>
                </div>

                <div class="form-group">
                    <label class="modal-label" for="r-docs">Upload Documents <span class="required-star">*</span></label>
                    <div class="file-drop-zone" id="file-drop-zone">
                        <input type="file" id="r-docs" name="documents[]" multiple class="file-input-hidden"
                            accept="image/*,.pdf,.doc,.docx">
                        <div class="file-drop-inner">
                            <span class="file-drop-icon">📎</span>
                            <span class="file-drop-text">Drag & drop files here or
                                <button type="button" class="file-browse-btn" id="file-browse-btn">browse</button>
                            </span>
                            <span class="file-drop-hint">Accepted: Images, PDF, DOC — Max 5MB each</span>
                        </div>
                        <ul class="file-list" id="file-list"></ul>
                    </div>
                    <span class="field-error" id="err-docs"></span>
                </div>

                <div class="form-group svc-acknowledge">
                    <label class="acknowledge-wrap">
                        <input type="checkbox" id="r-agree" name="agree">
                        <span>I confirm that all information provided is accurate and I meet the eligibility requirements for this service.</span>
                    </label>
                    <span class="field-error" id="err-agree"></span>
                </div>

            </form>
        </div>

        <div class="modal-footer">
            <button class="btn-secondary-portal" id="modal-cancel" type="button">Cancel</button>
            <button class="btn-primary-portal" id="modal-submit" type="button">📨 Submit Request</button>
        </div>

    </div>
</div>

<script src="../../scripts/portal/services_page.js"></script>

</body>
</html>