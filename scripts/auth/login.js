// Toggle password visibility
document.getElementById('togglePw').addEventListener('click', () => {
    const pw = document.getElementById('password');
    pw.type = pw.type === 'password' ? 'text' : 'password';
});

// Login form submit
const form = document.getElementById('loginForm');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const messageEl = document.getElementById('loginMessage');

form.addEventListener('submit', (e) => {
    e.preventDefault();

    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();

    if (!email || !password) {
        messageEl.textContent = "Please enter email and password.";
        messageEl.style.color = "red";
        return;
    }

    fetch("../../backend/routes/auth.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({
            action: "login",
            email: email,
            password: password
        })
    })
    .then(res => res.json())
    .then(data => {
        console.log("DEBUG: Server response:", data); // <-- debug output
        messageEl.textContent = data.message;
        messageEl.style.color = data.status === "success" ? "green" : "red";

        if (data.status === "success" || data.status === "unverified") {
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 1000);
        }
    })
    .catch(err => {
        console.error("DEBUG: Fetch error:", err);
        messageEl.textContent = "Server error. Please try again.";
        messageEl.style.color = "red";
    });
});