// ── TOAST NOTIFICATION ───────────────────────────────────────────────────────
function showToast(message, type = "error") {
    const existing = document.querySelector(".sk-toast");
    if (existing) existing.remove();
  
    const toast = document.createElement("div");
    toast.className = `sk-toast sk-toast--${type}`;
    toast.innerHTML = `
      <span class="sk-toast__icon">${type === "success" ? "✔" : "✖"}</span>
      <span class="sk-toast__msg">${message}</span>
    `;
    document.body.appendChild(toast);
  
    requestAnimationFrame(() => toast.classList.add("sk-toast--show"));
  
    setTimeout(() => {
      toast.classList.remove("sk-toast--show");
      toast.addEventListener("transitionend", () => toast.remove(), { once: true });
    }, 3500);
  }
  
  // ── TOGGLE PASSWORD ───────────────────────────────────────────────────────────
  function togglePassword(fieldId, icon) {
    const input = document.getElementById(fieldId);
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      input.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  }
  
  // ── LOGIN FORM SUBMIT ─────────────────────────────────────────────────────────
  const form = document.getElementById("loginForm");
  const emailInput = document.getElementById("email");
  const passwordInput = document.getElementById("password");
  
  form.addEventListener("submit", (e) => {
    e.preventDefault();
  
    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();
  
    if (!email || !password) {
      showToast("Please enter email and password.");
      return;
    }
  
    fetch("../../backend/routes/auth.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        action: "login",
        email: email,
        password: password,
      }),
    })
      .then((res) => res.json())
      .then((data) => {
        console.log("DEBUG: Server response:", data);
        showToast(data.message, data.status === "success" ? "success" : "error");
  
        if (data.status === "success" || data.status === "unverified") {
          setTimeout(() => {
            window.location.href = data.redirect;
          }, 1200);
        }
      })
      .catch((err) => {
        console.error("DEBUG: Fetch error:", err);
        showToast("Server error. Please try again.");
      });
  });