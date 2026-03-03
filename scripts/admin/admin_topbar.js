(function() {
    function updateClock() {
        const now = new Date();
        const dateEl = document.getElementById('admin-date');
        const timeEl = document.getElementById('admin-time');
        if (dateEl) dateEl.textContent = now.toLocaleDateString('en-US', { weekday:'short', month:'short', day:'numeric', year:'numeric' });
        if (timeEl) timeEl.textContent = now.toLocaleTimeString('en-US', { hour:'2-digit', minute:'2-digit', second:'2-digit' });
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Dropdown toggles
    function setupDropdown(btnId, dropdownId) {
        const btn = document.getElementById(btnId);
        const dd  = document.getElementById(dropdownId);
        if (!btn || !dd) return;
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const isOpen = dd.classList.contains('open');
            document.querySelectorAll('.admin-notif-dropdown.open, .admin-user-dropdown.open').forEach(el => el.classList.remove('open'));
            document.querySelectorAll('[aria-expanded="true"]').forEach(el => el.setAttribute('aria-expanded','false'));
            if (!isOpen) {
                dd.classList.add('open');
                btn.setAttribute('aria-expanded','true');
            }
        });
        btn.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); btn.click(); }
        });
    }

    setupDropdown('admin-notif-btn', 'admin-notif-dropdown');
    setupDropdown('admin-user-btn', 'admin-user-dropdown');

    document.addEventListener('click', function() {
        document.querySelectorAll('.admin-notif-dropdown.open, .admin-user-dropdown.open').forEach(el => el.classList.remove('open'));
        document.querySelectorAll('[aria-expanded="true"]').forEach(el => el.setAttribute('aria-expanded','false'));
    });
})();