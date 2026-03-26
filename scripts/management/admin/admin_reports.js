/* admin_reports.js */

document.addEventListener('DOMContentLoaded', () => {

    /* ---- FILTER ---- */
    const searchInput  = document.getElementById('report-search');
    const typeSelect   = document.getElementById('report-type');
    const reasonSelect = document.getElementById('report-reason');
    const statusSelect = document.getElementById('report-status');
    const cards        = Array.from(document.querySelectorAll('.svc-card'));
    const noResults    = document.getElementById('no-results');

    function filterCards() {
        const query  = searchInput.value.toLowerCase().trim();
        const type   = typeSelect.value;
        const reason = reasonSelect.value;
        const status = statusSelect.value;
        let visible  = 0;

        cards.forEach(card => {
            const content  = card.dataset.content  || '';
            const reporter = card.dataset.reporter || '';
            const cardType = card.dataset.type     || '';
            const cardRsn  = card.dataset.reason   || '';
            const cardSts  = card.dataset.status   || '';

            const matchSearch = !query  || content.includes(query) || reporter.includes(query);
            const matchType   = type   === 'all' || cardType === type;
            const matchReason = reason === 'all' || cardRsn  === reason;
            const matchStatus = status === 'all' || cardSts  === status;

            const show = matchSearch && matchType && matchReason && matchStatus;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        noResults.style.display = visible === 0 ? 'block' : 'none';
    }

    searchInput?.addEventListener('input',    filterCards);
    typeSelect?.addEventListener('change',    filterCards);
    reasonSelect?.addEventListener('change',  filterCards);
    statusSelect?.addEventListener('change',  filterCards);

    /* ---- MODAL ---- */
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

        document.getElementById('report-modal-icon').textContent      = reasonIcons[report.reason] || '⚠️';
        document.getElementById('report-modal-title').textContent     = report.content;
        document.getElementById('report-modal-subtitle').textContent  = `${report.type === 'thread' ? '🧵 Thread' : '💬 Comment'} · Reported ${report.date}`;
        document.getElementById('report-modal-reporter').textContent  = report.reported_by;
        document.getElementById('report-modal-author').textContent    = report.author;
        document.getElementById('report-modal-reason').textContent    = `${reasonIcons[report.reason]} ${report.reason.charAt(0).toUpperCase() + report.reason.slice(1)}`;
        document.getElementById('report-modal-excerpt').textContent   = `"${report.excerpt}"`;
        document.getElementById('report-modal-details').textContent   = report.details;
        document.getElementById('report-modal-date').textContent      = report.date;
        document.getElementById('report-admin-note').value            = '';

        overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeReportModal() {
        overlay.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    overlay?.addEventListener('click', e => { if (e.target === overlay) closeReportModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeReportModal(); });

    /* ---- ACTIONS ---- */
    function reportAction(action) {
        const note = document.getElementById('report-admin-note').value.trim();
        const labels = {
            ignore: '✅ Report ignored.',
            warn:   '⚠️ User has been warned.',
            delete: '❌ Post deleted.',
            ban:    '🚫 User has been banned.',
        };
        const types = {
            ignore: 'info',
            warn:   'info',
            delete: 'error',
            ban:    'error',
        };

        if (action === 'ban' && !confirm(`Ban the user "${currentReport?.author}"? This action cannot be undone.`)) return;
        if (action === 'delete' && !confirm('Delete this post? This action cannot be undone.')) return;

        // TODO: connect to backend
        showToast(labels[action] + (note ? ` Note: "${note}"` : ''), types[action]);
        closeReportModal();
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
    window.openReportModal  = openReportModal;
    window.closeReportModal = closeReportModal;
    window.reportAction     = reportAction;
});
```

---

**I-save ang files dito:**
```
styles/management/admin/admin_threads.css
scripts/management/admin/admin_threads.js
scripts/management/admin/admin_reports.js
views/management/admin/admin_threads.php
views/management/admin/admin_reports.php