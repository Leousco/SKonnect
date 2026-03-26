/* admin_threads.js */

document.addEventListener('DOMContentLoaded', () => {

    /* ---- FILTER ---- */
    const searchInput    = document.getElementById('thread-search');
    const categorySelect = document.getElementById('thread-category');
    const statusSelect   = document.getElementById('thread-status');
    const prioritySelect = document.getElementById('thread-priority');
    const cards          = Array.from(document.querySelectorAll('.svc-card'));
    const noResults      = document.getElementById('no-results');

    function filterCards() {
        const query    = searchInput.value.toLowerCase().trim();
        const category = categorySelect.value;
        const status   = statusSelect.value;
        const priority = prioritySelect.value;
        let visible    = 0;

        cards.forEach(card => {
            const title    = card.dataset.title    || '';
            const author   = card.dataset.author   || '';
            const cardCat  = card.dataset.category || '';
            const cardSts  = card.dataset.status   || '';
            const cardPri  = card.dataset.priority || '';

            const matchSearch   = !query    || title.includes(query)  || author.includes(query);
            const matchCategory = category === 'all' || cardCat === category;
            const matchStatus   = status   === 'all' || cardSts === status;
            const matchPriority = priority === 'all' || cardPri === priority;

            const show = matchSearch && matchCategory && matchStatus && matchPriority;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        noResults.style.display = visible === 0 ? 'block' : 'none';
    }

    searchInput?.addEventListener('input',     filterCards);
    categorySelect?.addEventListener('change', filterCards);
    statusSelect?.addEventListener('change',   filterCards);
    prioritySelect?.addEventListener('change', filterCards);

    /* ---- MODAL ---- */
    const overlay = document.getElementById('thread-modal-overlay');
    let currentThread = null;

    function openThreadModal(thread) {
        currentThread = thread;

        document.getElementById('thread-modal-title').textContent    = thread.title;
        document.getElementById('thread-modal-subtitle').textContent = `Posted by ${thread.author}`;
        document.getElementById('thread-modal-author').textContent   = thread.author;
        document.getElementById('thread-modal-category').textContent = thread.category.charAt(0).toUpperCase() + thread.category.slice(1);
        document.getElementById('thread-modal-status').textContent   = thread.status.charAt(0).toUpperCase() + thread.status.slice(1);
        document.getElementById('thread-modal-excerpt').textContent  = thread.excerpt;
        document.getElementById('thread-modal-meta').textContent     = `📅 ${thread.date} · 💬 ${thread.comments} comments`;
        document.getElementById('thread-admin-note').value           = '';

        // Update pin/lock button labels
        document.getElementById('btn-pin').textContent  = thread.pinned  ? '📌 Unpin'   : '📌 Pin';
        document.getElementById('btn-lock').textContent = thread.locked  ? '🔓 Unlock' : '🔒 Lock';

        overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeThreadModal() {
        overlay.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    overlay?.addEventListener('click', e => { if (e.target === overlay) closeThreadModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeThreadModal(); });

    /* ---- ACTIONS ---- */
    function threadAction(action) {
        const note = document.getElementById('thread-admin-note').value.trim();
        const labels = {
            pin:    currentThread?.pinned  ? '📌 Thread unpinned!'  : '📌 Thread pinned!',
            lock:   currentThread?.locked  ? '🔓 Thread unlocked!'  : '🔒 Thread locked!',
            delete: '🗑️ Thread deleted!',
        };
        // TODO: connect to backend
        showToast(labels[action] + (note ? ` Note: "${note}"` : ''), action === 'delete' ? 'error' : 'success');
        closeThreadModal();
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
    window.openThreadModal  = openThreadModal;
    window.closeThreadModal = closeThreadModal;
    window.threadAction     = threadAction;
});