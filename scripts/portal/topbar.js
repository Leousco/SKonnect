
/* ---- Live Clock ---- */
(function () {
    const dateEl = document.getElementById('topbar-date');
    const timeEl = document.getElementById('topbar-time');
    if (!dateEl || !timeEl) return;

    const DAYS   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    const MONTHS = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    function tick() {
        const now = new Date();
        dateEl.textContent = `${DAYS[now.getDay()]}, ${MONTHS[now.getMonth()]} ${now.getDate()}, ${now.getFullYear()}`;
        const h   = now.getHours(), m = now.getMinutes();
        const ampm = h >= 12 ? 'PM' : 'AM';
        const hh   = h % 12 || 12;
        timeEl.textContent = `${hh}:${String(m).padStart(2,'0')} ${ampm}`;
    }
    tick();
    setInterval(tick, 1000);
})();

/* ---- Dropdown toggles ---- */
(function () {
    function setupDropdown(btnId, dropId) {
        const btn  = document.getElementById(btnId);
        const drop = document.getElementById(dropId);
        if (!btn || !drop) return;

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = btn.getAttribute('aria-expanded') === 'true';
            // Close all first
            document.querySelectorAll('.notif-dropdown, .user-dropdown').forEach(function (d) { d.classList.remove('open'); });
            document.querySelectorAll('[aria-expanded]').forEach(function (b) { b.setAttribute('aria-expanded', 'false'); });
            // Toggle this one
            if (!isOpen) {
                drop.classList.add('open');
                btn.setAttribute('aria-expanded', 'true');
            }
        });

        btn.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); btn.click(); }
        });
    }

    setupDropdown('topbar-notif-btn', 'notif-dropdown');
    setupDropdown('topbar-user-btn',  'user-dropdown');

    // Close on outside click
    document.addEventListener('click', function () {
        document.querySelectorAll('.notif-dropdown, .user-dropdown').forEach(function (d) { d.classList.remove('open'); });
        document.querySelectorAll('[aria-expanded]').forEach(function (b) { b.setAttribute('aria-expanded', 'false'); });
    });
})();