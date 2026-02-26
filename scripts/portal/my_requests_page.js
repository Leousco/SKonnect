/* my_requests_page.js — Portal My Requests */

document.addEventListener('DOMContentLoaded', () => {

    /* ---- FILTER & SORT ---- */

    const searchInput    = document.getElementById('req-search');
    const statusSelect   = document.getElementById('req-status');
    const categorySelect = document.getElementById('req-category');
    const sortSelect     = document.getElementById('req-sort');
    const rows           = Array.from(document.querySelectorAll('.req-row'));
    const noResults      = document.getElementById('no-results');
    const tbody          = document.getElementById('req-tbody');

    function filterRows() {
        const query    = searchInput.value.toLowerCase().trim();
        const status   = statusSelect.value;
        const category = categorySelect.value;
        let   visible  = 0;

        rows.forEach(row => {
            const service = (row.dataset.service   || '').toLowerCase();
            const ref     = (row.dataset.ref        || '').toLowerCase();
            const rowSts  =  row.dataset.status     || '';
            const rowCat  =  row.dataset.category   || '';

            const matchesSearch   = !query    || service.includes(query) || ref.includes(query);
            const matchesStatus   = status   === 'all' || rowSts === status;
            const matchesCategory = category === 'all' || rowCat === category;

            const show = matchesSearch && matchesStatus && matchesCategory;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        noResults.style.display = visible === 0 ? 'block' : 'none';
    }

    function sortRows() {
        const order = sortSelect.value;

        // Parse date from submitted column (index 3)
        const getDate = row => {
            const cell = row.querySelectorAll('td')[3];
            return cell ? new Date(cell.textContent.trim()) : new Date(0);
        };

        const sorted = [...rows].sort((a, b) => {
            const da = getDate(a), db = getDate(b);
            return order === 'oldest' ? da - db : db - da;
        });

        sorted.forEach(row => tbody.appendChild(row));
        filterRows();
    }

    searchInput.addEventListener('input',     filterRows);
    statusSelect.addEventListener('change',   filterRows);
    categorySelect.addEventListener('change', filterRows);
    sortSelect.addEventListener('change',     sortRows);

    /* ---- MODAL ---- */

    const modalOverlay  = document.getElementById('modal-overlay');
    const modalClose    = document.getElementById('modal-close');
    const modalCloseBtn = document.getElementById('modal-close-btn');

    // Modal fields
    const modalTitle      = document.getElementById('modal-title');
    const modalRefNum     = document.getElementById('modal-ref-num');
    const modalIcon       = document.getElementById('modal-svc-icon');
    const stripStatus     = document.getElementById('strip-status');
    const stripSubmitted  = document.getElementById('strip-submitted');
    const stripUpdated    = document.getElementById('strip-updated');
    const stripDocs       = document.getElementById('strip-docs');
    const detailPurpose   = document.getElementById('detail-purpose');
    const reqTimeline     = document.getElementById('req-timeline');
    const skBlock         = document.getElementById('sk-response-block');
    const noRespBlock     = document.getElementById('no-response-block');
    const respOfficer     = document.getElementById('resp-officer');
    const respDate        = document.getElementById('resp-date');
    const respNote        = document.getElementById('resp-note');

    // Map service names to icons
    const iconMap = {
        'Medical Assistance':   '🏥',
        'Scholarship Program':  '🏅',
        'Educational Support':  '🎓',
        'Livelihood Support':   '📚',
        'Dental Assistance':    '🩺',
        'Skills Training':      '🛠️',
    };

    // Status → timeline config
    const timelineConfig = {
        'pending': [
            { dot: 'dot-submitted', icon: '📨', label: 'Request Submitted',    date: null },
            { dot: 'dot-pending',   icon: '🕐', label: 'Awaiting SK Review',   date: null, pending: true },
        ],
        'under-review': [
            { dot: 'dot-submitted', icon: '📨', label: 'Request Submitted',  date: null },
            { dot: 'dot-review',    icon: '🔍', label: 'Under SK Review',    date: null },
            { dot: 'dot-pending',   icon: '🕐', label: 'Awaiting Decision',  date: null, pending: true },
        ],
        'approved': [
            { dot: 'dot-submitted', icon: '📨', label: 'Request Submitted',  date: null },
            { dot: 'dot-review',    icon: '🔍', label: 'Under SK Review',    date: null },
            { dot: 'dot-approved',  icon: '✅', label: 'Request Approved',   date: null },
        ],
        'rejected': [
            { dot: 'dot-submitted', icon: '📨', label: 'Request Submitted',  date: null },
            { dot: 'dot-review',    icon: '🔍', label: 'Under SK Review',    date: null },
            { dot: 'dot-rejected',  icon: '❌', label: 'Request Rejected',   date: null },
        ],
    };

    function buildTimeline(status, submittedDate, updatedDate) {
        const steps = timelineConfig[status] || timelineConfig['pending'];
        reqTimeline.innerHTML = '';

        steps.forEach((step, i) => {
            // Assign dates: first step = submitted, last active = updated
            let dateStr = '';
            if (i === 0) dateStr = submittedDate;
            else if (i === steps.length - 1 && !step.pending) dateStr = updatedDate;

            const item = document.createElement('div');
            item.className = 'timeline-item';
            item.innerHTML = `
                <div class="timeline-dot ${step.dot}">${step.icon}</div>
                <div class="timeline-content">
                    <div class="timeline-label">${step.label}</div>
                    ${dateStr ? `<div class="timeline-date">${dateStr}</div>` : `<div class="timeline-date" style="font-style:italic;">Pending</div>`}
                </div>
            `;
            reqTimeline.appendChild(item);
        });
    }

    function openModal(row) {
        const service   = row.dataset.service   || 'Service Request';
        const ref       = row.dataset.ref        || '—';
        const status    = row.dataset.status     || 'pending';
        const submitted = row.dataset.submitted  || '—';
        const updated   = row.dataset.updated    || '—';
        const purpose   = row.dataset.purpose    || '—';
        const officer   = row.dataset.officer    || '';
        const offDate   = row.dataset.officerDate|| '';
        const offNote   = row.dataset.officerNote|| '';
        const docs      = row.dataset.docs       || '—';

        // Header
        modalTitle.textContent   = service;
        modalRefNum.textContent  = `REF: ${ref}`;
        modalIcon.textContent    = iconMap[service] || '📋';

        // Status strip
        const badgeHtml = `<span class="req-status-badge status-${status}">${formatStatus(status)}</span>`;
        stripStatus.innerHTML  = badgeHtml;
        stripSubmitted.textContent = submitted;
        stripUpdated.textContent   = updated;
        stripDocs.textContent      = docs;

        // Purpose
        detailPurpose.textContent = purpose;

        // Timeline
        buildTimeline(status, submitted, updated);

        // SK Response
        if (officer && offNote) {
            skBlock.style.display    = 'block';
            noRespBlock.style.display = 'none';
            respOfficer.textContent  = officer;
            respDate.textContent     = offDate;
            respNote.textContent     = offNote;
        } else {
            skBlock.style.display    = 'none';
            noRespBlock.style.display = 'block';
        }

        modalOverlay.style.display  = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modalOverlay.style.display   = 'none';
        document.body.style.overflow = '';
    }

    function formatStatus(status) {
        const map = {
            'pending':      'Pending',
            'under-review': 'Under Review',
            'approved':     'Approved',
            'rejected':     'Rejected',
        };
        return map[status] || status;
    }

    // Attach to all view buttons
    document.querySelectorAll('.btn-view-req').forEach(btn => {
        btn.addEventListener('click', () => {
            const row = btn.closest('.req-row');
            if (row) openModal(row);
        });
    });

    modalClose?.addEventListener('click',  closeModal);
    modalCloseBtn?.addEventListener('click', closeModal);
    modalOverlay?.addEventListener('click', e => { if (e.target === modalOverlay) closeModal(); });
    document.addEventListener('keydown',   e => { if (e.key === 'Escape') closeModal(); });

    /* ---- PAGINATION (visual only) ---- */

    const pageNums  = document.querySelectorAll('.page-num');
    const prevBtn   = document.getElementById('prev-btn');
    const nextBtn   = document.getElementById('next-btn');
    let   currentPage = 1;
    const totalPages  = pageNums.length;

    function setPage(n) {
        currentPage = Math.max(1, Math.min(n, totalPages));
        pageNums.forEach((btn, i) => btn.classList.toggle('active', i + 1 === currentPage));
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;
    }

    pageNums.forEach((btn, i) => btn.addEventListener('click', () => setPage(i + 1)));
    prevBtn?.addEventListener('click', () => setPage(currentPage - 1));
    nextBtn?.addEventListener('click', () => setPage(currentPage + 1));

    setPage(1);
});