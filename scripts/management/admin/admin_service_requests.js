/* admin_service_requests.js */

document.addEventListener('DOMContentLoaded', () => {

    /* ---- FILTER ---- */
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

    /* ---- MODAL ---- */
    const overlay  = document.getElementById('req-modal-overlay');
    let currentId  = null;

    function openRequestModal(req) {
        currentId = req.id;

        document.getElementById('req-modal-icon').textContent     = req.icon;
        document.getElementById('req-modal-title').textContent     = req.service;
        document.getElementById('req-modal-subtitle').textContent  = `Submitted by ${req.resident}`;
        document.getElementById('req-modal-resident').textContent  = req.resident;
        document.getElementById('req-modal-contact').textContent   = req.contact;
        document.getElementById('req-modal-status').textContent    = req.status.charAt(0).toUpperCase() + req.status.slice(1);
        document.getElementById('req-modal-address').textContent   = req.address;
        document.getElementById('req-modal-date').textContent      = req.date;
        document.getElementById('req-modal-purpose').textContent   = req.purpose;
        document.getElementById('req-modal-remarks').value         = req.admin_remarks || '';

        overlay.classList.add('is-open');
    }

    function closeRequestModal() {
        overlay.classList.remove('is-open');
    }

    overlay?.addEventListener('click', e => {
        if (e.target === overlay) closeRequestModal();
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeRequestModal();
    });

    /* ---- UPDATE STATUS ---- */
    function updateStatus(status) {
        const remarks = document.getElementById('req-modal-remarks').value.trim();
        // TODO: connect to backend
        const labels = { approved: '✅ Approved', rejected: '❌ Rejected', completed: '🏁 Completed' };
        showToast(`Request #${currentId} ${labels[status]}! (placeholder)`, status === 'rejected' ? 'error' : 'success');
        closeRequestModal();
    }

    /* ---- TOAST ---- */
    function showToast(msg, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `svc-toast toast-${type}`;
        toast.textContent = msg;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3500);
    }

    // Expose to global scope
    window.openRequestModal  = openRequestModal;
    window.closeRequestModal = closeRequestModal;
    window.updateStatus      = updateStatus;
});