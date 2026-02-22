(function () {

  const EVENT_COLORS = [
    { bg: "#dbeafe", dot: "#2563eb", text: "#1e3a8a" }, // blue
    { bg: "#dcfce7", dot: "#16a34a", text: "#14532d" }, // green
    { bg: "#fef3c7", dot: "#d97706", text: "#78350f" }, // amber
    { bg: "#fce7f3", dot: "#db2777", text: "#831843" }, // pink
    { bg: "#ede9fe", dot: "#7c3aed", text: "#4c1d95" }, // purple
    { bg: "#ffedd5", dot: "#ea580c", text: "#7c2d12" }, // orange
  ];

  const rawEvents = [
    { date: "2026-02-10", label: "Scholarship Program Opens" },
    { date: "2026-02-20", label: "Medical Assistance Deadline" },
    { date: "2026-02-22", label: "Emergency Youth Assembly" },
    { date: "2026-03-05", label: "SK Budget Review Meeting" },
    { date: "2026-03-15", label: "Community Clean-Up Drive" },
  ];

  const events = {};
  rawEvents.forEach(function (ev, i) {
    events[ev.date] = {
      label: ev.label,
      color: EVENT_COLORS[i % EVENT_COLORS.length],
    };
  });

  const MONTHS = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  const MONTHS_SHORT = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
  ];

  const today = new Date();
  let current = new Date(today.getFullYear(), today.getMonth(), 1);

  const monthYearEl = document.querySelector(".month-year");
  const datesEl = document.querySelector(".calendar-dates");
  const prevBtn = document.querySelector(".prev-month");
  const nextBtn = document.querySelector(".next-month");
  const listEl = document.getElementById("events-list");
  const emptyEl = document.getElementById("events-empty");
  const legendEl = document.getElementById("legend-events");

  function pad(n) {
    return String(n).padStart(2, "0");
  }

  function formatDate(dateStr) {
    const [y, m, d] = dateStr.split("-").map(Number);
    return `${MONTHS_SHORT[m - 1]} ${d}, ${y}`;
  }

  function daysUntil(dateStr) {
    const [y, m, d] = dateStr.split("-").map(Number);
    const target = new Date(y, m - 1, d);
    const diff = Math.round((target - today) / 86400000);
    if (diff === 0) return "Today";
    if (diff === 1) return "Tomorrow";
    if (diff < 0) return `${Math.abs(diff)}d ago`;
    return `In ${diff} days`;
  }

  function renderCalendar() {
    const year = current.getFullYear();
    const month = current.getMonth();

    monthYearEl.textContent = `${MONTHS[month]} ${year}`;
    datesEl.innerHTML = "";

    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    for (let i = 0; i < firstDay; i++) {
      const empty = document.createElement("div");
      empty.className = "cal-day empty";
      datesEl.appendChild(empty);
    }

    for (let d = 1; d <= lastDate; d++) {
      const key = `${year}-${pad(month + 1)}-${pad(d)}`;
      const isToday =
        d === today.getDate() &&
        month === today.getMonth() &&
        year === today.getFullYear();
      const ev = events[key];

      const cell = document.createElement("div");
      cell.className =
        "cal-day" + (isToday ? " today" : "") + (ev ? " event" : "");
      cell.textContent = d;

      if (ev) {
        // Color the day cell with the event's color
        if (!isToday) {
          cell.style.background = ev.color.bg;
          cell.style.color = ev.color.text;
          cell.style.fontWeight = "600";
        }
        // Colored dot indicator
        const dot = document.createElement("span");
        dot.className = "cal-event-dot";
        dot.style.background = isToday ? "white" : ev.color.dot;
        cell.appendChild(dot);
        cell.title = ev.label;
      }

      datesEl.appendChild(cell);
    }

    renderEventsList(year, month);
    renderLegend(year, month);
  }

  function renderEventsList(year, month) {
    listEl.innerHTML = "";

    const monthEvents = Object.entries(events)
      .filter(function ([key]) {
        const [y, m] = key.split("-").map(Number);
        return y === year && m - 1 === month;
      })
      .sort(function (a, b) {
        return a[0].localeCompare(b[0]);
      });

    if (monthEvents.length === 0) {
      emptyEl.style.display = "block";
      return;
    }
    emptyEl.style.display = "none";

    monthEvents.forEach(function ([dateStr, ev]) {
      const li = document.createElement("li");
      li.className = "event-item";

      const [, , d] = dateStr.split("-").map(Number);
      const isToday =
        d === today.getDate() &&
        month === today.getMonth() &&
        year === today.getFullYear();
      const isPast = new Date(dateStr) < today && !isToday;

      li.innerHTML = `
                <div class="event-color-bar" style="background:${
                  ev.color.dot
                }"></div>
                <div class="event-item-body" style="background:${ev.color.bg}">
                    <div class="event-item-top">
                        <span class="event-item-label" style="color:${
                          ev.color.text
                        }">${ev.label}</span>
                        ${
                          isToday
                            ? '<span class="event-badge today-badge">Today</span>'
                            : ""
                        }
                        ${
                          isPast
                            ? '<span class="event-badge past-badge">Past</span>'
                            : ""
                        }
                    </div>
                    <div class="event-item-meta">
                        <span class="event-item-date">${formatDate(
                          dateStr
                        )}</span>
                        <span class="event-item-countdown" style="color:${
                          ev.color.dot
                        }">${daysUntil(dateStr)}</span>
                    </div>
                </div>
            `;
      listEl.appendChild(li);
    });
  }

  function renderLegend(year, month) {
    legendEl.innerHTML = "";
    const monthEvents = Object.entries(events).filter(function ([key]) {
      const [y, m] = key.split("-").map(Number);
      return y === year && m - 1 === month;
    });
    if (monthEvents.length === 0) return;

    const title = document.createElement("span");
    title.style.cssText =
      "font-size:12px;color:var(--text-muted);margin-right:8px;";
    title.textContent = "Events:";
    legendEl.appendChild(title);

    monthEvents.forEach(function ([, ev]) {
      const item = document.createElement("div");
      item.className = "legend-item";
      item.innerHTML = `<div class="legend-dot" style="background:${ev.color.dot};border:none;"></div><span style="font-size:12px;color:var(--text-muted)">${ev.label}</span>`;
      legendEl.appendChild(item);
    });
  }

  prevBtn.addEventListener("click", function () {
    current = new Date(current.getFullYear(), current.getMonth() - 1, 1);
    renderCalendar();
  });

  nextBtn.addEventListener("click", function () {
    current = new Date(current.getFullYear(), current.getMonth() + 1, 1);
    renderCalendar();
  });

  renderCalendar();
})();
