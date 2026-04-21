/* scripts/management/admin/admin_roles.js */

document.addEventListener('DOMContentLoaded', () => {

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

    const roleAvatarClass = {
        admin:      'role-avatar-admin',
        moderator:  'role-avatar-moderator',
        sk_officer: 'role-avatar-sk_officer',
        resident:   'role-avatar-resident',
    };

    let allUsers = [];

    /* ── LOAD ──────────────────────────────────────────────── */
    async function loadData() {
        try {
            const res  = await fetch(`${API_URL}?action=get_users`);
            const json = await res.json();
            if (json.status !== 'success') throw new Error(json.message);

            allUsers = json.data.users;
            const counts = json.data.counts;

            updateRoleCards(counts);
            renderUserTable(allUsers);
        } catch (err) {
            showToast('Failed to load data: ' + err.message, 'error');
        }
    }

    /* ── UPDATE ROLE CARD COUNTS ───────────────────────────── */
    // counts = { admin: N, moderator: N, sk_officer: N, resident: N }
    function updateRoleCards(counts) {
        // Update the stats strip pills — each pill has a data-role attribute
        // OR we match by order (same order as $roles in PHP).
        // Using data-role is more reliable; pills are rendered in roleLabels order.
        const roles = Object.keys(roleLabels); // ['admin','moderator','sk_officer','resident']

        // Stats strip pills (one per role, in order)
        const pills = document.querySelectorAll('.svc-stat-pill');
        pills.forEach((pill, i) => {
            const role = roles[i];
            if (!role) return;
            const num = pill.querySelector('.svc-stat-num');
            if (num) num.textContent = counts[role] ?? 0;
        });

        // Role cards — match by id="count-{role}" set in the PHP template
        roles.forEach(role => {
            const chip = document.getElementById(`count-${role}`);
            if (!chip) return;
            const c = counts[role] ?? 0;
            chip.textContent = `${c} user${c !== 1 ? 's' : ''}`;
        });
    }

    /* ── RENDER ASSIGN TABLE ───────────────────────────────── */
    function renderUserTable(users) {
        const tbody = document.querySelector('#assign-table tbody');
        if (!tbody) return;

        tbody.innerHTML = '';

        if (!users.length) {
            tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; padding:2rem;
                color:var(--ap-text-muted); font-family:'Poppins',sans-serif; font-size:13px;">
                No users found.</td></tr>`;
            return;
        }

        users.forEach(user => {
            const initials = (user.first_name[0] + user.last_name[0]).toUpperCase();
            const fullName = [user.first_name, user.middle_name, user.last_name]
                .filter(Boolean).join(' ');

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    <div class="user-name-cell">
                        <div class="user-avatar ${roleAvatarClass[user.role] ?? ''}">${escHtml(initials)}</div>
                        <span class="user-fullname">${escHtml(fullName)}</span>
                    </div>
                </td>
                <td class="user-email">${escHtml(user.email)}</td>
                <td>
                    <span class="user-role-badge ${roleColorClass[user.role] ?? ''}">
                        ${roleLabels[user.role] ?? user.role}
                    </span>
                </td>
                <td>
                    <select class="svc-select-input role-select" id="role-select-${user.id}">
                        ${Object.entries(roleLabels).map(([val, lbl]) =>
                            `<option value="${val}" ${user.role === val ? 'selected' : ''}>${lbl}</option>`
                        ).join('')}
                    </select>
                </td>
                <td>
                    <button class="btn-user-action btn-view"
                        onclick="assignRole(${user.id}, '${escAttr(fullName)}')">
                        💾 Save
                    </button>
                </td>`;

            tbody.appendChild(tr);
        });
    }

    /* ── ASSIGN ROLE ───────────────────────────────────────── */
    async function assignRole(userId, userName) {
        const select  = document.getElementById(`role-select-${userId}`);
        const newRole = select?.value;
        if (!newRole) return;

        const user = allUsers.find(u => u.id == userId);
        if (user && user.role === newRole) {
            showToast('No change in role.', 'info');
            return;
        }

        if (!confirm(`Change role of "${userName}" to "${roleLabels[newRole]}"?\n\nThis updates their access permissions immediately.`)) return;

        try {
            const res  = await fetch(API_URL, {
                method:  'POST',
                headers: { 'Content-Type': 'application/json' },
                body:    JSON.stringify({ action: 'update_role', id: userId, role: newRole }),
            });
            const json = await res.json();
            if (json.status !== 'success') throw new Error(json.message);

            showToast(`💾 Role updated to "${roleLabels[newRole]}" for ${userName}!`, 'success');
            await loadData(); // refresh counts + table
        } catch (err) {
            showToast('Error: ' + err.message, 'error');
        }
    }

    /* ── TOAST ─────────────────────────────────────────────── */
    function showToast(msg, type = 'success') {
        const toast = document.createElement('div');
        toast.className   = `svc-toast toast-${type}`;
        toast.textContent = msg;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3500);
    }

    /* ── UTILS ─────────────────────────────────────────────── */
    function escHtml(str) {
        return String(str ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function escAttr(str) {
        return String(str ?? '').replace(/'/g, "\\'");
    }

    /* ── EXPOSE GLOBALS ────────────────────────────────────── */
    window.assignRole = assignRole;

    /* ── INIT ──────────────────────────────────────────────── */
    loadData();
});