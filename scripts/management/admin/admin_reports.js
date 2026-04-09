/* admin_reports.js */

document.addEventListener('DOMContentLoaded', () => {

    /* ── FILTER ──────────────────────────────────────────── */

    const searchInput  = document.getElementById('report-search');
    const typeSelect   = document.getElementById('report-type');
    const reasonSelect = document.getElementById('report-reason');
    const statusSelect = document.getElementById('report-status');
    const rows         = Array.from(document.querySelectorAll('.rpt-row'));
    const noResults    = document.getElementById('no-results');

    function filterRows() {
        const query  = searchInput.value.toLowerCase().trim();
        const type   = typeSelect.value;
        const reason = reasonSelect.value;
        const status = statusSelect.value;
        let visible  = 0;

        rows.forEach(row => {
            const content  = row.dataset.content   || '';
            const reporter = row.dataset.reporter  || '';
            const rowType  = row.dataset.type      || '';
            const rowRsn   = row.dataset.reason    || '';
            const rowSts   = row.dataset.status    || '';

            const matchSearch = !query  || content.includes(query) || reporter.includes(query);
            const matchType   = type   === 'all' || rowType === type;
            const matchReason = reason === 'all' || rowRsn  === reason;
            const matchStatus = status === 'all' || rowSts  === status;

            const show = matchSearch && matchType && matchReason && matchStatus;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        noResults.style.display = visible === 0 ? 'block' : 'none';
    }

    searchInput?.addEventListener('input',   filterRows);
    typeSelect?.addEventListener('change',   filterRows);
    reasonSelect?.addEventListener('change', filterRows);
    statusSelect?.addEventListener('change', filterRows);

    /* ── MODAL ───────────────────────────────────────────── */

    const overlay = document.getElementById('report-modal-overlay');
    let currentReport = null;

    const reasonIcons = {
        spam:           '🚫',
        abuse:          '⚠️',
        harassment:     '😡',
        misinformation: '❌',
        other:          '📋',
    };

    function openReportModal(report) {
        currentReport = report;

        /* Header */
        document.getElementById('report-modal-icon').textContent     = reasonIcons[report.reason] || '⚠️';
        document.getElementById('report-modal-title').textContent    = report.content;
        document.getElementById('report-modal-subtitle').textContent =
            `${report.type === 'thread' ? '🧵 Thread' : '💬 Comment'} · Reported ${report.date}`;

        /* Summary strip */
        document.getElementById('report-modal-reporter').textContent = report.reported_by;
        document.getElementById('report-modal-author').textContent   = report.author;
        document.getElementById('report-modal-reason').textContent   =
            `${reasonIcons[report.reason]} ${report.reason.charAt(0).toUpperCase() + report.reason.slice(1)}`;
        document.getElementById('report-modal-date').textContent     = report.date;

        /* Body */
        document.getElementById('report-modal-excerpt').textContent  = `"${report.excerpt}"`;
        document.getElementById('report-modal-details').textContent  = report.details;
        document.getElementById('report-admin-note').value           = '';

        overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeReportModal() {
        overlay.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    /* Close on backdrop click or Escape */
    overlay?.addEventListener('click', e => { if (e.target === overlay) closeReportModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeReportModal(); });

    /* ── ACTIONS ─────────────────────────────────────────── */

    function reportAction(action) {
        const note = document.getElementById('report-admin-note').value.trim();

        const labels = {
            ignore: '✅ Report ignored.',
            warn:   '⚠️ User has been warned.',
            delete: '❌ Post deleted.',
            ban:    '🚫 User has been banned.',
        };

        const toastTypes = {
            ignore: 'info',
            warn:   'info',
            delete: 'error',
            ban:    'error',
        };

        if (action === 'ban' &&
            !confirm(`Ban the user "${currentReport?.author}"? This action cannot be undone.`)) return;

        if (action === 'delete' &&
            !confirm('Delete this post? This action cannot be undone.')) return;

        // TODO: connect to backend
        showToast(
            labels[action] + (note ? ` Note: "${note}"` : ''),
            toastTypes[action]
        );
        closeReportModal();
    }

    /* ── TOAST ───────────────────────────────────────────── */

    function showToast(msg, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `rpt-toast toast-${type}`;
        toast.textContent = msg;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3500);
    }

    /* ── EXPOSE TO GLOBAL (called from PHP inline onclick) ── */

    window.openReportModal  = openReportModal;
    window.closeReportModal = closeReportModal;
    window.reportAction     = reportAction;
});