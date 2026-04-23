/**
 * admin_settings.js
 * SKonnect Admin — Settings Module — connected to DB
 */

document.addEventListener('DOMContentLoaded', function () {

    const SETTINGS_URL = '../../../backend/routes/settings_action.php';

    /* ══════════════════════════════════════════════════════════
       TAB NAVIGATION
       ══════════════════════════════════════════════════════════ */
    const navItems = document.querySelectorAll('.snav-item');
    const panels   = document.querySelectorAll('.settings-panel');

    navItems.forEach(btn => {
        btn.addEventListener('click', function () {
            navItems.forEach(n => n.classList.remove('active'));
            this.classList.add('active');
            panels.forEach(p => {
                p.classList.remove('active');
                if (p.id === 'tab-' + this.dataset.tab) p.classList.add('active');
            });
        });
    });

    /* ══════════════════════════════════════════════════════════
       LOAD ADMIN PROFILE FROM DB
       ══════════════════════════════════════════════════════════ */
    fetch(`${SETTINGS_URL}?action=load`)
        .then(r => r.json())
        .then(json => {
            if (json.status !== 'success') return;
            const u = json.data;

            const fnEl    = document.getElementById('admin-fname');
            const lnEl    = document.getElementById('admin-lname');
            const emailEl = document.getElementById('admin-email');

            if (fnEl)    fnEl.value    = u.first_name  ?? '';
            if (lnEl)    lnEl.value    = u.last_name   ?? '';
            if (emailEl) emailEl.value = u.email       ?? '';

            const initials = ((u.first_name?.[0] ?? '') + (u.last_name?.[0] ?? '')).toUpperCase();
            const initEl   = document.getElementById('avatar-initials');
            if (initEl) initEl.textContent = initials;
        })
        .catch(err => console.error('Failed to load profile:', err));

    /* ══════════════════════════════════════════════════════════
       LOAD SYSTEM / SITE SETTINGS FROM DB
       ══════════════════════════════════════════════════════════ */
    fetch(`${SETTINGS_URL}?action=load-settings`)
        .then(r => r.json())
        .then(json => {
            if (json.status !== 'success') return;
            const s = json.data;

            // System info
            setVal('sys-name',    s.sys_name);
            setVal('sys-email',   s.sys_email);
            setVal('sys-tagline', s.sys_tagline);

            // Barangay info
            setVal('brgy-name',         s.brgy_name);
            setVal('brgy-municipality',  s.brgy_municipality);
            setVal('brgy-province',      s.brgy_province);
            setVal('brgy-contact',       s.brgy_contact);
            setVal('brgy-email',         s.brgy_email);
            setVal('brgy-address',       s.brgy_address);
            setVal('brgy-about',         s.brgy_about);
        })
        .catch(err => console.error('Failed to load settings:', err));

    /* Helper: safely set input/textarea value */
    function setVal(id, value) {
        const el = document.getElementById(id);
        if (el) el.value = value ?? '';
    }

    /* ══════════════════════════════════════════════════════════
       FORM SUBMISSIONS
       ══════════════════════════════════════════════════════════ */

    /* ── Admin profile save ─────────────────────────── */
    document.getElementById('form-admin-info')?.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!validateForm(this)) return;

        const payload = {
            action:     'save-profile',
            first_name: document.getElementById('admin-fname')?.value.trim(),
            last_name:  document.getElementById('admin-lname')?.value.trim(),
            email:      document.getElementById('admin-email')?.value.trim(),
        };

        const btn = this.querySelector('[type="submit"]');
        setLoading(btn, true, 'Saving…');

        fetch(SETTINGS_URL, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify(payload),
        })
        .then(r => r.json())
        .then(json => {
            if (json.status === 'success') {
                showToast(json.message || 'Profile updated successfully.', 'success');
                const nameEl = document.querySelector('.admin-user-name');
                if (nameEl) nameEl.textContent = `${payload.first_name} ${payload.last_name}`;
                const initials = (payload.first_name[0] + payload.last_name[0]).toUpperCase();
                document.querySelectorAll('.admin-user-initials').forEach(el => el.textContent = initials);
                const avatarInit = document.getElementById('avatar-initials');
                if (avatarInit) avatarInit.textContent = initials;
            } else {
                showToast(json.message || 'Failed to save.', 'error');
            }
        })
        .catch(() => showToast('Network error. Please try again.', 'error'))
        .finally(() => setLoading(btn, false, 'Save Changes'));
    });

    /* ── Password change ────────────────────────────── */
    document.getElementById('form-password')?.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!validateForm(this)) return;

        const newPw  = document.getElementById('pw-new')?.value ?? '';
        const confPw = document.getElementById('pw-confirm')?.value ?? '';

        if (newPw !== confPw) {
            showToast('New passwords do not match.', 'error');
            document.getElementById('pw-confirm')?.classList.add('is-error');
            return;
        }

        const payload = {
            action:           'change-password',
            current_password: document.getElementById('pw-current')?.value ?? '',
            new_password:     newPw,
            confirm_password: confPw,
        };

        const btn = this.querySelector('[type="submit"]');
        setLoading(btn, true, 'Updating…');

        fetch(SETTINGS_URL, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify(payload),
        })
        .then(r => r.json())
        .then(json => {
            if (json.status === 'success') {
                showToast(json.message || 'Password changed successfully.', 'success');
                this.reset();
                if (strengthWrap) strengthWrap.style.display = 'none';
                if (matchMsg)     matchMsg.style.display     = 'none';
                Object.values(checks).forEach(c => c.el?.classList.remove('passed'));
            } else {
                showToast(json.message || 'Failed to change password.', 'error');
            }
        })
        .catch(() => showToast('Network error. Please try again.', 'error'))
        .finally(() => setLoading(btn, false, 'Update Password'));
    });

    /* ── System information save ────────────────────── */
    document.getElementById('form-system-info')?.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!validateForm(this)) return;

        const payload = {
            action:      'save-system-info',
            sys_name:    document.getElementById('sys-name')?.value.trim(),
            sys_email:   document.getElementById('sys-email')?.value.trim(),
            sys_tagline: document.getElementById('sys-tagline')?.value.trim(),
        };

        const btn = this.querySelector('[type="submit"]');
        setLoading(btn, true, 'Saving…');

        fetch(SETTINGS_URL, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify(payload),
        })
        .then(r => r.json())
        .then(json => showToast(json.message || 'Saved.', json.status === 'success' ? 'success' : 'error'))
        .catch(() => showToast('Network error. Please try again.', 'error'))
        .finally(() => setLoading(btn, false, 'Save Changes'));
    });

    /* ── Branding save ──────────────────────────────── */
    document.getElementById('form-branding')?.addEventListener('submit', function (e) {
        e.preventDefault();

        // NOTE: If you add actual file upload later, handle FormData here.
        // For now, we save the paths already stored in the DB (no-op if no file chosen).
        const payload = {
            action:       'save-branding',
            logo_path:    '',   // replace with actual upload path when implemented
            favicon_path: '',
        };

        const btn = this.querySelector('[type="submit"]');
        setLoading(btn, true, 'Saving…');

        fetch(SETTINGS_URL, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify(payload),
        })
        .then(r => r.json())
        .then(json => showToast(json.message || 'Saved.', json.status === 'success' ? 'success' : 'error'))
        .catch(() => showToast('Network error. Please try again.', 'error'))
        .finally(() => setLoading(btn, false, 'Save Changes'));
    });

    /* ── Barangay info save ─────────────────────────── */
    document.getElementById('form-barangay')?.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!validateForm(this)) return;

        const payload = {
            action:            'save-barangay',
            brgy_name:         document.getElementById('brgy-name')?.value.trim(),
            brgy_municipality:  document.getElementById('brgy-municipality')?.value.trim(),
            brgy_province:     document.getElementById('brgy-province')?.value.trim(),
            brgy_contact:      document.getElementById('brgy-contact')?.value.trim(),
            brgy_email:        document.getElementById('brgy-email')?.value.trim(),
            brgy_address:      document.getElementById('brgy-address')?.value.trim(),
            brgy_about:        document.getElementById('brgy-about')?.value.trim(),
        };

        const btn = this.querySelector('[type="submit"]');
        setLoading(btn, true, 'Saving…');

        fetch(SETTINGS_URL, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify(payload),
        })
        .then(r => r.json())
        .then(json => showToast(json.message || 'Saved.', json.status === 'success' ? 'success' : 'error'))
        .catch(() => showToast('Network error. Please try again.', 'error'))
        .finally(() => setLoading(btn, false, 'Save Changes'));
    });

    /* ══════════════════════════════════════════════════════════
       LOGO / FILE UPLOAD PREVIEW
       ══════════════════════════════════════════════════════════ */
    const logoInput    = document.getElementById('logo-file-input');
    const logoImg      = document.getElementById('logo-img-preview');
    const logoPH       = document.getElementById('logo-placeholder');
    const logoRemove   = document.getElementById('btn-logo-remove');
    const logoDropZone = document.getElementById('logo-drop-zone');

    if (logoInput) {
        logoInput.addEventListener('change', function () {
            previewImage(this.files[0], logoImg, logoPH, logoRemove);
        });
        ['dragenter', 'dragover'].forEach(evt => {
            logoDropZone?.addEventListener(evt, e => {
                e.preventDefault();
                logoDropZone.classList.add('drag-over');
            });
        });
        ['dragleave', 'drop'].forEach(evt => {
            logoDropZone?.addEventListener(evt, e => {
                e.preventDefault();
                logoDropZone.classList.remove('drag-over');
                if (evt === 'drop' && e.dataTransfer.files.length) {
                    previewImage(e.dataTransfer.files[0], logoImg, logoPH, logoRemove);
                }
            });
        });
    }

    logoRemove?.addEventListener('click', function () {
        logoImg.src = '';
        logoImg.style.display = 'none';
        logoPH.style.display = '';
        logoRemove.style.display = 'none';
        if (logoInput) logoInput.value = '';
    });

    /* ── Favicon preview ────────────────────────────── */
    const faviconInput   = document.getElementById('favicon-file-input');
    const faviconPreview = document.getElementById('favicon-preview');
    faviconInput?.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            faviconPreview.innerHTML = `<img src="${e.target.result}" alt="Favicon"
                style="width:100%;height:100%;object-fit:contain;border-radius:4px;">`;
        };
        reader.readAsDataURL(file);
    });

    /* ── Avatar preview ─────────────────────────────── */
    const avatarInput  = document.getElementById('avatar-file-input');
    const avatarImg    = document.getElementById('avatar-img');
    const avatarInit   = document.getElementById('avatar-initials');
    const avatarRemove = document.getElementById('btn-avatar-remove');

    avatarInput?.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            avatarImg.src = e.target.result;
            avatarImg.style.display = 'block';
            if (avatarInit)   avatarInit.style.display   = 'none';
            if (avatarRemove) avatarRemove.style.display = 'inline';
        };
        reader.readAsDataURL(file);
    });

    avatarRemove?.addEventListener('click', function () {
        avatarImg.src = '';
        avatarImg.style.display = 'none';
        if (avatarInit)   avatarInit.style.display = '';
        avatarRemove.style.display = 'none';
        if (avatarInput) avatarInput.value = '';
    });

    /* ══════════════════════════════════════════════════════════
       PASSWORD VISIBILITY TOGGLE
       ══════════════════════════════════════════════════════════ */
    document.querySelectorAll('.pw-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            const input     = document.getElementById(this.dataset.target);
            const eyeOpen   = this.querySelector('.eye-open');
            const eyeClosed = this.querySelector('.eye-closed');
            if (!input) return;
            const isText = input.type === 'text';
            input.type = isText ? 'password' : 'text';
            if (eyeOpen)   eyeOpen.style.display  = isText ? '' : 'none';
            if (eyeClosed) eyeClosed.style.display = isText ? 'none' : '';
        });
    });

    /* ══════════════════════════════════════════════════════════
       PASSWORD STRENGTH
       ══════════════════════════════════════════════════════════ */
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

    pwNew?.addEventListener('input', function () {
        const val = this.value;
        if (!strengthWrap) return;
        if (!val) {
            strengthWrap.style.display = 'none';
            Object.values(checks).forEach(c => c.el?.classList.remove('passed'));
            return;
        }
        strengthWrap.style.display = 'flex';
        let score = 0;
        Object.values(checks).forEach(c => {
            const pass = c.test(val);
            c.el?.classList.toggle('passed', pass);
            if (pass) score++;
        });
        if (strengthFill) strengthFill.className = `pw-strength-fill strength-${score}`;
        if (strengthLabel) {
            strengthLabel.textContent = strengthLevels[score] ?? 'Very Strong';
            strengthLabel.style.color = ['#ef4444', '#f97316', '#eab308', '#22c55e', '#16a34a'][score] ?? '#16a34a';
        }
        if (pwConfirm?.value) updateMatchMsg();
    });

    pwConfirm?.addEventListener('input', updateMatchMsg);

    function updateMatchMsg() {
        if (!pwNew || !pwConfirm || !matchMsg) return;
        const matches = pwNew.value === pwConfirm.value;
        matchMsg.style.display = pwConfirm.value ? 'block' : 'none';
        matchMsg.textContent   = matches ? '✓ Passwords match' : '✗ Passwords do not match';
        matchMsg.className     = 'pw-match-msg ' + (matches ? 'match' : 'no-match');
    }

    /* ══════════════════════════════════════════════════════════
       HELPERS
       ══════════════════════════════════════════════════════════ */
    function previewImage(file, imgEl, placeholderEl, removeBtn) {
        if (!file || !file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = e => {
            if (imgEl)         { imgEl.src = e.target.result; imgEl.style.display = 'block'; }
            if (placeholderEl)   placeholderEl.style.display = 'none';
            if (removeBtn)       removeBtn.style.display = 'inline';
        };
        reader.readAsDataURL(file);
    }

    function validateForm(form) {
        let valid = true;
        form.querySelectorAll('[required]').forEach(input => {
            input.classList.remove('is-error');
            if (!input.value.trim()) { input.classList.add('is-error'); valid = false; }
        });
        if (form.id === 'form-password') {
            const nw = form.querySelector('#pw-new');
            const cf = form.querySelector('#pw-confirm');
            if (nw && cf && nw.value !== cf.value) { cf.classList.add('is-error'); valid = false; }
        }
        return valid;
    }

    function setLoading(btn, loading, label) {
        if (!btn) return;
        btn.disabled    = loading;
        btn.textContent = label;
    }

    function showToast(msg, type = 'success') {
        const toast     = document.getElementById('settings-toast');
        const toastMsg  = document.getElementById('toast-msg');
        const toastIcon = toast?.querySelector('.toast-icon');

        if (!toast) return;
        if (toastMsg) toastMsg.textContent = msg;

        const colors = { success: '#059669', error: '#dc2626', info: '#5b21b6' };
        if (toastIcon) toastIcon.style.background = colors[type] || colors.success;

        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3500);
    }

    // Expose for inline onclick
    window.resetForm = function (formId) {
        const form = document.getElementById(formId);
        if (!form) return;
        form.reset();
        form.querySelectorAll('.is-error').forEach(el => el.classList.remove('is-error'));
        if (formId === 'form-password') {
            if (strengthWrap) strengthWrap.style.display = 'none';
            if (matchMsg)     matchMsg.style.display     = 'none';
            Object.values(checks).forEach(c => c.el?.classList.remove('passed'));
        }
    };
});