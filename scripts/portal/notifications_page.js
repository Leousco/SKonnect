/* notifications_page.js — Portal Notifications */

document.addEventListener('DOMContentLoaded', () => {

    /* ---- ELEMENTS ---- */
    const searchInput  = document.getElementById('notif-search');
    const typeSelect   = document.getElementById('notif-type');
    const readSelect   = document.getElementById('notif-read');
    const markAllBtn   = document.getElementById('mark-all-btn');
    const notifList    = document.getElementById('notif-list');
    const notifEmpty   = document.getElementById('notif-empty');
    const unreadLabel  = document.getElementById('unread-count-label');

    let items = Array.from(document.querySelectorAll('.notif-item-row'));

    /* ---- UNREAD COUNT ---- */

    function updateUnreadLabel() {
        const count = document.querySelectorAll('.notif-item-row.notif-unread').length;
        if (unreadLabel) {
            unreadLabel.textContent = count === 0 ? 'All read' : `${count} unread`;
            unreadLabel.classList.toggle('is-zero', count === 0);
        }
    }

    updateUnreadLabel();

    /* ---- FILTER ---- */

    function filterItems() {
        const query    = searchInput.value.toLowerCase().trim();
        const type     = typeSelect.value;
        const readFilter = readSelect.value;
        let   visible  = 0;

        // Re-query in case items changed
        items = Array.from(document.querySelectorAll('.notif-item-row'));

        items.forEach(item => {
            const title   = (item.dataset.title   || '').toLowerCase();
            const body    = (item.dataset.body    || '').toLowerCase();
            const itemType = item.dataset.type    || '';
            const isUnread = item.classList.contains('notif-unread');

            const matchesSearch = !query || title.includes(query) || body.includes(query);
            const matchesType   = type === 'all' || itemType === type;
            const matchesRead   =
                readFilter === 'all'    ? true :
                readFilter === 'unread' ? isUnread :
                readFilter === 'read'   ? !isUnread : true;

            const show = matchesSearch && matchesType && matchesRead;
            item.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        const showEmpty = visible === 0;
        notifEmpty.style.display   = showEmpty ? 'flex' : 'none';
        notifList.style.display    = showEmpty ? 'none' : 'flex';
    }

    searchInput.addEventListener('input',   filterItems);
    typeSelect.addEventListener('change',   filterItems);
    readSelect.addEventListener('change',   filterItems);

    /* ---- MARK AS READ (individual) ---- */

    function markAsRead(item) {
        if (!item.classList.contains('notif-unread')) return;
        item.classList.remove('notif-unread');

        // Remove unread dot
        const dot = item.querySelector('.notif-unread-dot');
        if (dot) dot.remove();

        // Remove the mark-read button (already read)
        const markBtn = item.querySelector('.mark-read-btn');
        if (markBtn) markBtn.remove();

        updateUnreadLabel();
    }

    notifList.addEventListener('click', e => {
        const markBtn = e.target.closest('.mark-read-btn');
        if (markBtn) {
            e.stopPropagation();
            const item = markBtn.closest('.notif-item-row');
            if (item) markAsRead(item);
            return;
        }
    });

    /* ---- MARK ALL READ ---- */

    markAllBtn?.addEventListener('click', () => {
        document.querySelectorAll('.notif-item-row.notif-unread').forEach(item => markAsRead(item));
    });

    /* ---- DISMISS (remove from list) ---- */

    notifList.addEventListener('click', e => {
        const dismissBtn = e.target.closest('.dismiss-btn');
        if (!dismissBtn) return;
        e.stopPropagation();

        const item = dismissBtn.closest('.notif-item-row');
        if (!item) return;

        // Animate out then remove
        item.style.transition = 'opacity 0.25s, max-height 0.3s, padding 0.3s';
        item.style.opacity    = '0';
        item.style.maxHeight  = item.offsetHeight + 'px';

        // Kick off collapse
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                item.style.maxHeight  = '0';
                item.style.padding    = '0';
                item.style.borderWidth = '0';
            });
        });

        setTimeout(() => {
            item.remove();
            updateUnreadLabel();
            filterItems();
        }, 320);
    });

    /* ---- ROW CLICK → OPEN MODAL ---- */

    notifList.addEventListener('click', e => {
        // Don't open modal if clicking a button or link
        if (e.target.closest('.notif-action-btn') || e.target.closest('.notif-link')) return;

        const row = e.target.closest('.notif-item-row');
        if (row) {
            markAsRead(row);
            openModal(row);
        }
    });

    /* ---- MODAL ---- */

    const modalOverlay  = document.getElementById('modal-overlay');
    const modalClose    = document.getElementById('modal-close');
    const modalCloseBtn = document.getElementById('modal-close-btn');
    const modalTitle    = document.getElementById('modal-notif-title');
    const modalTime     = document.getElementById('modal-notif-time');
    const modalIcon     = document.getElementById('modal-notif-icon');
    const modalTypeTag  = document.getElementById('modal-type-tag');
    const modalBodyText = document.getElementById('modal-body-text');
    const modalActionLk = document.getElementById('modal-action-link');

    const typeIconMap = {
        'service':      '✅',
        'announcement': '📣',
        'thread':       '💬',
        'system':       '🔔',
    };

    const typeTagMap = {
        'service':      { label: 'Service Update', cls: 'tag-service' },
        'announcement': { label: 'Announcement',   cls: 'tag-announcement' },
        'thread':       { label: 'Community Thread', cls: 'tag-thread' },
        'system':       { label: 'System',          cls: 'tag-system' },
    };

    function formatDatetime(isoStr) {
        if (!isoStr) return '—';
        try {
            const d = new Date(isoStr);
            return d.toLocaleString('en-PH', {
                month: 'long', day: 'numeric', year: 'numeric',
                hour: 'numeric', minute: '2-digit', hour12: true
            });
        } catch { return isoStr; }
    }

    function openModal(row) {
        const type  = row.dataset.type  || 'system';
        const title = row.dataset.title || 'Notification';
        const body  = row.dataset.body  || '—';
        const time  = row.dataset.time  || '';
        const link  = row.dataset.link  || '#';

        // Check if it was rejected service
        const isRejected = row.querySelector('.type-rejected') !== null;

        modalTitle.textContent    = title;
        modalTime.textContent     = formatDatetime(time);
        modalIcon.textContent     = isRejected ? '❌' : (typeIconMap[type] || '🔔');
        modalBodyText.textContent = body;

        // Type tag
        const tagCfg = typeTagMap[type] || { label: type, cls: 'tag-system' };
        modalTypeTag.textContent = tagCfg.label;
        modalTypeTag.className   = `notif-type-tag ${tagCfg.cls}`;

        // Action link
        if (link && link !== '#') {
            modalActionLk.href        = link;
            modalActionLk.style.display = '';
        } else {
            modalActionLk.style.display = 'none';
        }

        modalOverlay.style.display   = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modalOverlay.style.display   = 'none';
        document.body.style.overflow = '';
    }

    modalClose?.addEventListener('click',    closeModal);
    modalCloseBtn?.addEventListener('click', closeModal);
    modalOverlay?.addEventListener('click', e => { if (e.target === modalOverlay) closeModal(); });
    document.addEventListener('keydown',    e => { if (e.key === 'Escape') closeModal(); });

    /* ---- PAGINATION (visual only) ---- */

    const pageNums   = document.querySelectorAll('.page-num');
    const prevBtn    = document.getElementById('prev-btn');
    const nextBtn    = document.getElementById('next-btn');
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