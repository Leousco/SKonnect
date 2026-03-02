<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Login</title>

    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../styles/auth/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<nav id="navbar">
    <div class="navbar-container">
        <a href="../public/main.php" class="navbar-logo">SKonnect</a>
        <ul class="navbar-menu">
            <li><a href="../public/main.php" class="nav-link">Back</a></li>
        </ul>
    </div>
</nav>

<main class="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>

    <div class="login-card">

        <div class="card-logo">
            <img src="../../assets/img/logo.jpg" alt="SK Logo">
        </div>

        <h1 class="card-title">LOGIN</h1>
        <p class="card-subtitle">Sign in to access portal services</p>

        <form id="loginForm" autocomplete="off">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="input-field" placeholder="Enter your email" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <div class="password-wrap">
                    <input type="password" id="password" name="password" class="input-field" placeholder="Enter your password" required>
                    <button type="button" class="toggle-pw" id="togglePw" aria-label="Toggle password visibility">
                        <i class="fa-solid fa-eye-slash"></i>
                    </button>                    
                </div>
            </div>

            <p id="loginMessage" class="form-message"></p>

            <button type="submit" class="login-btn">Login</button>

            <div class="form-footer">
                <a href="forgot_password.php" class="forgot-link">Forgot password?</a>
                <p class="register-block">
                    No Account? <a href="register.php" class="register-link">Register</a>
                </p>
            </div>
        </form>
    </div>
</main>

<script src="../../scripts/auth/login.js"></script>
</body>
</html>