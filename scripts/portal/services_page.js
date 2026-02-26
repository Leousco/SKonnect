/* services_page.js — Portal Services */

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
        let   visible  = 0;

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

    searchInput.addEventListener('input',     filterCards);
    categorySelect.addEventListener('change', filterCards);
    statusSelect.addEventListener('change',   filterCards);

    /* ---- MODAL ---- */

    const modalOverlay = document.getElementById('modal-overlay');
    const modalClose   = document.getElementById('modal-close');
    const modalCancel  = document.getElementById('modal-cancel');
    const modalSubmit  = document.getElementById('modal-submit');
    const modalTitle   = document.getElementById('modal-title');
    const modalIcon    = document.getElementById('modal-svc-icon');
    const sumElig      = document.getElementById('sum-eligibility');
    const sumProc      = document.getElementById('sum-processing');
    const sumReqs      = document.getElementById('sum-requirements');

    let selectedFiles = [];

    function openModal(btn) {
        // Populate from data attributes
        const service      = btn.dataset.service      || 'Service Request';
        const icon         = btn.dataset.icon         || '📋';
        const eligibility  = btn.dataset.eligibility  || '—';
        const processing   = btn.dataset.processing   || '—';
        const requirements = btn.dataset.requirements || '—';

        modalTitle.textContent = service;
        modalIcon.textContent  = icon;
        sumElig.textContent    = eligibility;
        sumProc.textContent    = processing;
        sumReqs.textContent    = requirements;

        modalOverlay.style.display  = 'flex';
        document.body.style.overflow = 'hidden';

        document.getElementById('svc-form')?.reset();
        const fl = document.getElementById('file-list');
        if (fl) fl.innerHTML = '';
        selectedFiles = [];
        clearErrors();

        setTimeout(() => document.getElementById('r-name')?.focus(), 100);
    }

    function closeModal() {
        modalOverlay.style.display   = 'none';
        document.body.style.overflow = '';
    }

    // Attach open to each request button
    document.querySelectorAll('.svc-request-btn:not(:disabled)').forEach(btn => {
        btn.addEventListener('click', () => openModal(btn));
    });

    modalClose?.addEventListener('click',  closeModal);
    modalCancel?.addEventListener('click', closeModal);
    modalOverlay?.addEventListener('click', e => { if (e.target === modalOverlay) closeModal(); });
    document.addEventListener('keydown',   e => { if (e.key === 'Escape') closeModal(); });

    /* ---- VALIDATION ---- */

    function clearErrors() {
        document.querySelectorAll('.field-error').forEach(el => el.textContent = '');
        ['r-name', 'r-contact', 'r-address', 'r-purpose'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.style.borderColor = '';
        });
        const dz = document.getElementById('file-drop-zone');
        if (dz) dz.style.borderColor = '';
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

        const name    = document.getElementById('r-name')?.value.trim();
        const contact = document.getElementById('r-contact')?.value.trim();
        const address = document.getElementById('r-address')?.value.trim();
        const purpose = document.getElementById('r-purpose')?.value.trim();
        const agree   = document.getElementById('r-agree')?.checked;

        if (!name) {
            showError('r-name', 'err-name', 'Full name is required.');
            valid = false;
        }

        if (!contact) {
            showError('r-contact', 'err-contact', 'Contact number is required.');
            valid = false;
        } else if (!/^(09|\+639)\d{9}$/.test(contact.replace(/\s/g, ''))) {
            showError('r-contact', 'err-contact', 'Enter a valid PH mobile number (e.g. 09XX XXX XXXX).');
            valid = false;
        }

        if (!address) {
            showError('r-address', 'err-address', 'Home address is required.');
            valid = false;
        }

        if (!purpose) {
            showError('r-purpose', 'err-purpose', 'Please describe the purpose of your request.');
            valid = false;
        } else if (purpose.length < 20) {
            showError('r-purpose', 'err-purpose', 'Please provide more detail (at least 20 characters).');
            valid = false;
        }

        if (selectedFiles.length === 0) {
            const dz  = document.getElementById('file-drop-zone');
            const err = document.getElementById('err-docs');
            if (dz)  dz.style.borderColor  = '#e11d48';
            if (err) err.textContent = 'Please upload at least one required document.';
            valid = false;
        }

        if (!agree) {
            const err = document.getElementById('err-agree');
            if (err) err.textContent = 'You must confirm the acknowledgement to proceed.';
            valid = false;
        }

        return valid;
    }

    modalSubmit?.addEventListener('click', () => {
        if (validateForm()) {
            closeModal();
            // Replace with actual form submit / fetch
            alert('Your service request has been submitted successfully! You will be notified once reviewed.');
        }
    });

    /* ---- FILE DROP ZONE ---- */

    const dropZone  = document.getElementById('file-drop-zone');
    const fileInput = document.getElementById('r-docs');
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
});