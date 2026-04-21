/* admin_service_requests.js — connected to DB */

document.addEventListener('DOMContentLoaded', () => {

    const ACTION_URL = '../../../backend/routes/service_request_action.php';

    /* ── FILTER ────────────────────────────────────────────── */
    const searchInput    = document.getElementById('req-search');
    const categorySelect = document.getElementById('req-category');
    const statusSelect   = document.getElementById('req-status');
    const cards          = Array.from(document.querySelectorAll('.svc-card'));
    const noResults      = document.getElementById('no-results');

    function filterCards() {
        const query    = searchInput.value.toLowerCase().trim();
        const category = categorySelect.value;
        const status   = statusSelect.value;
        let visible    = 0;

        cards.forEach(card => {
            const name    = card.dataset.name    || '';
            const service = card.dataset.service || '';
            const cardCat = card.dataset.category || '';
            const cardSts = card.dataset.status   || '';

            const matchSearch   = !query    || name.includes(query) || service.includes(query);
            const matchCategory = category === 'all' || cardCat === category;
            const matchStatus   = status   === 'all' || cardSts === status;

            const show = matchSearch && matchCategory && matchStatus;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        noResults.style.display = visible === 0 ? 'block' : 'none';
    }

    searchInput?.addEventListener('input',     filterCards);
    categorySelect?.addEventListener('change', filterCards);
    statusSelect?.addEventListener('change',   filterCards);

    /* ── MODAL ─────────────────────────────────────────────── */
    const overlay = document.getElementById('req-modal-overlay');
    let currentId = null;

    function openRequestModal(req) {
        currentId = req.id;

        document.getElementById('req-modal-icon').textContent    = req.icon || '📋';
        document.getElementById('req-modal-title').textContent    = req.service;
        document.getElementById('req-modal-subtitle').textContent = `Submitted by ${req.resident}`;
        document.getElementById('req-modal-resident').textContent = req.resident;
        document.getElementById('req-modal-contact').textContent  = req.contact;
        document.getElementById('req-modal-email').textContent    = req.email || '—';
        document.getElementById('req-modal-address').textContent  = req.address;
        document.getElementById('req-modal-date').textContent     = req.date;
        document.getElementById('req-modal-purpose').textContent  = req.purpose || '—';
        document.getElementById('req-modal-remarks').value        = req.admin_remarks || '';

        const statusLabels = {
            pending:          'Pending',
            action_required:  'Action Required',
            approved:         'Approved',
            rejected:         'Rejected',
            cancelled:        'Cancelled',
        };
        document.getElementById('req-modal-status').textContent =
            statusLabels[req.status] || req.status;

        overlay.classList.add('is-open');
    }

    function closeRequestModal() {
        overlay.classList.remove('is-open');
        currentId = null;
    }

    overlay?.addEventListener('click', e => {
        if (e.target === overlay) closeRequestModal();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeRequestModal();
    });

    /* ── UPDATE STATUS → DB ─────────────────────────────────── */
    function updateStatus(action) {
        if (!currentId) return;

        const note    = document.getElementById('req-modal-remarks').value.trim();
        const buttons = document.querySelectorAll('.svc-modal-footer button');
        buttons.forEach(b => b.disabled = true);

        fetch(ACTION_URL, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({ id: currentId, action, note }),
        })
        .then(res => res.json())
        .then(json => {
            if (json.status !== 'success') {
                showToast('Error: ' + (json.message || 'Unknown error'), 'error');
                buttons.forEach(b => b.disabled = false);
                return;
            }

            const labels = {
                approved:         '✅ Approved',
                rejected:         '❌ Rejected',
                action_required:  '📋 Marked as Action Required',
            };
            showToast(`Request #${currentId} — ${labels[action] || action}`, action === 'rejected' ? 'error' : 'success');

            // Update the card in the DOM without full reload
            const card = document.getElementById(`req-card-${currentId}`);
            if (card) {
                card.dataset.status = json.new_status;

                const badgeMap = {
                    approved:        ['badge-approved',  'Approved'],
                    rejected:        ['badge-rejected',  'Rejected'],
                    action_required: ['badge-completed', 'Action Required'],
                };
                const badge = card.querySelector('.svc-badge');
                if (badge && badgeMap[json.new_status]) {
                    badge.className = `svc-badge ${badgeMap[json.new_status][0]}`;
                    badge.textContent = badgeMap[json.new_status][1];
                }
            }

            closeRequestModal();
            buttons.forEach(b => b.disabled = false);
        })
        .catch(err => {
            console.error('Update failed:', err);
            showToast('Network error. Please try again.', 'error');
            buttons.forEach(b => b.disabled = false);
        });
    }

    /* ── TOAST ──────────────────────────────────────────────── */
    function showToast(msg, type = 'success') {
        const toast = document.createElement('div');
        toast.className  = `svc-toast toast-${type}`;
        toast.textContent = msg;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3500);
    }

    /* ── AUTO-OPEN if ?id= is set ───────────────────────────── */
    const focusId = window.FOCUS_REQUEST_ID;
    if (focusId) {
        const targetCard = document.getElementById(`req-card-${focusId}`);
        if (targetCard) {
            targetCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            // highlight briefly
            targetCard.style.outline = '2.5px solid #7c3aed';
            targetCard.style.boxShadow = '0 0 0 4px rgba(124,58,237,0.15)';
            setTimeout(() => {
                targetCard.style.outline   = '';
                targetCard.style.boxShadow = '';
            }, 2500);

            // Auto-open modal for this card
            const btn = targetCard.querySelector('.btn-svc-primary');
            if (btn) btn.click();
        }
    }

    /* ── EXPOSE TO GLOBAL ───────────────────────────────────── */
    window.openRequestModal  = openRequestModal;
    window.closeRequestModal = closeRequestModal;
    window.updateStatus      = updateStatus;
});