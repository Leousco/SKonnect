/* profile_page.js — Portal Profile Page */

document.addEventListener('DOMContentLoaded', () => {

    /* =============================================
       AVATAR UPLOAD
    ============================================= */

    const avatarChangeBtn = document.getElementById('avatar-change-btn');
    const avatarFileInput = document.getElementById('avatar-file-input');
    const avatarImg       = document.getElementById('profile-avatar-img');
    const avatarInitials  = document.getElementById('profile-initials');

    avatarChangeBtn?.addEventListener('click', () => avatarFileInput?.click());

    avatarFileInput?.addEventListener('change', () => {
        const file = avatarFileInput.files[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) {
            showToast('Please upload a valid image file.', false);
            return;
        }
        const reader = new FileReader();
        reader.onload = e => {
            avatarImg.src = e.target.result;
            avatarImg.style.display = 'block';
            avatarInitials.style.display = 'none';
            showToast('Profile photo updated.');
        };
        reader.readAsDataURL(file);
        avatarFileInput.value = '';
    });

    /* =============================================
       INLINE EDIT SECTIONS (Personal + Contact)
    ============================================= */

    // Toggle edit mode on "Edit" button click
    document.querySelectorAll('.card-edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const target  = btn.dataset.target;
            const viewEl  = document.getElementById(`view-${target}`);
            const formEl  = document.getElementById(`form-${target}`);
            if (!viewEl || !formEl) return;

            const isEditing = formEl.style.display !== 'none';
            viewEl.style.display  = isEditing ? 'flex'  : 'none';
            formEl.style.display  = isEditing ? 'none'  : 'flex';
            btn.textContent       = isEditing ? '✏️ Edit' : '✕ Cancel';
        });
    });

    // Cancel buttons inside edit forms
    document.querySelectorAll('.cancel-edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.target;
            const viewEl = document.getElementById(`view-${target}`);
            const formEl = document.getElementById(`form-${target}`);
            const editBtn = document.querySelector(`.card-edit-btn[data-target="${target}"]`);
            if (viewEl) viewEl.style.display = 'flex';
            if (formEl) formEl.style.display = 'none';
            if (editBtn) editBtn.textContent = '✏️ Edit';
        });
    });

    // Save buttons
    document.querySelectorAll('.save-edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.target;
            if (!validateSection(target)) return;
            applySection(target);

            const viewEl  = document.getElementById(`view-${target}`);
            const formEl  = document.getElementById(`form-${target}`);
            const editBtn = document.querySelector(`.card-edit-btn[data-target="${target}"]`);
            if (viewEl) viewEl.style.display = 'flex';
            if (formEl) formEl.style.display = 'none';
            if (editBtn) editBtn.textContent = '✏️ Edit';
            showToast('Changes saved successfully.');
        });
    });

    /* ---- VALIDATE ---- */

    function clearSectionErrors(target) {
        document.querySelectorAll(`#form-${target} .field-error`).forEach(el => el.textContent = '');
        document.querySelectorAll(`#form-${target} .ann-search-input`).forEach(el => el.style.borderColor = '');
    }

    function showError(id, errId, msg) {
        const el  = document.getElementById(id);
        const err = document.getElementById(errId);
        if (el)  el.style.borderColor = '#e11d48';
        if (err) err.textContent = msg;
    }

    function validateSection(target) {
        clearSectionErrors(target);
        let valid = true;

        if (target === 'personal') {
            const fn = document.getElementById('e-firstname')?.value.trim();
            const ln = document.getElementById('e-lastname')?.value.trim();
            if (!fn) { showError('e-firstname', 'err-firstname', 'First name is required.'); valid = false; }
            if (!ln) { showError('e-lastname',  'err-lastname',  'Last name is required.');  valid = false; }
        }

        if (target === 'contact') {
            const email  = document.getElementById('e-email')?.value.trim();
            const mobile = document.getElementById('e-mobile')?.value.trim();
            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                showError('e-email', 'err-email', 'Enter a valid email address.');
                valid = false;
            }
            if (!mobile || !/^(09|\+639)\d{9}$/.test(mobile.replace(/\s/g, ''))) {
                showError('e-mobile', 'err-mobile', 'Enter a valid PH mobile number.');
                valid = false;
            }
        }

        return valid;
    }

    /* ---- APPLY EDITS TO VIEW ---- */

    function applySection(target) {
        if (target === 'personal') {
            const fn  = document.getElementById('e-firstname')?.value.trim()  || '';
            const mn  = document.getElementById('e-middlename')?.value.trim() || '';
            const ln  = document.getElementById('e-lastname')?.value.trim()   || '';
            const dob = document.getElementById('e-dob')?.value               || '';
            const sex = document.getElementById('e-sex')?.value               || '';
            const civ = document.getElementById('e-civil')?.value             || '';
            const rel = document.getElementById('e-religion')?.value.trim()   || '';

            const fullName = [fn, mn, ln].filter(Boolean).join(' ');

            // Update view fields
            document.getElementById('pf-fullname').textContent = fullName;
            document.getElementById('hero-fullname').textContent = fullName;

            if (dob) {
                const d = new Date(dob + 'T00:00:00');
                const formatted = d.toLocaleDateString('en-PH', { month: 'long', day: 'numeric', year: 'numeric' });
                document.getElementById('pf-dob').textContent = formatted;
                const age = Math.floor((new Date() - d) / (365.25 * 24 * 60 * 60 * 1000));
                document.getElementById('pf-age').textContent = `${age} years old`;
            }

            document.getElementById('pf-sex').textContent    = sex;
            document.getElementById('pf-civil').textContent  = civ;
            document.getElementById('pf-religion').textContent = rel;

            // Update initials
            const initials = ((fn[0] || '') + (ln[0] || '')).toUpperCase();
            document.getElementById('profile-initials').textContent = initials;
        }

        if (target === 'contact') {
            document.getElementById('pf-email').textContent  = document.getElementById('e-email')?.value.trim();
            document.getElementById('pf-mobile').textContent = document.getElementById('e-mobile')?.value.trim();
            document.getElementById('pf-purok').textContent  = document.getElementById('e-purok')?.value.trim();
            document.getElementById('pf-street').textContent = document.getElementById('e-street')?.value.trim();
        }
    }

    /* =============================================
       PROFILE EDIT TRIGGER (hero button)
       Scrolls to / opens Personal section
    ============================================= */

    document.getElementById('profile-edit-trigger')?.addEventListener('click', () => {
        const card = document.getElementById('card-personal');
        card?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        setTimeout(() => {
            document.querySelector('.card-edit-btn[data-target="personal"]')?.click();
        }, 400);
    });

    /* =============================================
       SETTINGS ACCORDIONS
    ============================================= */

    const settingToggles = [
        { toggle: 'toggle-password',   body: 'body-password' },
        { toggle: 'toggle-notif-pref', body: 'body-notif-pref' },
        { toggle: 'toggle-privacy',    body: 'body-privacy' },
        { toggle: 'toggle-danger',     body: 'body-danger' },
    ];

    settingToggles.forEach(({ toggle, body }) => {
        const toggleEl = document.getElementById(toggle);
        const bodyEl   = document.getElementById(body);
        if (!toggleEl || !bodyEl) return;

        const chevron = toggleEl.querySelector('.settings-chevron');

        toggleEl.addEventListener('click', () => {
            const isOpen = bodyEl.style.display !== 'none';
            bodyEl.style.display = isOpen ? 'none' : 'block';
            if (chevron) chevron.classList.toggle('open', !isOpen);
        });
    });

    /* =============================================
       PASSWORD CHANGE
    ============================================= */

    const newPassInput = document.getElementById('e-new-pass');
    const passStrength = document.getElementById('pass-strength');
    const strengthFill = document.getElementById('strength-fill');
    const strengthLabel = document.getElementById('strength-label');

    newPassInput?.addEventListener('input', () => {
        const val = newPassInput.value;
        if (!val) { passStrength.style.display = 'none'; return; }
        passStrength.style.display = 'flex';

        let score = 0;
        if (val.length >= 8)  score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const configs = [
            { pct: '25%',  color: '#ef4444', label: 'Weak' },
            { pct: '50%',  color: '#f97316', label: 'Fair' },
            { pct: '75%',  color: '#eab308', label: 'Good' },
            { pct: '100%', color: '#22c55e', label: 'Strong' },
        ];

        const cfg = configs[Math.max(0, score - 1)] || configs[0];
        strengthFill.style.width      = cfg.pct;
        strengthFill.style.background = cfg.color;
        strengthLabel.textContent     = cfg.label;
        strengthLabel.style.color     = cfg.color;
    });

    document.getElementById('save-password-btn')?.addEventListener('click', () => {
        let valid = true;

        const cur  = document.getElementById('e-cur-pass');
        const newp = document.getElementById('e-new-pass');
        const conf = document.getElementById('e-conf-pass');

        [cur, newp, conf].forEach(el => { if (el) el.style.borderColor = ''; });
        ['err-cur-pass','err-new-pass','err-conf-pass'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = '';
        });

        if (!cur?.value) {
            cur.style.borderColor = '#e11d48';
            document.getElementById('err-cur-pass').textContent = 'Current password is required.';
            valid = false;
        }
        if (!newp?.value || newp.value.length < 8) {
            newp.style.borderColor = '#e11d48';
            document.getElementById('err-new-pass').textContent = 'Password must be at least 8 characters.';
            valid = false;
        }
        if (!conf?.value || conf.value !== newp?.value) {
            conf.style.borderColor = '#e11d48';
            document.getElementById('err-conf-pass').textContent = 'Passwords do not match.';
            valid = false;
        }

        if (valid) {
            [cur, newp, conf].forEach(el => { if (el) el.value = ''; });
            if (passStrength) passStrength.style.display = 'none';
            showToast('Password updated successfully.');
        }
    });

    /* =============================================
       DEACTIVATE CONFIRM MODAL
    ============================================= */

    const confirmOverlay   = document.getElementById('confirm-overlay');
    const confirmClose     = document.getElementById('confirm-close');
    const confirmCancel    = document.getElementById('confirm-cancel');
    const confirmDeactivate = document.getElementById('confirm-deactivate');

    document.getElementById('deactivate-btn')?.addEventListener('click', () => {
        confirmOverlay.style.display  = 'flex';
        document.body.style.overflow  = 'hidden';
    });

    function closeConfirm() {
        confirmOverlay.style.display  = 'none';
        document.body.style.overflow  = '';
    }

    confirmClose?.addEventListener('click',  closeConfirm);
    confirmCancel?.addEventListener('click', closeConfirm);
    confirmOverlay?.addEventListener('click', e => { if (e.target === confirmOverlay) closeConfirm(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeConfirm(); });

    confirmDeactivate?.addEventListener('click', () => {
        closeConfirm();
        showToast('Your account has been deactivated. You will be logged out shortly.', false);
    });

    /* =============================================
       TOAST
    ============================================= */

    let toastTimer = null;

    function showToast(message, success = true) {
        const toast = document.getElementById('profile-toast');
        const icon  = document.getElementById('toast-icon');
        const text  = document.getElementById('toast-text');

        if (!toast || !icon || !text) return;

        icon.textContent  = success ? '✅' : '⚠️';
        text.textContent  = message;
        toast.style.background = success ? 'var(--navy)' : '#b91c1c';
        toast.style.display   = 'flex';

        if (toastTimer) clearTimeout(toastTimer);
        toastTimer = setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s';
            setTimeout(() => {
                toast.style.display  = 'none';
                toast.style.opacity  = '1';
                toast.style.transition = '';
            }, 300);
        }, 3200);
    }
});