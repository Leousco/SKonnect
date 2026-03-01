    // OTP input auto-advance & backspace
    const inputs = document.querySelectorAll('.otp-input');
    const otpValue = document.getElementById('otpValue');

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

    // Countdown timer
    let timer = 30;
    const countdownEl = document.getElementById('countdown');
    const resendBtn = document.getElementById('resendBtn');

    const interval = setInterval(() => {
        timer--;
        countdownEl.textContent = `(${timer}s)`;
        if (timer <= 0) {
            clearInterval(interval);
            resendBtn.disabled = false;
            countdownEl.textContent = '';
        }
    }, 1000);

    resendBtn.addEventListener('click', () => {
        if (!resendBtn.disabled) {
            // Trigger resend logic here
            resendBtn.disabled = true;
            timer = 60;
            countdownEl.textContent = `(60s)`;
            const newInterval = setInterval(() => {
                timer--;
                countdownEl.textContent = `(${timer}s)`;
                if (timer <= 0) {
                    clearInterval(newInterval);
                    resendBtn.disabled = false;
                    countdownEl.textContent = '';
                }
            }, 1000);
        }
    });