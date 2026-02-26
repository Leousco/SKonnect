/* announcements_page.js — Portal Announcements */

document.addEventListener('DOMContentLoaded', () => {

    const searchInput   = document.getElementById('ann-search');
    const categorySelect = document.getElementById('ann-category');
    const sortSelect    = document.getElementById('ann-sort');
    const cards         = Array.from(document.querySelectorAll('.ann-card'));
    const noResults     = document.getElementById('no-results');
    const grid          = document.querySelector('.announcements-grid');

    // --- FILTER + SEARCH ---

    function filterCards() {
        const query    = searchInput.value.toLowerCase().trim();
        const category = categorySelect.value;
        let visible    = 0;

        cards.forEach(card => {
            const title   = card.querySelector('.ann-card-title')?.textContent.toLowerCase() || '';
            const excerpt = card.querySelector('.ann-card-excerpt')?.textContent.toLowerCase() || '';
            const cardCat = card.dataset.category || '';

            const matchesSearch   = !query || title.includes(query) || excerpt.includes(query);
            const matchesCategory = category === 'all' || cardCat === category;

            if (matchesSearch && matchesCategory) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        noResults.style.display = visible === 0 ? 'block' : 'none';
    }

    // --- SORT ---

    function sortCards() {
        const order = sortSelect.value;

        const sorted = [...cards].sort((a, b) => {
            if (order === 'views') {
                const va = parseInt(a.querySelector('.ann-card-meta span:last-child')?.textContent.replace(/\D/g, '')) || 0;
                const vb = parseInt(b.querySelector('.ann-card-meta span:last-child')?.textContent.replace(/\D/g, '')) || 0;
                return vb - va;
            }

            const da = new Date(a.querySelector('time')?.getAttribute('datetime') || '2000-01-01');
            const db = new Date(b.querySelector('time')?.getAttribute('datetime') || '2000-01-01');

            return order === 'oldest' ? da - db : db - da;
        });

        sorted.forEach(card => grid.appendChild(card));
        filterCards();
    }

    searchInput.addEventListener('input', filterCards);
    categorySelect.addEventListener('change', filterCards);
    sortSelect.addEventListener('change', sortCards);

    // --- BOOKMARKS ---

    document.querySelectorAll('.bookmark-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.classList.toggle('active');
            btn.title = btn.classList.contains('active') ? 'Remove bookmark' : 'Bookmark';
        });
    });

    // --- PAGINATION (visual only) ---

    const pageNums = document.querySelectorAll('.page-num');
    const prevBtn  = document.getElementById('prev-btn');
    const nextBtn  = document.getElementById('next-btn');

    let currentPage = 1;
    const totalPages = pageNums.length;

    function setPage(n) {
        currentPage = Math.max(1, Math.min(n, totalPages));
        pageNums.forEach((btn, i) => btn.classList.toggle('active', i + 1 === currentPage));
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages;
    }

    pageNums.forEach((btn, i) => btn.addEventListener('click', () => setPage(i + 1)));
    prevBtn.addEventListener('click', () => setPage(currentPage - 1));
    nextBtn.addEventListener('click', () => setPage(currentPage + 1));

    setPage(1);
});