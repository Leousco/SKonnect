/* =============================================================
   admin_manage_users.js
   Place in: scripts/management/admin/admin_manage_users.js
   Talks to: backend/controllers/UserController.php
============================================================= */

document.addEventListener('DOMContentLoaded', () => {

    /* ----------------------------------------------------------
       CONFIG — single endpoint, action-based
    ---------------------------------------------------------- */
    const API_URL = '../../../backend/controllers/UserController.php';

    const roleLabels = {
        admin:      '🛡️ Admin',
        moderator:  '🔧 Moderator',
        sk_officer: '⭐ SK Officer',
        resident:   '👤 Resident',
    };

    const roleColorClass = {
        admin:      'role-admin',
        moderator:  'role-moderator',
        sk_officer: 'role-officer',
        resident:   'role-resident',
    };

    const avatarColors = {
        admin:      '#5b21b6',
        moderator:  '#0891b2',
        sk_officer: '#d97706',
        resident:   '#059669',
    };

    let allUsers    = [];
    let currentUser = null;

    /* ----------------------------------------------------------
       LOAD USERS
    ---------------------------------------------------------- */
    async function loadUsers() {
        try {
            const res  = await fetch(API_URL + '?action=get_users');
            const data = await res.json();
            if (data.status !== 'success') throw new Error(data.message);
            // ✅ FIX: was data.users — PHP returns data.data.users
            allUsers = data.data.users;
            renderTable(allUsers);
            updateStats(allUsers);
        } catch (err) {
            showToast('Failed to load users: ' + err.message, 'error');
        }
    }

    /* ----------------------------------------------------------
       RENDER TABLE
    ---------------------------------------------------------- */
    function renderTable(users) {
        const tbody = document.getElementById('user-tbody');
        tbody.innerHTML = '';

        const noResults = document.getElementById('no-results');
        if (users.length === 0) { noResults.style.display = 'block'; return; }
        noResults.style.display = 'none';

        users.forEach(user => {
            const initials = (user.first_name[0] + user.last_name[0]).toUpperCase();
            const fullName = [user.first_name, user.middle_name, user.last_name].filter(Boolean).join(' ');
            const joined   = new Date(user.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });

            const tr = document.createElement('tr');
            tr.className        = 'user-row';
            tr.dataset.role     = user.role;
            tr.dataset.gender   = user.gender;
            tr.dataset.verified = user.is_verified;
            tr.dataset.name     = fullName.toLowerCase();
            tr.dataset.email    = user.email.toLowerCase();

            tr.innerHTML = `
                <td>
                    <div class="user-name-cell">
                        <div class="user-avatar role-avatar-${user.role}">${initials}</div>
                        <div>
                            <div class="user-fullname">${esc(fullName)}</div>
                            <div class="user-id">ID: ${user.id}</div>
                        </div>
                    </div>
                </td>
                <td class="user-email">${esc(user.email)}</td>
                <td><span class="user-role-badge ${roleColorClass[user.role] || ''}">${roleLabels[user.role] || user.role}</span></td>
                <td>${cap(user.gender)}</td>
                <td>${user.age}</td>
                <td>${statusBadge(user)}</td>
                <td class="user-date">${joined}</td>
                <td>
                    <div class="user-actions">
                        <button class="btn-user-action btn-view" data-id="${user.id}">👁️ View</button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });

        tbody.querySelectorAll('.btn-view').forEach(b => b.addEventListener('click', () => openViewModal(getUser(b.dataset.id))));
    }

    function statusBadge(user) {
        if (user.is_banned)   return '<span class="user-verified-badge verified-no">⛔ Banned</span>';
        if (!user.is_active)  return '<span class="user-verified-badge verified-no">🚫 Inactive</span>';
        if (user.is_verified) return '<span class="user-verified-badge verified-yes">✅ Verified</span>';
        return '<span class="user-verified-badge verified-no">❌ Unverified</span>';
    }

    function updateStats(users) {
        const counts = {
            total:      users.length,
            verified:   users.filter(u => u.is_verified == 1).length,
            admin:      users.filter(u => u.role === 'admin').length,
            moderator:  users.filter(u => u.role === 'moderator').length,
            sk_officer: users.filter(u => u.role === 'sk_officer').length,
            resident:   users.filter(u => u.role === 'resident').length,
        };
        document.querySelectorAll('[data-stat]').forEach(el => {
            el.textContent = counts[el.dataset.stat] ?? 0;
        });
    }

    function getUser(id) { return allUsers.find(u => String(u.id) === String(id)); }

    /* ----------------------------------------------------------
       FILTER
    ---------------------------------------------------------- */
    document.getElementById('user-search')  ?.addEventListener('input',  filter);
    document.getElementById('user-role')    ?.addEventListener('change', filter);
    document.getElementById('user-gender')  ?.addEventListener('change', filter);
    document.getElementById('user-verified')?.addEventListener('change', filter);

    function filter() {
        const query    = document.getElementById('user-search').value.toLowerCase().trim();
        const role     = document.getElementById('user-role').value;
        const gender   = document.getElementById('user-gender').value;
        const verified = document.getElementById('user-verified').value;

        const filtered = allUsers.filter(u => {
            const name = [u.first_name, u.middle_name, u.last_name].filter(Boolean).join(' ').toLowerCase();
            return (!query    || name.includes(query) || u.email.toLowerCase().includes(query))
                && (role     === 'all' || u.role === role)
                && (gender   === 'all' || u.gender === gender)
                && (verified === 'all' || String(u.is_verified) === verified);
        });

        renderTable(filtered);
        document.getElementById('no-results').style.display = filtered.length === 0 ? 'block' : 'none';
    }

    /* ----------------------------------------------------------
       ADD USER MODAL
    ---------------------------------------------------------- */
    const addOverlay = document.getElementById('add-user-modal-overlay');

    document.getElementById('btn-add-user') ?.addEventListener('click', () => {
        document.getElementById('add-user-form').reset();
        addOverlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    });
    document.getElementById('add-user-close')?.addEventListener('click', closeAddModal);
    addOverlay?.addEventListener('click', e => { if (e.target === addOverlay) closeAddModal(); });

    function closeAddModal() {
        addOverlay.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    document.getElementById('add-user-submit')?.addEventListener('click', async () => {
        const fields = ['add-first-name','add-last-name','add-email','add-password','add-role','add-gender','add-birth-date'];
        const vals   = {};
        let valid    = true;

        fields.forEach(id => {
            const el = document.getElementById(id);
            if (!el.value.trim()) { el.classList.add('input-error'); valid = false; }
            else { el.classList.remove('input-error'); vals[id] = el.value.trim(); }
        });

        if (!valid) { showToast('Please fill in all required fields.', 'error'); return; }

        try {
            const res = await apiFetch({
                action:      'add_user',
                first_name:  vals['add-first-name'],
                last_name:   vals['add-last-name'],
                middle_name: document.getElementById('add-middle-name').value.trim(),
                email:       vals['add-email'],
                password:    vals['add-password'],
                role:        vals['add-role'],
                gender:      vals['add-gender'],
                birth_date:  vals['add-birth-date'],
            });
            showToast('✅ ' + res.message, 'success');
            closeAddModal();
            await loadUsers();
        } catch (err) {
            showToast(err.message, 'error');
        }
    });

    /* ----------------------------------------------------------
       VIEW / EDIT USER MODAL
    ---------------------------------------------------------- */
    const viewOverlay = document.getElementById('user-modal-overlay');

    function openViewModal(user) {
        if (!user) return;
        currentUser = user;

        const initials = (user.first_name[0] + user.last_name[0]).toUpperCase();
        const fullName = [user.first_name, user.middle_name, user.last_name].filter(Boolean).join(' ');

        const avatar = document.getElementById('user-modal-avatar');
        avatar.textContent      = initials;
        avatar.style.background = avatarColors[user.role] || '#5b21b6';

        document.getElementById('user-modal-name').textContent        = fullName;
        document.getElementById('user-modal-email-disp').textContent  = user.email;
        document.getElementById('user-modal-role-disp').textContent   = roleLabels[user.role] || user.role;
        document.getElementById('user-modal-gender-disp').textContent = cap(user.gender);
        document.getElementById('user-modal-status-disp').textContent =
            user.is_banned ? '⛔ Banned' : (!user.is_active ? '🚫 Inactive' : (user.is_verified ? '✅ Verified' : '❌ Unverified'));
        document.getElementById('user-modal-age').textContent    = user.age + ' years old';
        document.getElementById('user-modal-joined').textContent = new Date(user.created_at).toLocaleDateString('en-US', { year:'numeric', month:'short', day:'numeric' });
        document.getElementById('user-modal-id').textContent     = 'ID: ' + user.id;

        // Populate editable fields
        document.getElementById('edit-first-name').value  = user.first_name;
        document.getElementById('edit-last-name').value   = user.last_name;
        document.getElementById('edit-middle-name').value = user.middle_name ?? '';
        document.getElementById('edit-email').value       = user.email;
        document.getElementById('edit-gender').value      = user.gender;
        document.getElementById('edit-birth-date').value  = user.birth_date ?? '';
        document.getElementById('user-modal-role-select').value = user.role;

        // Toggle button label
        const toggleBtn = document.getElementById('user-modal-toggle');
        toggleBtn.textContent      = user.is_active ? '🚫 Deactivate' : '✅ Activate';
        toggleBtn.style.background = user.is_active ? '#d97706'       : '#059669';

        // Ban button label
        const banBtn = document.getElementById('user-modal-ban');
        banBtn.textContent      = user.is_banned ? '🔓 Unban User' : '⛔ Ban User';
        banBtn.style.background = user.is_banned ? '#059669'        : '#dc2626';

        // Collapse edit section
        document.getElementById('edit-section').style.display      = 'none';
        document.getElementById('btn-toggle-edit').textContent     = '✏️ Edit Info';

        viewOverlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeViewModal() {
        viewOverlay.classList.remove('is-open');
        document.body.style.overflow = '';
        currentUser = null;
    }

    document.getElementById('user-modal-close')?.addEventListener('click', closeViewModal);
    viewOverlay?.addEventListener('click', e => { if (e.target === viewOverlay) closeViewModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeViewModal(); closeAddModal(); } });

    // Toggle edit section visibility
    document.getElementById('btn-toggle-edit')?.addEventListener('click', () => {
        const sec     = document.getElementById('edit-section');
        const visible = sec.style.display !== 'none';
        sec.style.display = visible ? 'none' : 'block';
        document.getElementById('btn-toggle-edit').textContent = visible ? '✏️ Edit Info' : '🔼 Hide Edit';
    });

    // Save role
    document.getElementById('btn-save-role')?.addEventListener('click', async () => {
        if (!currentUser) return;
        const newRole = document.getElementById('user-modal-role-select').value;
        if (newRole === currentUser.role) { showToast('No change in role.', 'info'); return; }
        if (!confirm(`Change role of "${currentUser.first_name}" from ${roleLabels[currentUser.role]} → ${roleLabels[newRole]}?`)) return;

        try {
            await apiFetch({ action: 'update_role', id: currentUser.id, role: newRole });
            showToast('Role updated successfully!', 'success');
            closeViewModal();
            await loadUsers();
        } catch (err) { showToast(err.message, 'error'); }
    });

    // Save edited info
    document.getElementById('btn-save-edit')?.addEventListener('click', async () => {
        if (!currentUser) return;
        if (!confirm('⚠️ You are about to edit this user\'s personal information. Continue?')) return;

        const payload = {
            action:      'update_user',
            id:          currentUser.id,
            first_name:  document.getElementById('edit-first-name').value.trim(),
            last_name:   document.getElementById('edit-last-name').value.trim(),
            middle_name: document.getElementById('edit-middle-name').value.trim(),
            email:       document.getElementById('edit-email').value.trim(),
            gender:      document.getElementById('edit-gender').value,
            birth_date:  document.getElementById('edit-birth-date').value,
        };

        if (!payload.first_name || !payload.last_name || !payload.email) {
            showToast('First name, last name, and email are required.', 'error'); return;
        }

        try {
            await apiFetch(payload);
            showToast('User info updated!', 'success');
            closeViewModal();
            await loadUsers();
        } catch (err) { showToast(err.message, 'error'); }
    });

    // Modal toggle (activate/deactivate)
    document.getElementById('user-modal-toggle')?.addEventListener('click', () => {
        if (currentUser) handleToggle(currentUser.id);
    });

    // Modal ban
    document.getElementById('user-modal-ban')?.addEventListener('click', () => {
        if (currentUser) handleBan(currentUser.id);
    });

    // Modal delete
    document.getElementById('user-modal-delete')?.addEventListener('click', () => {
        if (currentUser) handleDelete(currentUser.id);
    });

    /* ----------------------------------------------------------
       SHARED ACTIONS
    ---------------------------------------------------------- */
    async function handleToggle(id) {
        const user   = getUser(id);
        if (!user) return;
        const action = user.is_active ? 'deactivate' : 'activate';
        const note   = action === 'deactivate'
            ? 'They cannot log in but the account CAN be reactivated later.'
            : 'They will regain full access to their account.';

        if (!confirm(`${cap(action)} account of "${user.first_name} ${user.last_name}"?\n\n${note}`)) return;

        try {
            const res = await apiFetch({ action: 'toggle_user', id });
            showToast(res.message, 'success');
            closeViewModal();
            await loadUsers();
        } catch (err) { showToast(err.message, 'error'); }
    }

    async function handleBan(id) {
        const user = getUser(id);
        if (!user) return;
        const name = `${user.first_name} ${user.last_name}`;
        let reason = null;

        if (!user.is_banned) {
            reason = prompt(`Enter reason for banning "${name}" (leave blank for default):`);
            if (reason === null) return; // user cancelled
        } else {
            if (!confirm(`Unban "${name}"?`)) return;
        }

        try {
            const res = await apiFetch({ action: 'ban_user', id, reason });
            showToast(res.message, user.is_banned ? 'success' : 'error');
            closeViewModal();
            await loadUsers();
        } catch (err) { showToast(err.message, 'error'); }
    }

    async function handleDelete(id) {
        const user = getUser(id);
        if (!user) return;
        const name = `${user.first_name} ${user.last_name}`;

        if (!confirm(`⚠️ PERMANENT DELETE\n\nAre you sure you want to delete "${name}"?\n\nThis CANNOT be undone.`)) return;
        if (!confirm(`Final confirmation: permanently delete "${name}"?`)) return;

        try {
            const res = await apiFetch({ action: 'delete_user', id });
            showToast(res.message, 'error');
            closeViewModal();
            await loadUsers();
        } catch (err) { showToast(err.message, 'error'); }
    }

    /* ----------------------------------------------------------
       API HELPER
    ---------------------------------------------------------- */
    async function apiFetch(payload) {
        const res  = await fetch(API_URL, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify(payload),
        });
        const data = await res.json();
        if (data.status !== 'success') throw new Error(data.message || 'Unknown error');
        return data;
    }

    /* ----------------------------------------------------------
       TOAST
    ---------------------------------------------------------- */
    function showToast(msg, type = 'success') {
        const t = document.createElement('div');
        t.className   = `svc-toast toast-${type}`;
        t.textContent = msg;
        document.body.appendChild(t);
        setTimeout(() => t.classList.add('toast-visible'), 10);
        setTimeout(() => { t.classList.remove('toast-visible'); setTimeout(() => t.remove(), 300); }, 3500);
    }

    /* ----------------------------------------------------------
       UTILS
    ---------------------------------------------------------- */
    function esc(s) { return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
    function cap(s) { return s ? s.charAt(0).toUpperCase() + s.slice(1) : ''; }

    /* ----------------------------------------------------------
       INIT
    ---------------------------------------------------------- */
    loadUsers();
});