/* feed_page.js — Portal Community Feed */

document.addEventListener('DOMContentLoaded', () => {

    /* ---- FILTER & SORT ELEMENTS ---- */
    const searchInput    = document.getElementById('feed-search');
    const categorySelect = document.getElementById('feed-category');
    const statusSelect   = document.getElementById('feed-status');
    const sortSelect     = document.getElementById('feed-sort');
    const cards          = Array.from(document.querySelectorAll('.feed-card'));
    const noResults      = document.getElementById('no-results');
    const grid           = document.getElementById('feed-grid');

    /* ---- FILTER ---- */

    function filterCards() {
        const query    = searchInput.value.toLowerCase().trim();
        const category = categorySelect.value;
        const status   = statusSelect.value;
        let visible    = 0;

        cards.forEach(card => {
            const title   = card.querySelector('.ann-card-title')?.textContent.toLowerCase() || '';
            const excerpt = card.querySelector('.ann-card-excerpt')?.textContent.toLowerCase() || '';
            const cardCat = card.dataset.category || '';
            const cardSts = card.dataset.status   || '';

            const matchesSearch   = !query    || title.includes(query)  || excerpt.includes(query);
            const matchesCategory = category === 'all' || cardCat === category;
            const matchesStatus   = status   === 'all' || cardSts === status;

            const show = matchesSearch && matchesCategory && matchesStatus;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        noResults.style.display = visible === 0 ? 'block' : 'none';
    }

    /* ---- SORT ---- */

    function sortCards() {
        const order = sortSelect.value;

        const sorted = [...cards].sort((a, b) => {
            if (order === 'comments') {
                const ca = parseInt(a.querySelector('.ann-card-meta span:last-child')?.textContent.replace(/\D/g, '')) || 0;
                const cb = parseInt(b.querySelector('.ann-card-meta span:last-child')?.textContent.replace(/\D/g, '')) || 0;
                return cb - ca;
            }
            const da = new Date(a.querySelector('time')?.getAttribute('datetime') || '2000-01-01');
            const db = new Date(b.querySelector('time')?.getAttribute('datetime') || '2000-01-01');
            return order === 'oldest' ? da - db : db - da;
        });

        sorted.forEach(card => grid.appendChild(card));
        filterCards();
    }

    searchInput.addEventListener('input',     filterCards);
    categorySelect.addEventListener('change', filterCards);
    statusSelect.addEventListener('change',   filterCards);
    sortSelect.addEventListener('change',     sortCards);

    /* ---- BOOKMARKS ---- */

    document.querySelectorAll('.bookmark-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            btn.classList.toggle('active');
            btn.title = btn.classList.contains('active') ? 'Remove bookmark' : 'Bookmark';
        });
    });

    /* ---- MODAL ---- */

    const submitBtn    = document.getElementById('submit-concern-btn');
    const modalOverlay = document.getElementById('modal-overlay');
    const modalClose   = document.getElementById('modal-close');
    const modalCancel  = document.getElementById('modal-cancel');
    const modalSubmit  = document.getElementById('modal-submit');

    let selectedFiles = [];

    function openModal() {
        modalOverlay.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        document.getElementById('concern-form')?.reset();
        const fl = document.getElementById('file-list');
        if (fl) fl.innerHTML = '';
        selectedFiles = [];
        clearErrors();
        setTimeout(() => document.getElementById('m-category')?.focus(), 100);
    }

    function closeModal() {
        modalOverlay.style.display = 'none';
        document.body.style.overflow = '';
    }

    submitBtn?.addEventListener('click', openModal);
    modalClose?.addEventListener('click', closeModal);
    modalCancel?.addEventListener('click', closeModal);
    modalOverlay?.addEventListener('click', e => { if (e.target === modalOverlay) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    /* ---- FORM VALIDATION ---- */

    function clearErrors() {
        document.querySelectorAll('.field-error').forEach(el => el.textContent = '');
        ['m-category', 'm-priority', 'm-subject', 'm-message'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.style.borderColor = '';
        });
    }

    function showError(fieldId, errId, msg) {
        const field = document.getElementById(fieldId);
        const err   = document.getElementById(errId);
        if (field) field.style.borderColor = '#e11d48';
        if (err)   err.textContent = msg;
    }

    function validateForm() {
        clearErrors();
        let valid = true;

        const category = document.getElementById('m-category')?.value;
        const priority = document.getElementById('m-priority')?.value;
        const subject  = document.getElementById('m-subject')?.value.trim();
        const message  = document.getElementById('m-message')?.value.trim();

        if (!category) { showError('m-category', 'err-category', 'Please select a category.'); valid = false; }
        if (!priority) { showError('m-priority', 'err-priority', 'Please select a priority.'); valid = false; }
        if (!subject)  { showError('m-subject',  'err-subject',  'Subject is required.');       valid = false; }
        else if (subject.length < 5) { showError('m-subject', 'err-subject', 'Subject must be at least 5 characters.'); valid = false; }
        if (!message)  { showError('m-message',  'err-message',  'Message is required.');       valid = false; }
        else if (message.length < 10) { showError('m-message', 'err-message', 'Message must be at least 10 characters.'); valid = false; }

        return valid;
    }

    modalSubmit?.addEventListener('click', () => {
        if (validateForm()) {
            closeModal();
            alert('Your concern has been submitted successfully!');
        }
    });

    /* ---- FILE DROP ZONE ---- */

    const dropZone  = document.getElementById('file-drop-zone');
    const fileInput = document.getElementById('m-attachments');
    const fileList  = document.getElementById('file-list');
    const browseBtn = document.getElementById('file-browse-btn');

    browseBtn?.addEventListener('click', e => { e.stopPropagation(); fileInput?.click(); });

    function renderFileList() {
        if (!fileList) return;
        fileList.innerHTML = '';
        selectedFiles.forEach((file, i) => {
            const li = document.createElement('li');
            li.className = 'file-list-item';
            li.innerHTML = `
                <span title="${file.name}">📄 ${file.name}
                    <em style="color:var(--text-muted);font-style:normal;">(${(file.size / 1024).toFixed(1)} KB)</em>
                </span>
                <button type="button" class="file-remove-btn" data-index="${i}" aria-label="Remove">&times;</button>
            `;
            fileList.appendChild(li);
        });
        fileList.querySelectorAll('.file-remove-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                selectedFiles.splice(parseInt(btn.dataset.index), 1);
                renderFileList();
            });
        });
    }

    function addFiles(files) {
        const MAX = 5 * 1024 * 1024;
        Array.from(files).forEach(file => {
            if (file.size > MAX) { alert(`"${file.name}" exceeds the 5MB limit.`); return; }
            if (!selectedFiles.find(f => f.name === file.name && f.size === file.size)) {
                selectedFiles.push(file);
            }
        });
        renderFileList();
    }

    fileInput?.addEventListener('change', () => { addFiles(fileInput.files); fileInput.value = ''; });
    dropZone?.addEventListener('dragover',  e => { e.preventDefault(); dropZone.classList.add('dragover'); });
    dropZone?.addEventListener('dragleave', ()  => dropZone.classList.remove('dragover'));
    dropZone?.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        addFiles(e.dataTransfer.files);
    });

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
    prevBtn.addEventListener('click', () => setPage(currentPage - 1));
    nextBtn.addEventListener('click', () => setPage(currentPage + 1));

    setPage(1);
});