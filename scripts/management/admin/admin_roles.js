/* admin_roles.js */

document.addEventListener('DOMContentLoaded', () => {

    const roleLabels = {
        admin:      '🛡️ Admin',
        moderator:  '🔧 Moderator',
        sk_officer: '⭐ SK Officer',
        resident:   '👤 Resident',
    };

    /* ---- ASSIGN ROLE ---- */
    function assignRole(userId, userName) {
        const select  = document.getElementById(`role-select-${userId}`);
        const newRole = select?.value;
        if (!newRole) return;

        if (confirm(`Change role of "${userName}" to "${roleLabels[newRole]}"?\n\nThis will update their access permissions immediately.`)) {
            // TODO: connect to backend
            showToast(`💾 Role updated to "${roleLabels[newRole]}" for ${userName}! (placeholder)`, 'success');
        }
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
    window.assignRole = assignRole;
});