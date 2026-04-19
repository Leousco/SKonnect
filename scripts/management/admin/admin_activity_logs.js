/**
 * admin_activity_logs.js
 * Activity log table with search, filter by action/date range, pagination, CSV export.
 *
 * In production: replace the `SAMPLE_LOGS` array with a fetch() call to your
 * backend endpoint (e.g. /api/admin/activity-logs) that returns JSON in the
 * same shape.
 */

document.addEventListener('DOMContentLoaded', function () {

    // ── Sample data (replace with real API fetch) ─────────
    const SAMPLE_LOGS = [
        { id: 1,  date: '2026-03-01', time: '10:42 AM', user: 'Maria Santos',   initials: 'MS', role: 'admin',  action: 'approved',  description: 'Approved scholarship request for <strong>Juan Dela Cruz</strong>', ip: '192.168.1.10' },
        { id: 2,  date: '2026-03-01', time: '09:15 AM', user: 'Maria Santos',   initials: 'MS', role: 'admin',  action: 'login',     description: 'Admin logged in', ip: '192.168.1.10' },
        { id: 3,  date: '2026-02-28', time: '02:15 PM', user: 'Maria Santos',   initials: 'MS', role: 'admin',  action: 'published', description: 'Published announcement: <strong>Scholarship Program 2026</strong>', ip: '192.168.1.10' },
        { id: 4,  date: '2026-02-27', time: '09:00 AM', user: 'Maria Santos',   initials: 'MS', role: 'admin',  action: 'flagged',   description: 'Flagged community post by <strong>Pedro Reyes</strong> for review', ip: '192.168.1.10' },
        { id: 5,  date: '2026-02-26', time: '04:30 PM', user: 'Maria Santos',   initials: 'MS', role: 'admin',  action: 'declined',  description: 'Declined medical assistance request for <strong>Pedro Santos</strong>', ip: '192.168.1.10' },
        { id: 6,  date: '2026-02-25', time: '11:00 AM', user: 'Carlo Reyes',    initials: 'CR', role: 'staff',  action: 'updated',   description: 'Updated service details for <strong>Livelihood Program</strong>', ip: '192.168.1.22' },
        { id: 7,  date: '2026-02-25', time: '10:30 AM', user: 'Ana Bautista',   initials: 'AB', role: 'member', action: 'login',     description: 'Member logged in', ip: '192.168.1.55' },
        { id: 8,  date: '2026-02-24', time: '03:00 PM', user: 'Carlo Reyes',    initials: 'CR', role: 'staff',  action: 'created',   description: 'Created new event: <strong>Medical Mission — Mar 22</strong>', ip: '192.168.1.22' },
        { id: 9,  date: '2026-02-24', time: '01:20 PM', user: 'Maria Santos',   initials: 'MS', role: 'admin',  action: 'approved',  description: 'Approved livelihood request for <strong>Liza Cruz</strong>', ip: '192.168.1.10' },
        { id: 10, date: '2026-02-23', time: '08:45 AM', user: 'Maria Santos',   initials: 'MS', role: 'admin',  action: 'deleted',   description: 'Deleted expired announcement: <strong>Barangay Clean-up Drive</strong>', ip: '192.168.1.10' },
        { id: 11, date: '2026-02-22', time: '02:00 PM', user: 'Carlo Reyes',    initials: 'CR', role: 'staff',  action: 'published', description: 'Published announcement: <strong>Youth Leadership Seminar 2026</strong>', ip: '192.168.1.22' },
        { id: 12, date: '2026-02-21', time: '10:10 AM', user: 'Ana Bautista',   initials: 'AB', role: 'member', action: 'login',     description: 'Member logged in', ip: '192.168.1.55' },
        { id: 13, date: '2026-02-20', time: '04:00 PM', user: 'Maria Santos',   initials: 'MS', role: 'admin',  action: 'updated',   description: 'Updated user role for <strong>Carlo Reyes</strong> to Staff', ip: '192.168.1.10' },
        { id: 14, date: '2026-02-19', time: '09:30 AM', user: 'Maria Santos',   initials: 'MS', role: 'admin',  action: 'approved',  description: 'Approved medical assistance for <strong>Rosa Magtibay</strong>', ip: '192.168.1.10' },
        { id: 15, date: '2026-02-18', time: '11:45 AM', user: 'Carlo Reyes',    initials: 'CR', role: 'staff',  action: 'created',   description: 'Created new service: <strong>Legal Aid Program</strong>', ip: '192.168.1.22' },
        { id: 16, date: '2026-02-17', time: '03:15 PM', user: 'Maria Santos',   initials: 'MS', role: 'admin',  action: 'flagged',   description: 'Flagged thread by <strong>Anonymous User</strong> for inappropriate content', ip: '192.168.1.10' },
        { id: 17, date: '2026-02-16', time: '10:00 AM', user: 'Ana Bautista',   initials: 'AB', role: 'member', action: 'login',     description: 'Member logged in', ip: '192.168.1.55' },
        { id: 18, date: '2026-02-15', time: '02:30 PM', user: 'Maria Santos',   initials: 'MS', role: 'admin',  action: 'declined',  description: 'Declined scholarship request for <strong>Mark Villanueva</strong>', ip: '192.168.1.10' },
        { id: 19, date: '2026-02-14', time: '09:00 AM', user: 'Carlo Reyes',    initials: 'CR', role: 'staff',  action: 'updated',   description: 'Updated event details for <strong>SK General Assembly</strong>', ip: '192.168.1.22' },
        { id: 20, date: '2026-02-13', time: '04:45 PM', user: 'Maria Santos',   initials: 'MS', role: 'admin',  action: 'deleted',   description: 'Deleted user account: <strong>Test User 001</strong>', ip: '192.168.1.10' },
        { id: 21, date: '2026-02-12', time: '11:00 AM', user: 'Maria Santos',   initials: 'MS', role: 'admin',  action: 'approved',  description: 'Approved scholarship request for <strong>Elena Torres</strong>', ip: '192.168.1.10' },
        { id: 22, date: '2026-02-11', time: '01:30 PM', user: 'Carlo Reyes',    initials: 'CR', role: 'staff',  action: 'published', description: 'Published announcement: <strong>Medical Mission — Mar 22</strong>', ip: '192.168.1.22' },
        { id: 23, date: '2026-02-10', time: '10:20 AM', user: 'Maria Santos',   initials: 'MS', role: 'admin',  action: 'updated',   description: 'Updated system settings: notification preferences', ip: '192.168.1.10' },
        { id: 24, date: '2026-02-09', time: '08:55 AM', user: 'Ana Bautista',   initials: 'AB', role: 'member', action: 'login',     description: 'Member logged in', ip: '192.168.1.55' },
        { id: 25, date: '2026-02-08', time: '03:40 PM', user: 'Maria Santos',   initials: 'MS', role: 'admin',  action: 'created',   description: 'Created new announcement: <strong>Barangay Clean-up Drive</strong>', ip: '192.168.1.10' },
    ];

    // ── State ─────────────────────────────────────────────
    const PAGE_SIZE = 10;
    let currentPage = 1;
    let filteredLogs = [...SAMPLE_LOGS];

    // ── DOM refs ──────────────────────────────────────────
    const searchInput   = document.getElementById('logSearch');
    const filterAction  = document.getElementById('filterAction');
    const filterFrom    = document.getElementById('filterDateFrom');
    const filterTo      = document.getElementById('filterDateTo');
    const resetBtn      = document.getElementById('resetFilters');
    const exportBtn     = document.getElementById('exportCSV');
    const logBody       = document.getElementById('logBody');
    const logEmpty      = document.getElementById('logEmpty');
    const totalCount    = document.getElementById('totalCount');
    const filteredCount = document.getElementById('filteredCount');
    const pageInfo      = document.getElementById('pageInfo');
    const pageNumbers   = document.getElementById('pageNumbers');
    const prevBtn       = document.getElementById('prevPage');
    const nextBtn       = document.getElementById('nextPage');

    totalCount.textContent = SAMPLE_LOGS.length;

    // ── Action badge config ───────────────────────────────
    const ACTION_CONFIG = {
        approved:  { cls: 'act-approved',  icon: '<path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>' },
        declined:  { cls: 'act-declined',  icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>' },
        published: { cls: 'act-published', icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09"/>' },
        flagged:   { cls: 'act-flagged',   icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>' },
        deleted:   { cls: 'act-deleted',   icon: '<path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79"/>' },
        created:   { cls: 'act-created',   icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>' },
        updated:   { cls: 'act-updated',   icon: '<path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>' },
        login:     { cls: 'act-login',     icon: '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15"/>' },
    };

    // ── Filter logic ──────────────────────────────────────
    function applyFilters() {
        const q      = searchInput.value.toLowerCase().trim();
        const action = filterAction.value;
        const from   = filterFrom.value;
        const to     = filterTo.value;

        filteredLogs = SAMPLE_LOGS.filter(log => {
            const matchSearch = !q || [
                log.user, log.action, log.description.replace(/<[^>]+>/g, '')
            ].some(s => s.toLowerCase().includes(q));

            const matchAction = !action || log.action === action;
            const matchFrom   = !from || log.date >= from;
            const matchTo     = !to   || log.date <= to;

            return matchSearch && matchAction && matchFrom && matchTo;
        });

        currentPage = 1;
        render();
    }

    // ── Render ────────────────────────────────────────────
    function render() {
        const totalPages = Math.max(1, Math.ceil(filteredLogs.length / PAGE_SIZE));
        const start = (currentPage - 1) * PAGE_SIZE;
        const pageData = filteredLogs.slice(start, start + PAGE_SIZE);

        filteredCount.textContent = filteredLogs.length;
        pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;

        // Rows
        logBody.innerHTML = pageData.map(log => {
            const actionConf = ACTION_CONFIG[log.action] || ACTION_CONFIG['login'];
            const roleCls = { admin: 'role-admin', staff: 'role-staff', member: 'role-member' }[log.role] || 'role-member';
            const roleLabel = log.role.charAt(0).toUpperCase() + log.role.slice(1);

            return `
            <tr>
                <td>
                    <div class="log-ts">
                        <span class="log-ts-date">${log.date}</span>
                        <span class="log-ts-time">${log.time}</span>
                    </div>
                </td>
                <td>
                    <div class="log-user">
                        <div class="log-avatar">${log.initials}</div>
                        <span class="log-username">${log.user}</span>
                    </div>
                </td>
                <td><span class="log-role-badge ${roleCls}">${roleLabel}</span></td>
                <td>
                    <span class="log-action-badge ${actionConf.cls}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">${actionConf.icon}</svg>
                        ${log.action.charAt(0).toUpperCase() + log.action.slice(1)}
                    </span>
                </td>
                <td><span class="log-desc">${log.description}</span></td>
                <td><span class="log-ip">${log.ip}</span></td>
            </tr>`;
        }).join('');

        // Empty state
        logEmpty.style.display = pageData.length === 0 ? 'flex' : 'none';

        // Pagination buttons
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;

        // Page numbers
        pageNumbers.innerHTML = '';
        const range = buildPageRange(currentPage, totalPages);
        range.forEach(p => {
            if (p === '…') {
                const el = document.createElement('span');
                el.textContent = '…';
                el.style.cssText = 'padding:0 4px;color:var(--admin-text-muted);font-size:12px;';
                pageNumbers.appendChild(el);
            } else {
                const btn = document.createElement('button');
                btn.className = 'log-page-num' + (p === currentPage ? ' active' : '');
                btn.textContent = p;
                btn.addEventListener('click', () => { currentPage = p; render(); });
                pageNumbers.appendChild(btn);
            }
        });
    }

    function buildPageRange(current, total) {
        if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
        if (current <= 4) return [1, 2, 3, 4, 5, '…', total];
        if (current >= total - 3) return [1, '…', total-4, total-3, total-2, total-1, total];
        return [1, '…', current-1, current, current+1, '…', total];
    }

    // ── Events ────────────────────────────────────────────
    searchInput.addEventListener('input', applyFilters);
    filterAction.addEventListener('change', applyFilters);
    filterFrom.addEventListener('change', applyFilters);
    filterTo.addEventListener('change', applyFilters);

    prevBtn.addEventListener('click', () => { if (currentPage > 1) { currentPage--; render(); } });
    nextBtn.addEventListener('click', () => {
        const totalPages = Math.ceil(filteredLogs.length / PAGE_SIZE);
        if (currentPage < totalPages) { currentPage++; render(); }
    });

    resetBtn.addEventListener('click', () => {
        searchInput.value   = '';
        filterAction.value  = '';
        filterFrom.value    = '';
        filterTo.value      = '';
        applyFilters();
    });

    // ── CSV Export ────────────────────────────────────────
    exportBtn.addEventListener('click', () => {
        const headers = ['Date', 'Time', 'User', 'Role', 'Action', 'Description', 'IP Address'];
        const rows = filteredLogs.map(log => [
            log.date,
            log.time,
            log.user,
            log.role,
            log.action,
            log.description.replace(/<[^>]+>/g, ''),
            log.ip
        ].map(v => `"${v}"`).join(','));

        const csv = [headers.join(','), ...rows].join('\n');
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url  = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href     = url;
        link.download = `activity_logs_${new Date().toISOString().slice(0,10)}.csv`;
        link.click();
        URL.revokeObjectURL(url);
    });

    // ── Init ──────────────────────────────────────────────
    render();

});