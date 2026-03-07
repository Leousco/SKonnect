/* announcements_page.js — Portal Announcements (dynamic version) */

document.addEventListener('DOMContentLoaded', () => {

    const searchInput    = document.getElementById('ann-search');
    const categorySelect = document.getElementById('ann-category');
    const sortSelect     = document.getElementById('ann-sort');
    const grid           = document.getElementById('announcements-grid');
    const noResults      = document.getElementById('no-results');
    const pageNumbersEl  = document.getElementById('page-numbers');
    const prevBtn        = document.getElementById('prev-btn');
    const nextBtn        = document.getElementById('next-btn');

    const CARDS_PER_PAGE = 6;
    let currentPage = 1;
    let allCards    = Array.from(document.querySelectorAll('.ann-card'));

    /* ── FILTER + SORT + PAGINATE ─────────────────────────── */

    function getVisibleCards() {
        const query    = searchInput.value.toLowerCase().trim();
        const category = categorySelect.value;
        const sort     = sortSelect.value;

        let filtered = allCards.filter(card => {
            const title   = card.dataset.title || '';
            const cardCat = card.dataset.category || '';
            const excerpt = card.querySelector('.ann-card-excerpt')?.textContent.toLowerCase() || '';

            const matchesSearch   = !query || title.includes(query) || excerpt.includes(query);
            const matchesCategory = category === 'all' || cardCat === category;

            return matchesSearch && matchesCategory;
        });

        // Sort
        filtered.sort((a, b) => {
            const da = new Date(a.dataset.date || '2000-01-01');
            const db = new Date(b.dataset.date || '2000-01-01');
            return sort === 'oldest' ? da - db : db - da;
        });

        return filtered;
    }

    function renderPage() {
        const visible = getVisibleCards();
        const total   = visible.length;

        noResults.style.display = total === 0 ? 'block' : 'none';

        // Hide all cards first
        allCards.forEach(c => c.style.display = 'none');

        // Calculate page slice
        const totalPages = Math.max(1, Math.ceil(total / CARDS_PER_PAGE));
        currentPage      = Math.min(currentPage, totalPages);

        const start = (currentPage - 1) * CARDS_PER_PAGE;
        const slice = visible.slice(start, start + CARDS_PER_PAGE);

        // Re-order in DOM and show
        slice.forEach(card => {
            grid.appendChild(card);   
            card.style.display = '';
        });

        renderPagination(totalPages, total);
    }

    function renderPagination(totalPages, totalItems) {
        pageNumbersEl.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.className = 'page-num' + (i === currentPage ? ' active' : '');
            btn.textContent = i;
            btn.addEventListener('click', () => { currentPage = i; renderPage(); });
            pageNumbersEl.appendChild(btn);
        }

        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalItems === 0;
    }

    function resetAndRender() {
        currentPage = 1;
        renderPage();
    }

    searchInput?.addEventListener('input',  debounce(resetAndRender, 250));
    categorySelect?.addEventListener('change', resetAndRender);
    sortSelect?.addEventListener('change',     resetAndRender);

    prevBtn?.addEventListener('click', () => { currentPage--; renderPage(); });
    nextBtn?.addEventListener('click', () => { currentPage++; renderPage(); });

    /* ── BOOKMARKS ────────────────────────────────────────── */

    document.querySelectorAll('.bookmark-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.classList.toggle('active');
            btn.title = btn.classList.contains('active') ? 'Remove bookmark' : 'Bookmark';
        });
    });

    /* ── HELPERS ──────────────────────────────────────────── */
    function debounce(fn, delay) {
        let t;
        return (...args) => { clearTimeout(t); t = setTimeout(() => fn(...args), delay); };
    }

    /* ── INITIAL RENDER ───────────────────────────────────── */
    renderPage();
});