<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Services</title>

    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/public/services.css">
    <link rel="stylesheet" href="../../styles/public/header.css">
    <link rel="stylesheet" href="../../styles/public/footer.css">
</head>
<body>

<?php include __DIR__ . '/../../components/public/navbar.php'; ?>

<main class="services-page">

    <!-- HEADER -->
    <section class="services-header">
        <h1>Community Services</h1>
        <p>
            Request assistance and support programs offered by the SK of Barangay Sauyo.
        </p>
    </section>

    <!-- SERVICES GRID -->
    <section class="services-list">
        <div class="services-grid">

            <!-- Example services -->
            <article class="service-card">
                <div class="service-icon">🏥</div>
                <h3>Medical Assistance</h3>
                <p>Financial assistance for medical bills, prescriptions, and emergency care.</p>
                <ul class="service-details">
                    <li>Eligibility: Registered youth resident</li>
                    <li>Processing Time: 3–5 working days</li>
                    <li>Required: Valid ID, Medical Certificate</li>
                </ul>
                <button class="request-btn">Request Service</button>
            </article>

            <article class="service-card">
                <div class="service-icon">🎓</div>
                <h3>Educational Support</h3>
                <p>Assistance for school supplies, tuition, and academic-related expenses.</p>
                <ul class="service-details">
                    <li>Eligibility: Currently enrolled student</li>
                    <li>Processing Time: 5–7 working days</li>
                    <li>Required: Enrollment Certificate</li>
                </ul>
                <button class="request-btn">Request Service</button>
            </article>

            <article class="service-card">
                <div class="service-icon">🏅</div>
                <h3>Scholarship Program</h3>
                <p>Apply for SK scholarship programs for qualified youth residents.</p>
                <ul class="service-details">
                    <li>Eligibility: GPA Requirement</li>
                    <li>Processing Time: 2–3 weeks</li>
                    <li>Required: Transcript of Records</li>
                </ul>
                <button class="request-btn">Apply Now</button>
            </article>

            <article class="service-card">
                <div class="service-icon">📚</div>
                <h3>Livelihood Support</h3>
                <p>Training programs and financial support for youth livelihood projects.</p>
                <ul class="service-details">
                    <li>Eligibility: Youth residents</li>
                    <li>Processing Time: 1–2 weeks</li>
                    <li>Required: Project Proposal</li>
                </ul>
                <button class="request-btn">Apply Now</button>
            </article>

            <article class="service-card">
                <div class="service-icon">🩺</div>
                <h3>Dental Assistance</h3>
                <p>Free or subsidized dental check-ups and treatments.</p>
                <ul class="service-details">
                    <li>Eligibility: Registered youth resident</li>
                    <li>Processing Time: 3–5 days</li>
                    <li>Required: ID, Dental History</li>
                </ul>
                <button class="request-btn">Request Service</button>
            </article>

            <article class="service-card">
                <div class="service-icon">🛠️</div>
                <h3>Livelihood & Skills Training</h3>
                <p>
                    Support for youth to learn new skills, attend training, and start livelihood projects.
                </p>

                <ul class="service-details">
                    <li>Eligibility: Youth residents, 15–30 years old</li>
                    <li>Processing Time: 1–2 weeks</li>
                    <li>Required: Valid ID, Training Application Form</li>
                </ul>

                <button class="request-btn">Apply Now</button>
            </article>

        </div>
    </section>


    <!-- HOW IT WORKS -->
    <section class="how-it-works">
        <h2>How It Works</h2>

        <div class="steps">
            <div class="step">
                <span>1</span>
                <p>Select a service and submit your request.</p>
            </div>

            <div class="step">
                <span>2</span>
                <p>Fill out and upload required documents for verification.</p>
            </div>

            <div class="step">
                <span>3</span>
                <p>Wait for SK officer review and approval.</p>
            </div>

            <div class="step">
                <span>4</span>
                <p>Receive status updates and claim assistance.</p>
            </div>
        </div>
    </section>


</main>

<?php include __DIR__ . '/../../components/public/footer.php'; ?>

<script src="../../scripts/public/main.js"></script>

</body>
</html>
