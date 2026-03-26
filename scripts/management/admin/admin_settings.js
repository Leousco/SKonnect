/**
 * admin_settings.js
 * SKonnect Admin — Settings Module Interactivity
 */

document.addEventListener('DOMContentLoaded', function () {

    // ── TAB NAVIGATION ───────────────────────────────────────
    const navItems  = document.querySelectorAll('.snav-item');
    const panels    = document.querySelectorAll('.settings-panel');

    navItems.forEach(btn => {
        btn.addEventListener('click', function () {
            const target = this.dataset.tab;

            navItems.forEach(n => n.classList.remove('active'));
            this.classList.add('active');

            panels.forEach(p => {
                p.classList.remove('active');
                if (p.id === 'tab-' + target) p.classList.add('active');
            });
        });
    });

    // ── FORM SUBMIT (demo — swap for real fetch/ajax) ────────
    document.querySelectorAll('.settings-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!validateForm(this)) return;
            showToast('Settings saved successfully.');
        });
    });

    // ── LOGO / FILE UPLOAD PREVIEW ───────────────────────────
    const logoInput   = document.getElementById('logo-file-input');
    const logoImg     = document.getElementById('logo-img-preview');
    const logoPH      = document.getElementById('logo-placeholder');
    const logoRemove  = document.getElementById('btn-logo-remove');
    const logoDropZone = document.getElementById('logo-drop-zone');

    if (logoInput) {
        logoInput.addEventListener('change', function () {
            previewImage(this.files[0], logoImg, logoPH, logoRemove);
        });

        // Drag & Drop
        ['dragenter','dragover'].forEach(evt => {
            logoDropZone.addEventListener(evt, e => {
                e.preventDefault();
                logoDropZone.classList.add('drag-over');
            });
        });
        ['dragleave','drop'].forEach(evt => {
            logoDropZone.addEventListener(evt, e => {
                e.preventDefault();
                logoDropZone.classList.remove('drag-over');
                if (evt === 'drop' && e.dataTransfer.files.length) {
                    previewImage(e.dataTransfer.files[0], logoImg, logoPH, logoRemove);
                }
            });
        });
    }

    if (logoRemove) {
        logoRemove.addEventListener('click', function () {
            logoImg.src = '';
            logoImg.style.display = 'none';
            logoPH.style.display = '';
            logoRemove.style.display = 'none';
            if (logoInput) logoInput.value = '';
        });
    }

    // Favicon preview
    const faviconInput   = document.getElementById('favicon-file-input');
    const faviconPreview = document.getElementById('favicon-preview');

    if (faviconInput && faviconPreview) {
        faviconInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                faviconPreview.innerHTML = `<img src="${e.target.result}" alt="Favicon preview"
                    style="width:100%; height:100%; object-fit:contain; border-radius:4px;">`;
            };
            reader.readAsDataURL(file);
        });
    }

    // Avatar preview
    const avatarInput  = document.getElementById('avatar-file-input');
    const avatarImg    = document.getElementById('avatar-img');
    const avatarInit   = document.getElementById('avatar-initials');
    const avatarRemove = document.getElementById('btn-avatar-remove');

    if (avatarInput) {
        avatarInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                avatarImg.src = e.target.result;
                avatarImg.style.display = 'block';
                if (avatarInit) avatarInit.style.display = 'none';
                if (avatarRemove) avatarRemove.style.display = 'inline';
            };
            reader.readAsDataURL(file);
        });
    }

    if (avatarRemove) {
        avatarRemove.addEventListener('click', function () {
            avatarImg.src = '';
            avatarImg.style.display = 'none';
            if (avatarInit) avatarInit.style.display = '';
            avatarRemove.style.display = 'none';
            if (avatarInput) avatarInput.value = '';
        });
    }

    // ── PASSWORD VISIBILITY TOGGLE ───────────────────────────
    document.querySelectorAll('.pw-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            const input  = document.getElementById(this.dataset.target);
            const eyeOpen   = this.querySelector('.eye-open');
            const eyeClosed = this.querySelector('.eye-closed');
            if (!input) return;
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            eyeOpen.style.display   = isText ? '' : 'none';
            eyeClosed.style.display = isText ? 'none' : '';
        });
    });

    // ── PASSWORD STRENGTH ────────────────────────────────────
    const pwNew         = document.getElementById('pw-new');
    const pwConfirm     = document.getElementById('pw-confirm');
    const strengthWrap  = document.getElementById('pw-strength-wrap');
    const strengthFill  = document.getElementById('pw-strength-fill');
    const strengthLabel = document.getElementById('pw-strength-label');
    const matchMsg      = document.getElementById('pw-match-msg');

    const checks = {
        len:    { el: document.getElementById('chk-len'),    test: v => v.length >= 8 },
        upper:  { el: document.getElementById('chk-upper'),  test: v => /[A-Z]/.test(v) },
        number: { el: document.getElementById('chk-number'), test: v => /\d/.test(v) },
        symbol: { el: document.getElementById('chk-symbol'), test: v => /[!@#$%^&*(),.?":{}|<>_\-+=~`[\]\\;'/]/.test(v) },
    };

    const strengthLevels = ['Weak', 'Fair', 'Moderate', 'Strong', 'Very Strong'];

    if (pwNew) {
        pwNew.addEventListener('input', function () {
            const val = this.value;
            if (!strengthWrap) return;

            if (!val) {
                strengthWrap.style.display = 'none';
                Object.values(checks).forEach(c => c.el && c.el.classList.remove('passed'));
                return;
            }

            strengthWrap.style.display = 'flex';

            let score = 0;
            Object.values(checks).forEach(c => {
                const pass = c.test(val);
                if (c.el) c.el.classList.toggle('passed', pass);
                if (pass) score++;
            });

            strengthFill.className = `pw-strength-fill strength-${score}`;
            strengthLabel.textContent = strengthLevels[score] ?? 'Very Strong';
            strengthLabel.style.color = ['#ef4444','#f97316','#eab308','#22c55e','#16a34a'][score] ?? '#16a34a';

            // Re-check match if confirm has value
            if (pwConfirm && pwConfirm.value) updateMatchMsg();
        });
    }

    if (pwConfirm) {
        pwConfirm.addEventListener('input', updateMatchMsg);
    }

    function updateMatchMsg() {
        if (!pwNew || !pwConfirm || !matchMsg) return;
        const matches = pwNew.value === pwConfirm.value;
        matchMsg.style.display = pwConfirm.value ? 'block' : 'none';
        matchMsg.textContent   = matches ? '✓ Passwords match' : '✗ Passwords do not match';
        matchMsg.className     = 'pw-match-msg ' + (matches ? 'match' : 'no-match');
    }

    // ── BASIC VALIDATION ─────────────────────────────────────
    function validateForm(form) {
        let valid = true;
        form.querySelectorAll('[required]').forEach(input => {
            input.classList.remove('is-error');
            if (!input.value.trim()) {
                input.classList.add('is-error');
                valid = false;
            }
        });

        // Password-specific
        if (form.id === 'form-password') {
            const nw  = form.querySelector('#pw-new');
            const cf  = form.querySelector('#pw-confirm');
            if (nw && cf && nw.value !== cf.value) {
                cf.classList.add('is-error');
                valid = false;
            }
        }

        return valid;
    }

    // ── RESET HELPER ─────────────────────────────────────────
    window.resetForm = function (formId) {
        const form = document.getElementById(formId);
        if (form) {
            form.reset();
            form.querySelectorAll('.is-error').forEach(el => el.classList.remove('is-error'));
            // reset strength bar if password form
            if (formId === 'form-password') {
                if (strengthWrap) strengthWrap.style.display = 'none';
                if (matchMsg)     matchMsg.style.display = 'none';
                Object.values(checks).forEach(c => c.el && c.el.classList.remove('passed'));
            }
        }
    };

    // ── TOAST ─────────────────────────────────────────────────
    function showToast(msg) {
        const toast   = document.getElementById('settings-toast');
        const toastMsg = document.getElementById('toast-msg');
        if (!toast) return;
        if (toastMsg) toastMsg.textContent = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3200);
    }

});