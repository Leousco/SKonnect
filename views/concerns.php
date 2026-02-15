<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Community Feed</title>
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/concerns.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/footer.css">
</head>
<body>

<div id="navbar"></div>


<main class="community-feed-page">

    <section class="feed-header">
        <h1>Community Concerns &amp; Inquiries</h1>
        <p>View, discuss, and track concerns from all members of the SK community.</p>
        <button class="new-thread-btn">+ Submit New Concern</button>
    </section>

    <!-- NEW THREAD FORM -->
    <section class="new-thread-form">
        <form class="concern-form" enctype="multipart/form-data">

            <div class="form-row">
                <div>
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="program">Program</option>
                        <option value="event">Event</option>
                        <option value="complaint">Complaint</option>
                        <option value="inquiry">Inquiry</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="priority">Priority</label>
                    <select id="priority" name="priority">
                        <option value="normal">Normal</option>
                        <option value="urgent">Urgent</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>
            </div>

            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" placeholder="Enter concern title" required>

            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5" placeholder="Write your concern here..." required></textarea>

            <label for="attachments">Attachments (optional)</label>
            <input type="file" id="attachments" name="attachments[]" multiple>

            <button type="submit" class="submit-btn">Post Message</button>
        </form>
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

    </section>
</main>

<div id="footer"></div>

<script src="../scripts/main.js"></script>
</body>
</html>
