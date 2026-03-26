/* admin_manage_users.js */

document.addEventListener('DOMContentLoaded', () => {

    /* ---- FILTER ---- */
    const searchInput   = document.getElementById('user-search');
    const roleSelect    = document.getElementById('user-role');
    const genderSelect  = document.getElementById('user-gender');
    const verifiedSelect= document.getElementById('user-verified');
    const rows          = Array.from(document.querySelectorAll('.user-row'));
    const noResults     = document.getElementById('no-results');

    function filterRows() {
        const query    = searchInput.value.toLowerCase().trim();
        const role     = roleSelect.value;
        const gender   = genderSelect.value;
        const verified = verifiedSelect.value;
        let visible    = 0;

        rows.forEach(row => {
            const name     = row.dataset.name     || '';
            const email    = row.dataset.email    || '';
            const rowRole  = row.dataset.role     || '';
            const rowGend  = row.dataset.gender   || '';
            const rowVerif = row.dataset.verified || '';

            const matchSearch   = !query    || name.includes(query)  || email.includes(query);
            const matchRole     = role     === 'all' || rowRole  === role;
            const matchGender   = gender   === 'all' || rowGend  === gender;
            const matchVerified = verified === 'all' || rowVerif === verified;

            const show = matchSearch && matchRole && matchGender && matchVerified;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        noResults.style.display = visible === 0 ? 'block' : 'none';
    }

    searchInput?.addEventListener('input',     filterRows);
    roleSelect?.addEventListener('change',     filterRows);
    genderSelect?.addEventListener('change',   filterRows);
    verifiedSelect?.addEventListener('change', filterRows);

    /* ---- MODAL ---- */
    const overlay = document.getElementById('user-modal-overlay');
    let currentUser = null;

    const roleAvatarColors = {
        admin:      '#5b21b6',
        moderator:  '#0891b2',
        sk_officer: '#d97706',
        resident:   '#059669',
    };

    const roleLabels = {
        admin:      '🛡️ Admin',
        moderator:  '🔧 Moderator',
        sk_officer: '⭐ SK Officer',
        resident:   '👤 Resident',
    };

    function openUserModal(user) {
        currentUser = user;

        const avatar = document.getElementById('user-modal-avatar');
        avatar.textContent        = user.initials;
        avatar.style.background   = roleAvatarColors[user.role] || '#5b21b6';

        document.getElementById('user-modal-name').textContent    = user.fullName;
        document.getElementById('user-modal-email').textContent   = user.email;
        document.getElementById('user-modal-role').textContent    = roleLabels[user.role] || user.role;
        document.getElementById('user-modal-gender').textContent  = user.gender.charAt(0).toUpperCase() + user.gender.slice(1);
        document.getElementById('user-modal-status').textContent  = user.is_verified == 1 ? '✅ Verified' : '❌ Unverified';
        document.getElementById('user-modal-age').textContent     = user.age + ' years old';
        document.getElementById('user-modal-joined').textContent  = user.created_at;
        document.getElementById('user-modal-id').textContent      = 'ID: ' + user.id;
        document.getElementById('user-modal-role-select').value   = user.role;

        const toggleBtn = document.getElementById('user-modal-toggle');
        if (user.is_verified == 1) {
            toggleBtn.textContent = '🚫 Deactivate';
            toggleBtn.className   = 'btn-svc-primary';
            toggleBtn.style.background = '#d97706';
        } else {
            toggleBtn.textContent = '✅ Activate';
            toggleBtn.className   = 'btn-svc-primary btn-svc-approve';
            toggleBtn.style.background = '';
        }

        overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeUserModal() {
        overlay.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    overlay?.addEventListener('click', e => { if (e.target === overlay) closeUserModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeUserModal(); });

    /* ---- ACTIONS ---- */
    function saveUserRole() {
        const newRole = document.getElementById('user-modal-role-select').value;
        // TODO: connect to backend
        showToast(`💾 Role updated to "${roleLabels[newRole]}" for ${currentUser?.fullName}! (placeholder)`, 'success');
        closeUserModal();
    }

    function toggleUser(id, name) {
        if (confirm(`Toggle account status for "${name}"?`)) {
            // TODO: connect to backend
            showToast(`Account status updated for ${name}! (placeholder)`, 'info');
        }
    }

    function toggleFromModal() {
        if (!currentUser) return;
        const action = currentUser.is_verified == 1 ? 'deactivate' : 'activate';
        if (confirm(`${action.charAt(0).toUpperCase() + action.slice(1)} account of "${currentUser.fullName}"?`)) {
            // TODO: connect to backend
            showToast(`Account ${action}d for ${currentUser.fullName}! (placeholder)`, 'info');
            closeUserModal();
        }
    }

    function deleteUser(id, name) {
        if (confirm(`Delete user "${name}"? This cannot be undone.`)) {
            // TODO: connect to backend
            showToast(`🗑️ User "${name}" deleted! (placeholder)`, 'error');
        }
    }

    function deleteFromModal() {
        if (!currentUser) return;
        deleteUser(currentUser.id, currentUser.fullName);
        closeUserModal();
    }

    /* ---- TOAST ---- */
    function showToast(msg, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `svc-toast toast-${type}`;
        toast.textContent = msg;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3500);
    }

    // Expose to global
    window.openUserModal    = openUserModal;
    window.closeUserModal   = closeUserModal;
    window.saveUserRole     = saveUserRole;
    window.toggleUser       = toggleUser;
    window.toggleFromModal  = toggleFromModal;
    window.deleteUser       = deleteUser;
    window.deleteFromModal  = deleteFromModal;
});