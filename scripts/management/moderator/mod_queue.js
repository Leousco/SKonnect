
 document.addEventListener('DOMContentLoaded', function () {

    const filterBtns  = document.querySelectorAll('.mq-filter-btn');
    const searchInput = document.getElementById('mq-search');
    const sortSelect  = document.getElementById('mq-sort');
    const list        = document.getElementById('mq-list');
    const emptyState  = document.getElementById('mq-empty');
    const shownCount  = document.getElementById('mq-shown');

    let activeFilter = 'all';

    /* ── FILTER BY REASON ────────────────────────────────── */
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            activeFilter = this.dataset.filter;
            applyFilters();
        });
    });

    /* ── SEARCH ──────────────────────────────────────────── */
    searchInput?.addEventListener('input', debounce(applyFilters, 250));

    /* ── SORT ────────────────────────────────────────────── */
    sortSelect?.addEventListener('change', applyFilters);

    /* ── APPLY FILTERS ───────────────────────────────────── */
    function applyFilters() {
        const query   = (searchInput?.value || '').toLowerCase().trim();
        const items   = list.querySelectorAll('.mq-item');
        let   visible = 0;

        items.forEach(item => {
            const reason     = item.dataset.reason || '';
            const text       = item.innerText.toLowerCase();
            const matchFilter = activeFilter === 'all' || reason === activeFilter;
            const matchSearch = !query || text.includes(query);

            if (matchFilter && matchSearch) {
                item.style.display = '';
                visible++;
            } else {
                item.style.display = 'none';
            }
        });

        // Show/hide empty state
        if (emptyState) emptyState.style.display = visible === 0 ? 'flex' : 'none';
        if (shownCount) shownCount.textContent = visible;
    }

    /* ── ACTION BUTTONS ──────────────────────────────────── */
    list?.addEventListener('click', function (e) {
        const btn  = e.target.closest('.mq-action-btn');
        if (!btn) return;
        e.preventDefault();

        const item = btn.closest('.mq-item');

        if (btn.classList.contains('mq-btn-resolve')) {
            if (confirm('Mark this report as resolved?')) {
                item.style.opacity   = '0';
                item.style.transform = 'translateX(20px)';
                item.style.transition = 'opacity 0.3s, transform 0.3s';
                setTimeout(() => {
                    item.remove();
                    applyFilters();
                }, 300);
            }
        }

        if (btn.classList.contains('mq-btn-delete')) {
            if (confirm('Delete this content permanently? This cannot be undone.')) {
                item.style.opacity   = '0';
                item.style.transform = 'translateX(20px)';
                item.style.transition = 'opacity 0.3s, transform 0.3s';
                setTimeout(() => {
                    item.remove();
                    applyFilters();
                }, 300);
            }
        }

        if (btn.classList.contains('mq-btn-warn')) {
            alert('Warning flow — connect to your warnings backend.');
        }

        if (btn.classList.contains('mq-btn-view')) {
            alert('View content — connect to your content view backend.');
        }
    });

    /* ── UTILITY ─────────────────────────────────────────── */
    function debounce(fn, delay) {
        let t;
        return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), delay); };
    }

    // Run once on load
    applyFilters();
});