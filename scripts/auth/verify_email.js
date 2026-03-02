// =============================
// OTP INPUT AUTO BEHAVIOR
// =============================

const inputs = document.querySelectorAll('.otp-input');
const otpValue = document.getElementById('otpValue');
const form = document.getElementById('otpForm');
let messageEl = document.getElementById('message');
const resendBtn = document.getElementById('resendBtn');
const countdownEl = document.getElementById('countdown');

// Auto advance / backspace / paste
inputs.forEach((input, i) => {
    input.addEventListener('input', (e) => {
        const val = e.target.value.replace(/\D/g, '');
        e.target.value = val;
        if (val && i < inputs.length - 1) inputs[i + 1].focus();
        syncOTP();
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !input.value && i > 0) {
            inputs[i - 1].focus();
            inputs[i - 1].value = '';
            syncOTP();
        }
    });

    input.addEventListener('paste', (e) => {
        e.preventDefault();
        const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
        pasted.split('').forEach((char, idx) => {
            if (inputs[idx]) inputs[idx].value = char;
        });
        const next = Math.min(pasted.length, inputs.length - 1);
        inputs[next].focus();
        syncOTP();
    });
});

function syncOTP() {
    otpValue.value = Array.from(inputs).map(i => i.value).join('');
}

// =============================
// AJAX VERIFY
// =============================

form.addEventListener('submit', function (e) {
    e.preventDefault();

    const otp = otpValue.value;

    if (otp.length !== 6) {
        showMessage("Please enter complete 6-digit OTP.", "error");
        return;
    }

    fetch("../../backend/routes/auth.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({
            action: "verify_otp",
            otp: otp
        })
    })
    .then(async res => {
        const text = await res.text(); // get raw PHP response
        try {
            return JSON.parse(text); // try parse JSON
        } catch(e) {
            // Show raw PHP output if JSON parsing fails
            showMessage("PHP Response: " + text, "error");
            throw e;
        }
    })
    .then(data => {
        if (data.status === "success") {
            showMessage(data.message, "success");
            setTimeout(() => {
                window.location.href = "login.php?verified=1";
            }, 1500);
        } else {
            showMessage(data.message, "error");
        }
    })
    .catch(() => showMessage("Server error. Please try again.", "error"));
});

// =============================
// SHOW MESSAGE
// =============================
function showMessage(text, type) {
    if (!messageEl) {
        messageEl = document.createElement('div');
        form.appendChild(messageEl);
    }

    messageEl.innerHTML = type === "success"
        ? `<span style="color:green;">✔ ${text}</span>`
        : `<span style="color:red;">✖ ${text}</span>`;
}

// =============================
// COUNTDOWN TIMER & RESEND
// =============================
let timer = 30;
let interval = startCountdown(timer);

resendBtn.addEventListener('click', () => {
    if (resendBtn.disabled) return;

    resendBtn.disabled = true;
    clearInterval(interval);
    timer = 60;
    countdownEl.textContent = `(60s)`;
    interval = startCountdown(timer);

    // AJAX request to resend OTP
    fetch("../../backend/routes/auth.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ action: "resend_otp" })
    })
    .then(res => res.json())
    .then(data => {
        showMessage(data.message, data.status === "success" ? "success" : "error");
    })
    .catch(() => showMessage("Failed to resend OTP. Try again.", "error"));
});

function startCountdown(duration) {
    return setInterval(() => {
        timer--;
        countdownEl.textContent = `(${timer}s)`;
        if (timer <= 0) {
            clearInterval(interval);
            resendBtn.disabled = false;
            countdownEl.textContent = '';
        }
    }, 1000);
}