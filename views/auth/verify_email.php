<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Verify Email</title>

    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/auth/verify_email.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<nav id="navbar">
    <div class="navbar-container">
        <a href="../public/main.php" class="navbar-logo">
            <span>SKonnect</span>
        </a>
        <ul class="navbar-menu" id="navbarMenu">
            <li><a href="login.php" class="nav-link">Back</a></li>
        </ul>
    </div>
</nav>

<main class="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>

    <div class="verify-card">

        <!-- Logo -->
        <div class="card-logo">
            <img src="../../assets/img/logo.jpg" alt="SK Logo">
        </div>

        <!-- Title -->
        <h1 class="card-title">VERIFY EMAIL</h1>
        <p class="card-subtitle">
            Enter the 6-digit code sent to<br>
            <span class="email-highlight" id="userEmail">your email address</span>
        </p>

        <!-- OTP Form -->
        <form action="#" method="POST" id="otpForm">

            <div class="otp-group" role="group" aria-label="OTP Input">
                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="one-time-code" aria-label="Digit 1" required>
                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]" aria-label="Digit 2" required>
                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]" aria-label="Digit 3" required>
                <span class="otp-dash">—</span>
                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]" aria-label="Digit 4" required>
                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]" aria-label="Digit 5" required>
                <input type="text" class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]" aria-label="Digit 6" required>
            </div>

            <input type="hidden" name="otp" id="otpValue">

            <button type="submit" class="verify-btn">Verify Code</button>

        </form>

        <!-- Resend -->
        <div class="resend-block">
            <p class="resend-text">Didn't receive a code?</p>
            <button type="button" class="resend-btn" id="resendBtn" disabled>
                Resend Code <span class="countdown" id="countdown">(30s)</span>
            </button>
        </div>

    </div>
</main>

<script src="../../scripts/auth/verify_email.js"></script>
</body>
</html>