/* admin_manage_services.js */

document.addEventListener('DOMContentLoaded', () => {

    /* ---- FILTER ---- */
    const searchInput    = document.getElementById('svc-search');
    const categorySelect = document.getElementById('svc-category');
    const statusSelect   = document.getElementById('svc-status');
    const cards          = Array.from(document.querySelectorAll('.svc-card'));
    const noResults      = document.getElementById('no-results');

    function filterCards() {
        const query    = searchInput.value.toLowerCase().trim();
        const category = categorySelect.value;
        const status   = statusSelect.value;
        let visible    = 0;

        cards.forEach(card => {
            const name    = card.dataset.name     || '';
            const cardCat = card.dataset.category || '';
            const cardSts = card.dataset.status   || '';

            const matchSearch   = !query    || name.includes(query);
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
    const overlay = document.getElementById('svc-modal-overlay');

    const categoryIcons = {
        medical:     '🏥',
        education:   '🎓',
        scholarship: '🏅',
        livelihood:  '🛠️',
    };

    function openAddModal() {
        document.getElementById('modal-title').textContent    = 'Add Service';
        document.getElementById('modal-icon').textContent     = '📋';
        document.getElementById('serviceId').value            = '';
        document.getElementById('serviceName').value          = '';
        document.getElementById('serviceCategory').value      = 'medical';
        document.getElementById('serviceDescription').value   = '';
        document.getElementById('serviceEligibility').value   = '';
        document.getElementById('serviceTime').value          = '';
        document.getElementById('serviceRequirements').value  = '';
        document.getElementById('serviceStatus').value        = 'active';
        clearErrors();
        overlay.classList.add('is-open');
    }

    function openEditModal(service) {
        document.getElementById('modal-title').textContent    = 'Edit Service';
        document.getElementById('modal-icon').textContent     = categoryIcons[service.category] || '📋';
        document.getElementById('serviceId').value            = service.id;
        document.getElementById('serviceName').value          = service.name;
        document.getElementById('serviceCategory').value      = service.category;
        document.getElementById('serviceDescription').value   = service.description;
        document.getElementById('serviceEligibility').value   = service.eligibility;
        document.getElementById('serviceTime').value          = service.processing_time;
        document.getElementById('serviceRequirements').value  = service.requirements;
        document.getElementById('serviceStatus').value        = service.status;
        clearErrors();
        overlay.classList.add('is-open');
    }

    function closeModal() {
        overlay.classList.remove('is-open');
    }

    // Close on overlay click
    overlay?.addEventListener('click', e => {
        if (e.target === overlay) closeModal();
    });

    // Close on Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeModal();
    });

    // Update modal icon when category changes
    document.getElementById('serviceCategory')?.addEventListener('change', function () {
        document.getElementById('modal-icon').textContent = categoryIcons[this.value] || '📋';
    });

    /* ---- VALIDATION ---- */
    function clearErrors() {
        document.querySelectorAll('.svc-field-error').forEach(el => el.textContent = '');
        document.getElementById('serviceName')?.classList.remove('is-error');
    }

    function validateService() {
        clearErrors();
        let valid = true;
        const name = document.getElementById('serviceName').value.trim();
        if (!name) {
            document.getElementById('err-name').textContent = 'Service name is required.';
            document.getElementById('serviceName').classList.add('is-error');
            valid = false;
        }
        return valid;
    }

    /* ---- SAVE ---- */
    function saveService() {
        if (!validateService()) return;
        const id = document.getElementById('serviceId').value;
        // TODO: connect to backend
        showToast(id ? '✏️ Service updated! (placeholder)' : '✅ Service added! (placeholder)', 'success');
        closeModal();
    }

    /* ---- DELETE ---- */
    function deleteService(id, name) {
        if (confirm(`Delete "${name}"? This cannot be undone.`)) {
            // TODO: connect to backend
            showToast(`🗑️ "${name}" deleted! (placeholder)`, 'error');
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

    // Expose to global scope (called from PHP onclick)
    window.openAddModal  = openAddModal;
    window.openEditModal = openEditModal;
    window.closeModal    = closeModal;
    window.saveService   = saveService;
    window.deleteService = deleteService;
});