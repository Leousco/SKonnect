<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Community Feed</title>
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/public/concerns.css">
    <link rel="stylesheet" href="../../styles/public/header.css">
    <link rel="stylesheet" href="../../styles/public/footer.css">
</head>
<body>

<?php include __DIR__ . '/../../components/public/navbar.php'; ?>


<main class="community-feed-page">

    <section class="feed-header">
        <h1>Community Concerns &amp; Inquiries</h1>
        <p>View, discuss, and track concerns from all members of the SK community.</p>
        <button class="new-thread-btn">✉ Submit a Concern</button>
    </section>

    <!-- COMMUNITY FEED -->
    <section class="community-feed">

        <article class="thread-card">
            <div class="thread-header">
                <span class="category-badge program">Program</span>
                <span class="priority-badge urgent">Urgent</span>
                <span class="status-badge pending">Pending</span>
            </div>
            <h3 class="thread-title">Scholarship Application Inquiry</h3>
            <p class="thread-snippet">Can SK provide guidance on how to submit the scholarship application for 2026?</p>
            <div class="thread-meta">
                <span>By: Maria Santos</span>
                <span>Feb 10, 2026</span>
                <span>💬 3 comments</span>
            </div>
            <button class="view-thread-btn">View &amp; Comment</button>
        </article>

        <article class="thread-card">
            <div class="thread-header">
                <span class="category-badge complaint">Complaint</span>
                <span class="priority-badge normal">Normal</span>
                <span class="status-badge responded">Responded</span>
            </div>
            <h3 class="thread-title">Street Lighting Issue</h3>
            <p class="thread-snippet">The street lights near Barangay Hall are not working. Please fix them as soon as possible.</p>
            <div class="thread-meta">
                <span>By: Juan Dela Cruz</span>
                <span>Feb 8, 2026</span>
                <span>💬 2 comments</span>
            </div>
            <button class="view-thread-btn">View &amp; Comment</button>
        </article>

        <article class="thread-card">
            <div class="thread-header">
                <span class="category-badge event">Event</span>
                <span class="priority-badge critical">Critical</span>
                <span class="status-badge resolved">Resolved</span>
            </div>
            <h3 class="thread-title">Community Clean-Up Drive Schedule</h3>
            <p class="thread-snippet">Requesting confirmation of the cleanup schedule for March. Many volunteers are waiting.</p>
            <div class="thread-meta">
                <span>By: Ana Reyes</span>
                <span>Feb 12, 2026</span>
                <span>💬 5 comments</span>
            </div>
            <button class="view-thread-btn">View &amp; Comment</button>
        </article>

        <article class="thread-card">
            <div class="thread-header">
                <span class="category-badge concern">Concern</span>
                <span class="priority-badge critical">Critical</span>
                <span class="status-badge open">Open</span>
            </div>
            <h3 class="thread-title">Broken Street Light on Sauyo Road</h3>
            <p class="thread-snippet">The street light near the barangay hall entrance has been out for two weeks. It's a safety hazard at night for residents walking home.</p>
            <div class="thread-meta">
                <span>By: Marco Santos</span>
                <span>Feb 17, 2026</span>
                <span>💬 12 comments</span>
            </div>
            <button class="view-thread-btn">View &amp; Comment</button>
        </article>

        <article class="thread-card">
            <div class="thread-header">
                <span class="category-badge suggestion">Suggestion</span>
                <span class="priority-badge medium">Medium</span>
                <span class="status-badge pending">Pending</span>
            </div>
            <h3 class="thread-title">Request for Basketball Court Repairs</h3>
            <p class="thread-snippet">The flooring on the covered court has cracks causing injuries during games. Requesting the SK to prioritize repairs before the sports league starts.</p>
            <div class="thread-meta">
                <span>By: Carlo Mendoza</span>
                <span>Feb 19, 2026</span>
                <span>💬 8 comments</span>
            </div>
            <button class="view-thread-btn">View &amp; Comment</button>
        </article>

        <article class="thread-card">
            <div class="thread-header">
                <span class="category-badge concern">Concern</span>
                <span class="priority-badge low">Low</span>
                <span class="status-badge pending">Pending</span>
            </div>
            <h3 class="thread-title">Flooding Near Purok 4 During Heavy Rain</h3>
            <p class="thread-snippet">Every time it rains heavily, the drainage near Purok 4 overflows and floods the pathway. Residents are asking if this can be raised to the barangay.</p>
            <div class="thread-meta">
                <span>By: Liza Bautista</span>
                <span>Feb 20, 2026</span>
                <span>💬 3 comments</span>
            </div>
            <button class="view-thread-btn">View &amp; Comment</button>
        </article>

        <!-- PAGINATION -->
    <section class="pagination">
        <button class="page-btn">Previous</button>
        <span class="page-number">Page 1 of 5</span>
        <button class="page-btn">Next</button>
    </section>
</main>

<?php include __DIR__ . '/../../components/public/footer.php'; ?>

<script src="../../scripts/public/main.js"></script>

</body>
</html>
