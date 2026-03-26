/**
 * admin_analytics.js
 * Chart.js charts + stat count-up animation
 */

document.addEventListener('DOMContentLoaded', function () {

    // ── Shared chart defaults ─────────────────────────────
    Chart.defaults.font.family = "'Segoe UI', Tahoma, sans-serif";
    Chart.defaults.color = '#64748b';

    const VIOLET = '#7c3aed';
    const VIOLET_LT = '#8b5cf6';
    const AMBER  = '#f59e0b';
    const INDIGO = '#6366f1';
    const TEAL   = '#0d9488';
    const SLATE  = '#94a3b8';
    const GREEN  = '#10b981';
    const RED    = '#ef4444';

    // ── Count-up animation ────────────────────────────────
    document.querySelectorAll('.an-stat-value[data-target]').forEach(el => {
        const target = parseInt(el.dataset.target, 10);
        if (isNaN(target)) return;
        let current = 0;
        const duration = 900;
        const step = Math.ceil(target / (duration / 16));
        const timer = setInterval(() => {
            current = Math.min(current + step, target);
            el.textContent = current.toLocaleString();
            if (current >= target) clearInterval(timer);
        }, 16);
    });

    // ── 1. Requests Per Month — Bar Chart ─────────────────
    const barData = {
        2026: [8, 14, 19, 11, 17, 24, 0, 0, 0, 0, 0, 0],
        2025: [5, 9,  12, 8,  15, 20, 18, 22, 16, 14, 19, 25],
    };

    const barLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    const barChart = new Chart(document.getElementById('requestsBarChart'), {
        type: 'bar',
        data: {
            labels: barLabels,
            datasets: [{
                label: 'Requests',
                data: barData[2026],
                backgroundColor: barLabels.map((_, i) => i < 6 ? VIOLET : 'rgba(124,58,237,0.15)'),
                borderRadius: 5,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.y} requests`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: { font: { size: 11 } }
                },
                y: {
                    beginAtZero: true,
                    border: { display: false, dash: [4, 4] },
                    grid: { color: 'rgba(0,0,0,0.06)' },
                    ticks: { font: { size: 11 }, stepSize: 5 }
                }
            }
        }
    });

    document.getElementById('reqYearFilter').addEventListener('change', function () {
        const year = parseInt(this.value, 10);
        barChart.data.datasets[0].data = barData[year] || barData[2026];
        barChart.data.datasets[0].backgroundColor = barData[year].map((v, i) =>
            (year === 2026 && i >= 6) ? 'rgba(124,58,237,0.15)' : VIOLET
        );
        barChart.update();
    });

    // ── 2. Service Type Donut ─────────────────────────────
    new Chart(document.getElementById('serviceDonutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Scholarship', 'Medical Assist.', 'Livelihood', 'Legal Aid', 'Others'],
            datasets: [{
                data: [18, 11, 7, 4, 2],
                backgroundColor: [VIOLET, AMBER, INDIGO, TEAL, SLATE],
                borderWidth: 0,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.parsed} requests`
                    }
                }
            }
        }
    });

    // ── 3. User Growth — Line Chart ───────────────────────
    new Chart(document.getElementById('userGrowthChart'), {
        type: 'line',
        data: {
            labels: ['Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb'],
            datasets: [{
                label: 'Total Users',
                data: [256, 263, 271, 279, 287, 298, 307, 316, 324, 333, 340, 348],
                borderColor: VIOLET_LT,
                backgroundColor: 'rgba(124,58,237,0.08)',
                borderWidth: 2.5,
                pointRadius: 3,
                pointBackgroundColor: VIOLET,
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.y} total users`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: { font: { size: 11 } }
                },
                y: {
                    beginAtZero: false,
                    min: 240,
                    border: { display: false, dash: [4, 4] },
                    grid: { color: 'rgba(0,0,0,0.06)' },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });

    // ── 4. Active vs Inactive Donut ───────────────────────
    new Chart(document.getElementById('activeDonutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Inactive'],
            datasets: [{
                data: [327, 21],
                backgroundColor: [GREEN, RED],
                borderWidth: 0,
                hoverOffset: 4,
            }]
        },
        options: {
            responsive: false,
            cutout: '72%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.parsed}`
                    }
                }
            }
        }
    });

});