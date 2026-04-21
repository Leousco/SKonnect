/**
 * admin_analytics.js
 * Chart.js charts — all data from analytics_stats.php
 */

document.addEventListener('DOMContentLoaded', function () {

    const API_URL = '../../../backend/routes/analytics_stats.php';

    /* ── Chart defaults ──────────────────────────────────── */
    Chart.defaults.font.family = "'Segoe UI', Tahoma, sans-serif";
    Chart.defaults.color       = '#64748b';

    const VIOLET    = '#7c3aed';
    const VIOLET_LT = '#8b5cf6';
    const AMBER     = '#f59e0b';
    const INDIGO    = '#6366f1';
    const TEAL      = '#0d9488';
    const SLATE     = '#94a3b8';
    const GREEN     = '#10b981';
    const RED       = '#ef4444';
    const PALETTE   = [VIOLET, AMBER, INDIGO, TEAL, SLATE, GREEN, RED];

    const CAT_LABELS = {
        medical:     'Medical Assist.',
        education:   'Education',
        scholarship: 'Scholarship',
        livelihood:  'Livelihood',
        assistance:  'Assistance',
        legal:       'Legal Aid',
        other:       'Others',
    };

    const MONTH_LABELS = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    /* ── Chart instances (kept for updates) ─────────────── */
    let barChart      = null;
    let donutChart    = null;
    let growthChart   = null;
    let activeChart   = null;
    let selectedYear  = new Date().getFullYear();

    /* ── Count-up helper ─────────────────────────────────── */
    function countUp(el, target, suffix = '') {
        if (!el) return;
        let current  = 0;
        const step   = Math.max(1, Math.ceil(target / (900 / 16)));
        const timer  = setInterval(() => {
            current = Math.min(current + step, target);
            el.textContent = current.toLocaleString() + suffix;
            if (current >= target) clearInterval(timer);
        }, 16);
    }

    /* ── Load data ───────────────────────────────────────── */
    function load(year) {
        fetch(`${API_URL}?year=${year}`)
            .then(r => r.json())
            .then(json => {
                if (json.status !== 'success') { console.error('Analytics API:', json.message); return; }
                const d = json.data;
                renderStatCards(d);
                renderYearFilter(d.availableYears, d.selectedYear);
                renderBarChart(d.requestsByMonth, d.selectedYear);
                renderDonutChart(d.serviceBreakdown);
                renderGrowthChart(d.growthLabels, d.growthData);
                renderActiveChart(d.activeUsers, d.inactiveUsers, d.activePct);
            })
            .catch(err => console.error('Analytics fetch failed:', err));
    }

    /* ── Stat Cards ──────────────────────────────────────── */
    function renderStatCards(d) {
        // Total users
        const totalEl = document.getElementById('stat-total-users');
        countUp(totalEl, d.totalUsers);
        const newEl = document.getElementById('stat-new-this-month');
        if (newEl) newEl.textContent = `▲ ${d.newThisMonth} this month`;

        // Total requests
        const reqEl = document.getElementById('stat-total-requests');
        countUp(reqEl, d.totalRequests);
        const reqMonthEl = document.getElementById('stat-requests-month');
        if (reqMonthEl) reqMonthEl.textContent = `▲ ${d.requestsThisMonth} this month`;

        // Top service
        const topEl = document.getElementById('stat-top-service');
        if (topEl) topEl.textContent = d.topService.name || 'N/A';
        const topCntEl = document.getElementById('stat-top-service-cnt');
        if (topCntEl) topCntEl.textContent = d.topService.cnt > 0
            ? `${d.topService.cnt} requests this month` : 'No requests this month';

        // Active users
        const activeEl = document.getElementById('stat-active-users');
        countUp(activeEl, d.activeUsers);
        const inactEl = document.getElementById('stat-inactive-users');
        if (inactEl) inactEl.textContent = `${d.inactiveUsers} inactive`;
    }

    /* ── Year filter ─────────────────────────────────────── */
    function renderYearFilter(years, selected) {
        const sel = document.getElementById('reqYearFilter');
        if (!sel || sel.options.length > 0) return; // only build once
        years.forEach(yr => {
            const opt = document.createElement('option');
            opt.value       = yr;
            opt.textContent = yr;
            opt.selected    = yr == selected;
            sel.appendChild(opt);
        });
        sel.addEventListener('change', function () {
            selectedYear = parseInt(this.value);
            load(selectedYear);
        });
    }

    /* ── Bar chart ───────────────────────────────────────── */
    function renderBarChart(data, year) {
        const currentMonth = new Date().getFullYear() == year ? new Date().getMonth() : 11;
        const colors = data.map((_, i) =>
            i <= currentMonth ? VIOLET : 'rgba(124,58,237,0.15)'
        );

        if (barChart) {
            barChart.data.datasets[0].data            = data;
            barChart.data.datasets[0].backgroundColor = colors;
            barChart.update();
            return;
        }

        barChart = new Chart(document.getElementById('requestsBarChart'), {
            type: 'bar',
            data: {
                labels: MONTH_LABELS,
                datasets: [{
                    label:           'Requests',
                    data:            data,
                    backgroundColor: colors,
                    borderRadius:    5,
                    borderSkipped:   false,
                }]
            },
            options: {
                responsive:          true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => ` ${ctx.parsed.y} requests` } }
                },
                scales: {
                    x: { grid: { display: false }, border: { display: false }, ticks: { font: { size: 11 } } },
                    y: { beginAtZero: true, border: { display: false, dash: [4,4] }, grid: { color: 'rgba(0,0,0,0.06)' }, ticks: { font: { size: 11 }, stepSize: 1 } }
                }
            }
        });
    }

    /* ── Service donut ───────────────────────────────────── */
    function renderDonutChart(breakdown) {
        const labels = breakdown.map(b => CAT_LABELS[b.category] || b.category);
        const values = breakdown.map(b => parseInt(b.cnt));
        const colors = breakdown.map((_, i) => PALETTE[i % PALETTE.length]);

        // Legend
        const legend = document.getElementById('service-legend');
        if (legend) {
            legend.innerHTML = breakdown.map((b, i) => `
                <li>
                    <span class="an-legend-dot" style="background:${PALETTE[i % PALETTE.length]}"></span>
                    ${CAT_LABELS[b.category] || b.category}
                    <strong>${b.cnt}</strong>
                </li>
            `).join('') || '<li style="color:var(--admin-text-muted);font-size:12px;">No data this month.</li>';
        }

        if (donutChart) {
            donutChart.data.labels                       = labels;
            donutChart.data.datasets[0].data             = values;
            donutChart.data.datasets[0].backgroundColor  = colors;
            donutChart.update();
            return;
        }

        if (!breakdown.length) return;

        donutChart = new Chart(document.getElementById('serviceDonutChart'), {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{ data: values, backgroundColor: colors, borderWidth: 0, hoverOffset: 6 }]
            },
            options: {
                responsive:          true,
                maintainAspectRatio: false,
                cutout:              '68%',
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed} requests` } }
                }
            }
        });
    }

    /* ── Growth line chart ───────────────────────────────── */
    function renderGrowthChart(labels, data) {
        if (!labels.length) return;

        if (growthChart) {
            growthChart.data.labels               = labels;
            growthChart.data.datasets[0].data     = data;
            growthChart.update();
            return;
        }

        growthChart = new Chart(document.getElementById('userGrowthChart'), {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label:            'Total Users',
                    data,
                    borderColor:      VIOLET_LT,
                    backgroundColor:  'rgba(124,58,237,0.08)',
                    borderWidth:      2.5,
                    pointRadius:      3,
                    pointBackgroundColor: VIOLET,
                    fill:             true,
                    tension:          0.4,
                }]
            },
            options: {
                responsive:          true,
                maintainAspectRatio: false,
                plugins: {
                    legend:  { display: false },
                    tooltip: { callbacks: { label: ctx => ` ${ctx.parsed.y} total users` } }
                },
                scales: {
                    x: { grid: { display: false }, border: { display: false }, ticks: { font: { size: 11 } } },
                    y: { beginAtZero: false, border: { display: false, dash: [4,4] }, grid: { color: 'rgba(0,0,0,0.06)' }, ticks: { font: { size: 11 } } }
                }
            }
        });
    }

    /* ── Active donut ────────────────────────────────────── */
    function renderActiveChart(active, inactive, pct) {
        // Update text
        const pctEl      = document.getElementById('active-pct');
        const activeEl   = document.getElementById('active-count');
        const inactiveEl = document.getElementById('inactive-count');

        if (pctEl)      pctEl.textContent      = pct + '%';
        if (activeEl)   countUp(activeEl,   active);
        if (inactiveEl) countUp(inactiveEl, inactive);

        if (activeChart) {
            activeChart.data.datasets[0].data = [active, inactive];
            activeChart.update();
            return;
        }

        activeChart = new Chart(document.getElementById('activeDonutChart'), {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Inactive'],
                datasets: [{
                    data:            [active, inactive],
                    backgroundColor: [GREEN, RED],
                    borderWidth:     0,
                    hoverOffset:     4,
                }]
            },
            options: {
                responsive:  false,
                cutout:      '72%',
                plugins: {
                    legend:  { display: false },
                    tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${ctx.parsed}` } }
                }
            }
        });
    }

    /* ── Init ────────────────────────────────────────────── */
    load(selectedYear);
});