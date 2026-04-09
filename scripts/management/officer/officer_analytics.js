/**
 * officer_analytics.js
 * scripts/management/officer/officer_analytics.js
 *
 * Renders all analytics charts and populates dynamic sections.
 * Uses Chart.js (loaded via CDN in the PHP page).
 *
 * Data is declared as JS objects here — replace with a fetch()
 * call to your backend once the API is ready.
 * TODO: GET /backend/routes/officer/analytics.php?period=month|quarter|year
 */

 document.addEventListener('DOMContentLoaded', () => {

    /* ── PALETTE (matches officer CSS vars) ────────────────── */
    const C = {
        primary    : '#2d7d9a',
        primaryLt  : '#d6edf5',
        green      : '#16a34a',
        greenLt    : '#dcfce7',
        coral      : '#c2410c',
        coralLt    : '#ffedd5',
        violet     : '#7c3aed',
        violetLt   : '#ede9fe',
        slate      : '#4f6eb4',
        slateLt    : '#e0e9f8',
        amber      : '#d97706',
        amberLt    : '#fef3c7',
        red        : '#e11d48',
        redLt      : '#fee2e2',
        border     : '#c8dfe8',
        muted      : '#7a96a6',
        dark       : '#1a2e3b',
    };

    /* ── SAMPLE DATA PER PERIOD ────────────────────────────── */
    /* Replace these objects with your API response shape.      */

    const DATA = {
        month: {
            period: 'Mar 2026',
            kpi: { totalRequests: 42, approvalRate: '91%', avgDays: '3.4', announcements: 7 },
            spark: { pending: 8, processing: 6, approved: 24, declined: 4 },
            // Daily request volume for the month (28 days shown as weekly buckets)
            volume: {
                labels: ['Mar 1','Mar 5','Mar 9','Mar 13','Mar 17','Mar 21','Mar 25','Mar 27'],
                approved:  [3, 5, 4, 6, 3, 2, 1, 0],
                declined:  [0, 1, 0, 1, 0, 1, 1, 0],
                pending:   [2, 1, 2, 0, 1, 1, 1, 0],
            },
            serviceBreakdown: [
                { key: 'clearance',   label: 'Barangay Clearance',    count: 12 },
                { key: 'residency',   label: 'Cert. of Residency',    count: 7  },
                { key: 'medical',     label: 'Medical / Dental',      count: 7  },
                { key: 'indigency',   label: 'Indigency Certificate', count: 5  },
                { key: 'education',   label: 'Educational Support',   count: 5  },
                { key: 'scholarship', label: 'Scholarship Program',   count: 3  },
                { key: 'livelihood',  label: 'Livelihood Support',    count: 2  },
                { key: 'business',    label: 'Business Permit',       count: 1  },
            ],
            events: { upcoming: 3, past: 5, total: 8, monthlyLabels: ['Jan','Feb','Mar'], monthlyCounts: [2,3,3] },
            announcements: { published: 3, drafts: 2, archived: 2 },
            services: [
                { name: 'Medical Assistance',  category: 'medical',     status: 'active',   requests: 7 },
                { name: 'Educational Support', category: 'education',   status: 'active',   requests: 5 },
                { name: 'Scholarship Program', category: 'scholarship', status: 'active',   requests: 3 },
                { name: 'Livelihood Support',  category: 'livelihood',  status: 'active',   requests: 2 },
                { name: 'Dental Assistance',   category: 'medical',     status: 'active',   requests: 0 },
                { name: 'Skills Training',     category: 'livelihood',  status: 'inactive', requests: 0 },
            ],
            activity: [
                { icon: 'green',  type: 'approve',  text: 'Approved request from <strong>Maria Santos</strong> — Medical Assistance',       time: 'Mar 27, 2026 · 8:02 AM' },
                { icon: 'cyan',   type: 'announce', text: 'Published announcement: <strong>Community Clean-up Drive</strong>',               time: 'Mar 27, 2026 · 7:45 AM' },
                { icon: 'slate',  type: 'event',    text: 'Created event: <strong>Barangay Assembly — April 5</strong>',                    time: 'Mar 26, 2026 · 4:30 PM' },
                { icon: 'amber',  type: 'process',  text: 'Marked <strong>Roberto Gomez</strong>s Livelihood request as Processing',        time: 'Mar 26, 2026 · 2:15 PM' },
                { icon: 'green',  type: 'approve',  text: 'Approved request from <strong>Carlo Mendoza</strong> — Educational Support',      time: 'Mar 25, 2026 · 11:00 AM' },
                { icon: 'indigo', type: 'service',  text: 'Activated service: <strong>Skills Training</strong>',                            time: 'Mar 24, 2026 · 9:20 AM' },
                { icon: 'amber',  type: 'decline',  text: 'Declined request from <strong>Ana Cruz</strong> — Dental Assistance',            time: 'Mar 23, 2026 · 3:40 PM' },
                { icon: 'cyan',   type: 'announce', text: 'Saved draft: <strong>Youth Sports Fest 2026</strong>',                           time: 'Mar 22, 2026 · 10:05 AM' },
            ],
        },

        quarter: {
            period: 'Q1 2026',
            kpi: { totalRequests: 118, approvalRate: '89%', avgDays: '3.8', announcements: 14 },
            spark: { pending: 12, processing: 9, approved: 84, declined: 13 },
            volume: {
                labels: ['Jan W1','Jan W2','Jan W3','Jan W4','Feb W1','Feb W2','Feb W3','Feb W4','Mar W1','Mar W2','Mar W3','Mar W4'],
                approved:  [6,7,8,5,9,10,8,6,7,8,5,5],
                declined:  [1,1,2,0,1,2,1,1,0,1,1,1],
                pending:   [2,1,1,2,1,0,1,1,2,1,1,1],
            },
            serviceBreakdown: [
                { key: 'clearance',   label: 'Barangay Clearance',    count: 34 },
                { key: 'residency',   label: 'Cert. of Residency',    count: 22 },
                { key: 'medical',     label: 'Medical / Dental',      count: 20 },
                { key: 'indigency',   label: 'Indigency Certificate', count: 14 },
                { key: 'education',   label: 'Educational Support',   count: 13 },
                { key: 'scholarship', label: 'Scholarship Program',   count: 8  },
                { key: 'livelihood',  label: 'Livelihood Support',    count: 5  },
                { key: 'business',    label: 'Business Permit',       count: 2  },
            ],
            events: { upcoming: 3, past: 11, total: 14, monthlyLabels: ['Jan','Feb','Mar'], monthlyCounts: [4,7,3] },
            announcements: { published: 8, drafts: 3, archived: 3 },
            services: [
                { name: 'Medical Assistance',  category: 'medical',     status: 'active',   requests: 20 },
                { name: 'Educational Support', category: 'education',   status: 'active',   requests: 13 },
                { name: 'Scholarship Program', category: 'scholarship', status: 'active',   requests: 8  },
                { name: 'Livelihood Support',  category: 'livelihood',  status: 'active',   requests: 5  },
                { name: 'Dental Assistance',   category: 'medical',     status: 'active',   requests: 2  },
                { name: 'Skills Training',     category: 'livelihood',  status: 'inactive', requests: 0  },
            ],
            activity: [
                { icon: 'green',  type: 'approve',  text: 'Approved <strong>34</strong> Barangay Clearance requests this quarter',           time: 'Q1 2026 summary' },
                { icon: 'cyan',   type: 'announce', text: 'Published <strong>8</strong> announcements across Events, Programs, and Notices', time: 'Q1 2026 summary' },
                { icon: 'slate',  type: 'event',    text: 'Managed <strong>14</strong> community events this quarter',                       time: 'Q1 2026 summary' },
                { icon: 'amber',  type: 'decline',  text: '<strong>13</strong> requests declined — primarily scholarship eligibility issues', time: 'Q1 2026 summary' },
            ],
        },

        year: {
            period: 'CY 2026',
            kpi: { totalRequests: 118, approvalRate: '89%', avgDays: '3.8', announcements: 14 },
            spark: { pending: 12, processing: 9, approved: 84, declined: 13 },
            volume: {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                approved:  [26,30,28,0,0,0,0,0,0,0,0,0],
                declined:  [4, 5, 4, 0,0,0,0,0,0,0,0,0],
                pending:   [4, 4, 4, 0,0,0,0,0,0,0,0,0],
            },
            serviceBreakdown: [
                { key: 'clearance',   label: 'Barangay Clearance',    count: 34 },
                { key: 'residency',   label: 'Cert. of Residency',    count: 22 },
                { key: 'medical',     label: 'Medical / Dental',      count: 20 },
                { key: 'indigency',   label: 'Indigency Certificate', count: 14 },
                { key: 'education',   label: 'Educational Support',   count: 13 },
                { key: 'scholarship', label: 'Scholarship Program',   count: 8  },
                { key: 'livelihood',  label: 'Livelihood Support',    count: 5  },
                { key: 'business',    label: 'Business Permit',       count: 2  },
            ],
            events: { upcoming: 3, past: 11, total: 14, monthlyLabels: ['Jan','Feb','Mar'], monthlyCounts: [4,7,3] },
            announcements: { published: 8, drafts: 3, archived: 3 },
            services: [
                { name: 'Medical Assistance',  category: 'medical',     status: 'active',   requests: 20 },
                { name: 'Educational Support', category: 'education',   status: 'active',   requests: 13 },
                { name: 'Scholarship Program', category: 'scholarship', status: 'active',   requests: 8  },
                { name: 'Livelihood Support',  category: 'livelihood',  status: 'active',   requests: 5  },
                { name: 'Dental Assistance',   category: 'medical',     status: 'active',   requests: 2  },
                { name: 'Skills Training',     category: 'livelihood',  status: 'inactive', requests: 0  },
            ],
            activity: [
                { icon: 'green',  type: 'approve',  text: 'Approved <strong>84</strong> requests across all service types',                  time: 'YTD 2026' },
                { icon: 'cyan',   type: 'announce', text: 'Published <strong>14</strong> announcements year-to-date',                        time: 'YTD 2026' },
                { icon: 'slate',  type: 'event',    text: 'Hosted <strong>14</strong> community events so far this year',                    time: 'YTD 2026' },
                { icon: 'amber',  type: 'process',  text: 'Average processing time improved from <strong>4.4d → 3.4d</strong>',             time: 'YTD 2026' },
            ],
        },
    };

    /* ── STATE ─────────────────────────────────────────────── */

    let activePeriod  = 'month';
    let chartVolume   = null;
    let chartEvents   = null;
    let chartAnn      = null;

    /* ── CHART.JS GLOBAL DEFAULTS ──────────────────────────── */

    Chart.defaults.font.family   = "'Poppins', sans-serif";
    Chart.defaults.font.size     = 11;
    Chart.defaults.color         = C.muted;
    Chart.defaults.plugins.legend.display = false;

    /* ── RENDER ALL ────────────────────────────────────────── */

    function render(period) {
        const d = DATA[period];

        updateKPIs(d);
        renderVolumeChart(d);
        renderServiceBars(d);
        renderEventsSection(d);
        renderAnnouncementsDonut(d);
        renderServicesList(d);
        renderActivity(d);

        document.getElementById('an-volume-period').textContent = d.period;
    }

    /* ── KPIs ──────────────────────────────────────────────── */

    function updateKPIs(d) {
        setKPI('total-requests', d.kpi.totalRequests);
        setKPI('approval-rate',  d.kpi.approvalRate);
        setKPI('avg-days',       d.kpi.avgDays);
        setKPI('announcements',  d.kpi.announcements);

        setKPI('spark-pending',    d.spark.pending);
        setKPI('spark-processing', d.spark.processing);
        setKPI('spark-approved',   d.spark.approved);
        setKPI('spark-declined',   d.spark.declined);
    }

    function setKPI(key, val) {
        document.querySelectorAll(`[data-kpi="${key}"]`).forEach(el => {
            // Preserve inner HTML for elements that have child spans (e.g. .widget-unit)
            const unit = el.querySelector('.widget-unit');
            if (unit) {
                el.childNodes[0].textContent = val;
            } else {
                el.textContent = val;
            }
        });
    }

    /* ── VOLUME LINE CHART ─────────────────────────────────── */

    function renderVolumeChart(d) {
        const ctx = document.getElementById('chart-volume').getContext('2d');
        if (chartVolume) chartVolume.destroy();

        chartVolume = new Chart(ctx, {
            type: 'line',
            data: {
                labels: d.volume.labels,
                datasets: [
                    {
                        label: 'Approved',
                        data: d.volume.approved,
                        borderColor: C.green,
                        backgroundColor: C.greenLt + '55',
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        tension: 0.4,
                        fill: true,
                    },
                    {
                        label: 'Pending',
                        data: d.volume.pending,
                        borderColor: C.coral,
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [5, 3],
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        tension: 0.4,
                    },
                    {
                        label: 'Declined',
                        data: d.volume.declined,
                        borderColor: C.red,
                        backgroundColor: 'transparent',
                        borderWidth: 1.5,
                        borderDash: [3, 3],
                        pointRadius: 2,
                        pointHoverRadius: 4,
                        tension: 0.4,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: { boxWidth: 10, padding: 12, font: { size: 11 } },
                    },
                    tooltip: { mode: 'index', intersect: false },
                },
                scales: {
                    x: {
                        grid: { color: C.border },
                        ticks: { font: { size: 10 }, maxRotation: 0 },
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: C.border },
                        ticks: { stepSize: 2, font: { size: 10 } },
                    },
                },
            },
        });
    }

    /* ── SERVICE HORIZONTAL BARS ───────────────────────────── */

    function renderServiceBars(d) {
        const container = document.getElementById('an-bar-service');
        container.innerHTML = '';

        const max = Math.max(...d.serviceBreakdown.map(s => s.count), 1);

        d.serviceBreakdown.forEach(s => {
            const pct = Math.round((s.count / max) * 100);
            const row = document.createElement('div');
            row.className = 'an-bar-row';
            row.innerHTML = `
                <span class="an-bar-label" title="${s.label}">${s.label}</span>
                <div class="an-bar-track">
                    <div class="an-bar-fill bar-${s.key}" style="width:${pct}%"></div>
                </div>
                <span class="an-bar-count">${s.count}</span>`;
            container.appendChild(row);
        });
    }

    /* ── EVENTS SECTION ────────────────────────────────────── */

    function renderEventsSection(d) {
        const grid = document.getElementById('an-events-grid');
        grid.innerHTML = `
            <div class="an-events-stat stat-upcoming">
                <span class="an-events-stat-num">${d.events.upcoming}</span>
                <span class="an-events-stat-lbl">Upcoming</span>
            </div>
            <div class="an-events-stat stat-past">
                <span class="an-events-stat-num">${d.events.past}</span>
                <span class="an-events-stat-lbl">Past</span>
            </div>
            <div class="an-events-stat stat-total">
                <span class="an-events-stat-num">${d.events.total}</span>
                <span class="an-events-stat-lbl">Total</span>
            </div>`;

        const ctx = document.getElementById('chart-events').getContext('2d');
        if (chartEvents) chartEvents.destroy();

        chartEvents = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: d.events.monthlyLabels,
                datasets: [{
                    label: 'Events',
                    data: d.events.monthlyCounts,
                    backgroundColor: C.primary,
                    borderRadius: 5,
                    borderSkipped: false,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { tooltip: { callbacks: { label: ctx => ` ${ctx.raw} event${ctx.raw !== 1 ? 's' : ''}` } } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                    y: {
                        beginAtZero: true,
                        grid: { color: C.border },
                        ticks: { stepSize: 1, font: { size: 10 } },
                    },
                },
            },
        });
    }

    /* ── ANNOUNCEMENTS DONUT ───────────────────────────────── */

    function renderAnnouncementsDonut(d) {
        const { published, drafts, archived } = d.announcements;
        const ctx = document.getElementById('chart-announcements').getContext('2d');
        if (chartAnn) chartAnn.destroy();

        chartAnn = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Published', 'Drafts', 'Archived'],
                datasets: [{
                    data: [published, drafts, archived],
                    backgroundColor: [C.green, C.primary, C.muted],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 6,
                }],
            },
            options: {
                responsive: false,
                cutout: '68%',
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.label}: ${ctx.raw}`,
                        },
                    },
                },
            },
        });

        const legend = document.getElementById('an-ann-legend');
        const rows = [
            { label: 'Published', count: published, color: C.green   },
            { label: 'Drafts',    count: drafts,    color: C.primary  },
            { label: 'Archived',  count: archived,  color: C.muted    },
        ];

        legend.innerHTML = rows.map(r => `
            <div class="an-legend-row">
                <span class="an-legend-dot" style="background:${r.color}"></span>
                <span class="an-legend-label">${r.label}</span>
                <span class="an-legend-count">${r.count}</span>
            </div>`).join('');
    }

    /* ── SERVICES LIST ─────────────────────────────────────── */

    const svcIcons = {
        medical:     `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>`,
        education:   `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84 51.39 51.39 0 0 0-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"/></svg>`,
        scholarship: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497"/></svg>`,
        livelihood:  `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63"/></svg>`,
    };

    function renderServicesList(d) {
        const list = document.getElementById('an-services-list');
        list.innerHTML = d.services.map(svc => `
            <div class="an-service-row">
                <div class="an-service-icon svc-icon-${svc.category}">
                    ${svcIcons[svc.category] || ''}
                </div>
                <div class="an-service-info">
                    <p class="an-service-name">${svc.name}</p>
                    <p class="an-service-requests">${svc.requests} request${svc.requests !== 1 ? 's' : ''} this period</p>
                </div>
                <span class="an-service-status ${svc.status}">
                    ${svc.status === 'active'
                        ? `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>Active`
                        : `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/></svg>Inactive`}
                </span>
            </div>`).join('');
    }

    /* ── ACTIVITY FEED ─────────────────────────────────────── */

    const activityIcons = {
        approve:  `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>`,
        decline:  `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>`,
        process:  `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>`,
        announce: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>`,
        event:    `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5"/></svg>`,
        service:  `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>`,
    };

    function renderActivity(d) {
        const feed = document.getElementById('an-activity-feed');
        feed.innerHTML = d.activity.map(a => `
            <li class="an-activity-item">
                <div class="an-activity-icon icon-${a.icon}">
                    ${activityIcons[a.type] || activityIcons.event}
                </div>
                <div class="an-activity-body">
                    <p class="an-activity-text">${a.text}</p>
                    <span class="an-activity-time">${a.time}</span>
                </div>
            </li>`).join('');
    }

    /* ── PERIOD TABS ───────────────────────────────────────── */

    document.querySelectorAll('.an-period-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.an-period-tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            activePeriod = tab.dataset.period;
            render(activePeriod);
        });
    });

    /* ── EXPORT (stub) ─────────────────────────────────────── */

    document.getElementById('an-export-btn').addEventListener('click', () => {
        const d = DATA[activePeriod];
        const lines = [
            `SKonnect Officer Analytics Report — ${d.period}`,
            ``,
            `KPIs`,
            `Total Requests,${d.kpi.totalRequests}`,
            `Approval Rate,${d.kpi.approvalRate}`,
            `Avg Processing Time,${d.kpi.avgDays} days`,
            `Announcements,${d.kpi.announcements}`,
            ``,
            `Requests by Status`,
            `Pending,${d.spark.pending}`,
            `Processing,${d.spark.processing}`,
            `Approved,${d.spark.approved}`,
            `Declined,${d.spark.declined}`,
            ``,
            `Requests by Service Type`,
            ...d.serviceBreakdown.map(s => `${s.label},${s.count}`),
            ``,
            `Events`,
            `Upcoming,${d.events.upcoming}`,
            `Past,${d.events.past}`,
            `Total,${d.events.total}`,
            ``,
            `Announcements`,
            `Published,${d.announcements.published}`,
            `Drafts,${d.announcements.drafts}`,
            `Archived,${d.announcements.archived}`,
        ];

        const blob = new Blob([lines.join('\n')], { type: 'text/csv;charset=utf-8;' });
        const url  = URL.createObjectURL(blob);
        const a    = document.createElement('a');
        a.href     = url;
        a.download = `officer_analytics_${activePeriod}_${new Date().toISOString().slice(0,10)}.csv`;
        a.click();
        URL.revokeObjectURL(url);
        // TODO: Replace with POST /backend/routes/officer/export_analytics.php for server-side PDF/Excel
    });

    /* ── INIT ──────────────────────────────────────────────── */

    render(activePeriod);
});