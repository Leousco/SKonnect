/**
 * admin-dashboard.js
 * Admin Dashboard interactivity
 */

 document.addEventListener('DOMContentLoaded', function () {

    // ── Animate bar chart fills on load ─────────────────────
    const bars = document.querySelectorAll('.bar-fill');
    bars.forEach(bar => {
        const target = bar.style.width;
        bar.style.width = '0%';
        requestAnimationFrame(() => {
            setTimeout(() => { bar.style.width = target; }, 100);
        });
    });

    // ── Animate widget numbers counting up ───────────────────
    document.querySelectorAll('.widget-number').forEach(el => {
        const target = parseInt(el.textContent, 10);
        if (isNaN(target)) return;
        let start = 0;
        const duration = 800;
        const step = Math.ceil(target / (duration / 16));
        const timer = setInterval(() => {
            start = Math.min(start + step, target);
            el.textContent = start;
            if (start >= target) clearInterval(timer);
        }, 16);
    });

});