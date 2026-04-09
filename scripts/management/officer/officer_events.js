(function () {
  /* ============================================================
       HARDCODED EVENTS (placeholder — replace with DB fetch later)
       ============================================================ */
  var eventsData = [
    {
      id: 1,
      title: "Scholarship Program Opens",
      date: "2026-02-10",
      time: "08:00",
      location: "Barangay Hall, Quezon City",
      description:
        "Annual scholarship program for SK youth members. Bring 2x2 ID photos and school enrollment proof.",
    },
    {
      id: 2,
      title: "Medical Assistance Deadline",
      date: "2026-02-20",
      time: "17:00",
      location: "SK Office, 2nd Floor Barangay Hall",
      description:
        "Last day to submit medical assistance requests for the first quarter. No extensions will be granted.",
    },
    {
      id: 3,
      title: "Emergency Youth Assembly",
      date: "2026-02-22",
      time: "14:00",
      location: "Barangay Covered Court",
      description:
        "Emergency assembly to discuss youth welfare programs and upcoming community projects for Q1 2026.",
    },
    {
      id: 4,
      title: "SK Budget Review Meeting",
      date: "2026-03-05",
      time: "10:00",
      location: "Conference Room, Barangay Hall",
      description:
        "Quarterly budget review meeting for all SK officers. Bring updated financial reports and program proposals.",
    },
    {
      id: 5,
      title: "Community Clean-Up Drive",
      date: "2026-03-15",
      time: "07:00",
      location: "Poblacion Street & Surrounding Areas",
      description:
        "Barangay-wide clean-up drive. Volunteers should wear appropriate clothing. Gloves and tools will be provided.",
    },
    {
      id: 6,
      title: "Youth Sports Fest",
      date: "2026-04-10",
      time: "08:00",
      location: "Barangay Sports Complex",
      description:
        "Annual sports festival open to all SK youth aged 15-30. Registration required. Events include basketball, volleyball, and track.",
    },
    {
      id: 7,
      title: "Livelihood Training Program",
      date: "2026-04-22",
      time: "09:00",
      location: "Barangay Skills Center",
      description:
        "Free livelihood training on basic entrepreneurship, handicraft, and food processing. Open to all residents.",
    },
  ];

  var nextId = 8;
  var activeFilter = "all";
  var pendingDeleteId = null;
  var viewingId = null;

  /* ============================================================
       DOM REFS
       ============================================================ */
  var calDatesEl = document.getElementById("cal-dates");
  var monthYearEl = document.querySelector(".evmgmt-month-year");
  var prevBtn = document.querySelector(".prev-month");
  var nextBtn = document.querySelector(".next-month");
  var eventListEl = document.getElementById("event-list");
  var listEmptyEl = document.getElementById("list-empty");

  // Stats
  var statTotal = document.getElementById("stat-num-total");
  var statUpcoming = document.getElementById("stat-num-upcoming");
  var statMonth = document.getElementById("stat-num-month");
  var statPast = document.getElementById("stat-num-past");

  // Add/Edit Modal
  var eventModal = document.getElementById("eventModal");
  var modalTitle = document.getElementById("modalTitle");
  var editIndexEl = document.getElementById("editIndex");
  var evTitle = document.getElementById("ev-title");
  var evDate = document.getElementById("ev-date");
  var evTime = document.getElementById("ev-time");
  var evLocation = document.getElementById("ev-location");
  var evDesc = document.getElementById("ev-desc");
  var errTitle = document.getElementById("err-title");
  var errDate = document.getElementById("err-date");

  // View Modal
  var viewModal = document.getElementById("viewModal");
  var viewModalBody = document.getElementById("viewModalBody");

  // Delete Modal
  var deleteModal = document.getElementById("deleteModal");
  var deleteEventName = document.getElementById("deleteEventName");

  /* ============================================================
       HELPERS
       ============================================================ */
  var MONTHS = [
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
  var MONTHS_SHORT = [
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

  var today = new Date();
  today.setHours(0, 0, 0, 0);
  var current = new Date(today.getFullYear(), today.getMonth(), 1);

  function pad(n) {
    return String(n).padStart(2, "0");
  }

  function parseDateStr(dateStr) {
    var parts = dateStr.split("-").map(Number);
    return new Date(parts[0], parts[1] - 1, parts[2]);
  }

  function formatDateDisplay(dateStr) {
    var d = parseDateStr(dateStr);
    return (
      MONTHS_SHORT[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear()
    );
  }

  function formatTime(timeStr) {
    if (!timeStr) return null;
    var parts = timeStr.split(":");
    var h = parseInt(parts[0], 10);
    var m = parts[1];
    var ampm = h >= 12 ? "PM" : "AM";
    h = h % 12 || 12;
    return h + ":" + m + " " + ampm;
  }

  function daysUntil(dateStr) {
    var d = parseDateStr(dateStr);
    var diff = Math.round((d - today) / 86400000);
    if (diff === 0) return "Today";
    if (diff === 1) return "Tomorrow";
    if (diff < 0) return Math.abs(diff) + "d ago";
    return "In " + diff + " days";
  }

  function isPast(dateStr) {
    return parseDateStr(dateStr) < today;
  }

  function isToday(dateStr) {
    var d = parseDateStr(dateStr);
    return d.getTime() === today.getTime();
  }

  function isSameMonth(dateStr, year, month) {
    var parts = dateStr.split("-").map(Number);
    return parts[0] === year && parts[1] - 1 === month;
  }

  /* ============================================================
       STATS
       ============================================================ */
  function updateStats() {
    var now = today;
    var total = eventsData.length;
    var upcoming = eventsData.filter(function (e) {
      return !isPast(e.date) && !isToday(e.date);
    }).length;
    var thisMonth = eventsData.filter(function (e) {
      var d = parseDateStr(e.date);
      return (
        d.getFullYear() === now.getFullYear() && d.getMonth() === now.getMonth()
      );
    }).length;
    var past = eventsData.filter(function (e) {
      return isPast(e.date);
    }).length;

    statTotal.textContent = total;
    statUpcoming.textContent = upcoming;
    statMonth.textContent = thisMonth;
    statPast.textContent = past;
  }

  /* ============================================================
       CALENDAR
       ============================================================ */
  function renderCalendar() {
    var year = current.getFullYear();
    var month = current.getMonth();

    monthYearEl.textContent = MONTHS[month] + " " + year;
    calDatesEl.innerHTML = "";

    var firstDay = new Date(year, month, 1).getDay();
    var lastDate = new Date(year, month + 1, 0).getDate();

    // Build lookup: date string -> events[]
    var lookup = {};
    eventsData.forEach(function (ev) {
      if (isSameMonth(ev.date, year, month)) {
        if (!lookup[ev.date]) lookup[ev.date] = [];
        lookup[ev.date].push(ev);
      }
    });

    for (var i = 0; i < firstDay; i++) {
      var empty = document.createElement("div");
      empty.className = "ecal-day empty";
      calDatesEl.appendChild(empty);
    }

    for (var d = 1; d <= lastDate; d++) {
      var key = year + "-" + pad(month + 1) + "-" + pad(d);
      var todayFlag =
        d === today.getDate() &&
        month === today.getMonth() &&
        year === today.getFullYear();
      var evList = lookup[key] || [];

      var cell = document.createElement("div");
      var classes = ["ecal-day"];
      if (todayFlag) classes.push("today");
      if (evList.length) {
        classes.push("has-event");
        if (isPast(key) && !todayFlag) classes.push("past-event");
      }
      cell.className = classes.join(" ");
      cell.textContent = d;

      if (evList.length) {
        var dot = document.createElement("span");
        dot.className = "evmgmt-cal-dot";
        cell.appendChild(dot);
        cell.title = evList
          .map(function (e) {
            return e.title;
          })
          .join("\n");
        // Clicking a calendar event day opens first event's view
        (function (evItem) {
          cell.addEventListener("click", function () {
            openViewModal(evItem.id);
          });
        })(evList[0]);
      }

      calDatesEl.appendChild(cell);
    }
  }

  /* ============================================================
       EVENT LIST
       ============================================================ */
  function renderEventList() {
    eventListEl.innerHTML = "";

    var filtered = eventsData.filter(function (ev) {
      if (activeFilter === "upcoming") return !isPast(ev.date);
      if (activeFilter === "past") return isPast(ev.date);
      return true;
    });

    // Sort: upcoming first by date, then past in reverse
    filtered.sort(function (a, b) {
      var pa = isPast(a.date),
        pb = isPast(b.date);
      if (!pa && !pb) return a.date.localeCompare(b.date);
      if (pa && pb) return b.date.localeCompare(a.date);
      return pa ? 1 : -1;
    });

    if (filtered.length === 0) {
      listEmptyEl.style.display = "block";
      return;
    }
    listEmptyEl.style.display = "none";

    filtered.forEach(function (ev) {
      var past = isPast(ev.date);
      var todayEv = isToday(ev.date);
      var d = parseDateStr(ev.date);

      var badge = "";
      if (todayEv) {
        badge = '<span class="evmgmt-badge evmgmt-badge-today">Today</span>';
      } else if (past) {
        badge = '<span class="evmgmt-badge evmgmt-badge-past">Past</span>';
      } else {
        badge =
          '<span class="evmgmt-badge evmgmt-badge-upcoming">Upcoming</span>';
      }

      var timeMeta = ev.time
        ? '<span class="evmgmt-meta-chip"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>' +
          formatTime(ev.time) +
          "</span>"
        : "";

      var locationMeta = ev.location
        ? '<span class="evmgmt-meta-chip"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>' +
          escHtml(ev.location) +
          "</span>"
        : "";

      var li = document.createElement("li");
      li.className = "evmgmt-event-item" + (past ? " is-past" : "");
      li.dataset.id = ev.id;
      li.innerHTML =
        '<div class="evmgmt-event-color-bar"></div>' +
        '<div class="evmgmt-event-body">' +
        '<div class="evmgmt-date-badge">' +
        '<span class="evmgmt-date-day">' +
        d.getDate() +
        "</span>" +
        '<span class="evmgmt-date-mon">' +
        MONTHS_SHORT[d.getMonth()] +
        "</span>" +
        "</div>" +
        '<div class="evmgmt-event-info">' +
        '<div class="evmgmt-event-title-row">' +
        '<span class="evmgmt-event-name" title="' +
        escHtml(ev.title) +
        '">' +
        escHtml(ev.title) +
        "</span>" +
        badge +
        "</div>" +
        '<div class="evmgmt-event-meta">' +
        timeMeta +
        locationMeta +
        '<span class="evmgmt-countdown">' +
        daysUntil(ev.date) +
        "</span>" +
        "</div>" +
        "</div>" +
        '<div class="evmgmt-event-actions">' +
        '<button class="evmgmt-action-btn btn-view" data-id="' +
        ev.id +
        '" title="View details">' +
        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>' +
        "</button>" +
        '<button class="evmgmt-action-btn btn-edit" data-id="' +
        ev.id +
        '" title="Edit event">' +
        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/></svg>' +
        "</button>" +
        '<button class="evmgmt-action-btn btn-delete" data-id="' +
        ev.id +
        '" title="Delete event">' +
        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>' +
        "</button>" +
        "</div>" +
        "</div>";

      eventListEl.appendChild(li);
    });
  }

  /* ============================================================
       ESCAPE HELPER
       ============================================================ */
  function escHtml(str) {
    return String(str)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;");
  }

  /* ============================================================
       FIND EVENT BY ID
       ============================================================ */
  function findById(id) {
    return (
      eventsData.find(function (e) {
        return e.id === id;
      }) || null
    );
  }

  /* ============================================================
       ADD / EDIT MODAL
       ============================================================ */
  function openAddModal() {
    modalTitle.textContent = "Add New Event";
    editIndexEl.value = "";
    evTitle.value = "";
    evDate.value = "";
    evTime.value = "";
    evLocation.value = "";
    evDesc.value = "";
    clearErrors();
    openModal(eventModal);
  }

  function openEditModal(id) {
    var ev = findById(id);
    if (!ev) return;
    modalTitle.textContent = "Edit Event";
    editIndexEl.value = id;
    evTitle.value = ev.title;
    evDate.value = ev.date;
    evTime.value = ev.time || "";
    evLocation.value = ev.location || "";
    evDesc.value = ev.description || "";
    clearErrors();
    closeModal(viewModal);
    openModal(eventModal);
  }

  function clearErrors() {
    errTitle.textContent = "";
    errDate.textContent = "";
    evTitle.classList.remove("is-error");
    evDate.classList.remove("is-error");
  }

  function validateForm() {
    var valid = true;
    clearErrors();
    if (!evTitle.value.trim()) {
      errTitle.textContent = "Event title is required.";
      evTitle.classList.add("is-error");
      valid = false;
    }
    if (!evDate.value) {
      errDate.textContent = "Date is required.";
      evDate.classList.add("is-error");
      valid = false;
    }
    return valid;
  }

  function saveEvent() {
    if (!validateForm()) return;

    var idVal = editIndexEl.value;
    var eventObj = {
      title: evTitle.value.trim(),
      date: evDate.value,
      time: evTime.value || "",
      location: evLocation.value.trim(),
      description: evDesc.value.trim(),
    };

    if (idVal) {
      // Edit
      var idx = eventsData.findIndex(function (e) {
        return e.id === parseInt(idVal, 10);
      });
      if (idx !== -1) {
        eventObj.id = parseInt(idVal, 10);
        eventsData[idx] = eventObj;
      }
    } else {
      // Add
      eventObj.id = nextId++;
      eventsData.push(eventObj);
    }

    closeModal(eventModal);
    refresh();
  }

  /* ============================================================
       VIEW MODAL
       ============================================================ */
  function openViewModal(id) {
    var ev = findById(id);
    if (!ev) return;
    viewingId = id;

    var timeHtml = ev.time
      ? '<li class="evmgmt-view-detail-item"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg><span><strong>Time:</strong> ' +
        formatTime(ev.time) +
        "</span></li>"
      : "";
    var locationHtml = ev.location
      ? '<li class="evmgmt-view-detail-item"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg><span><strong>Location:</strong> ' +
        escHtml(ev.location) +
        "</span></li>"
      : "";
    var descHtml = ev.description
      ? '<div class="evmgmt-view-desc">' + escHtml(ev.description) + "</div>"
      : "";

    viewModalBody.innerHTML =
      '<p class="evmgmt-view-title">' +
      escHtml(ev.title) +
      "</p>" +
      '<ul class="evmgmt-view-detail-list">' +
      '<li class="evmgmt-view-detail-item"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg><span><strong>Date:</strong> ' +
      formatDateDisplay(ev.date) +
      ' &nbsp;<em style="color:#d97706;font-size:11px;font-weight:600;">' +
      daysUntil(ev.date) +
      "</em></span></li>" +
      timeHtml +
      locationHtml +
      "</ul>" +
      descHtml;

    openModal(viewModal);
  }

  /* ============================================================
       DELETE MODAL
       ============================================================ */
  function openDeleteModal(id) {
    var ev = findById(id);
    if (!ev) return;
    pendingDeleteId = id;
    deleteEventName.textContent = '"' + ev.title + '"';
    openModal(deleteModal);
  }

  function confirmDelete() {
    if (pendingDeleteId === null) return;
    eventsData = eventsData.filter(function (e) {
      return e.id !== pendingDeleteId;
    });
    pendingDeleteId = null;
    closeModal(deleteModal);
    refresh();
  }

  /* ============================================================
       MODAL OPEN / CLOSE HELPERS
       ============================================================ */
  function openModal(el) {
    el.classList.add("is-open");
    document.body.style.overflow = "hidden";
  }

  function closeModal(el) {
    el.classList.remove("is-open");
    // Re-enable scroll only if no other modals open
    var anyOpen = document.querySelector(".evmgmt-modal-overlay.is-open");
    if (!anyOpen) document.body.style.overflow = "";
  }

  /* ============================================================
       REFRESH (re-render everything)
       ============================================================ */
  function refresh() {
    updateStats();
    renderCalendar();
    renderEventList();
  }

  /* ============================================================
       EVENT DELEGATION
       ============================================================ */
  document
    .getElementById("openAddModal")
    .addEventListener("click", openAddModal);

  document.getElementById("closeModal").addEventListener("click", function () {
    closeModal(eventModal);
  });
  document.getElementById("cancelModal").addEventListener("click", function () {
    closeModal(eventModal);
  });
  document.getElementById("saveEvent").addEventListener("click", saveEvent);

  document
    .getElementById("closeViewModal")
    .addEventListener("click", function () {
      closeModal(viewModal);
    });
  document
    .getElementById("closeViewModalBtn")
    .addEventListener("click", function () {
      closeModal(viewModal);
    });
  document
    .getElementById("editFromView")
    .addEventListener("click", function () {
      if (viewingId !== null) openEditModal(viewingId);
    });

  document
    .getElementById("closeDeleteModal")
    .addEventListener("click", function () {
      closeModal(deleteModal);
    });
  document
    .getElementById("cancelDelete")
    .addEventListener("click", function () {
      closeModal(deleteModal);
    });
  document
    .getElementById("confirmDelete")
    .addEventListener("click", confirmDelete);

  // Click outside modal to close
  [eventModal, viewModal, deleteModal].forEach(function (overlay) {
    overlay.addEventListener("click", function (e) {
      if (e.target === overlay) closeModal(overlay);
    });
  });

  // Event list: delegated view/edit/delete clicks
  eventListEl.addEventListener("click", function (e) {
    var btn = e.target.closest(".evmgmt-action-btn");
    if (!btn) return;
    var id = parseInt(btn.dataset.id, 10);
    if (btn.classList.contains("btn-view")) openViewModal(id);
    if (btn.classList.contains("btn-edit")) openEditModal(id);
    if (btn.classList.contains("btn-delete")) openDeleteModal(id);
  });

  // Filter buttons
  document.querySelectorAll(".evmgmt-filter-btn").forEach(function (btn) {
    btn.addEventListener("click", function () {
      document.querySelectorAll(".evmgmt-filter-btn").forEach(function (b) {
        b.classList.remove("active");
      });
      btn.classList.add("active");
      activeFilter = btn.dataset.filter;
      renderEventList();
    });
  });

  // Calendar nav
  prevBtn.addEventListener("click", function () {
    current = new Date(current.getFullYear(), current.getMonth() - 1, 1);
    renderCalendar();
  });
  nextBtn.addEventListener("click", function () {
    current = new Date(current.getFullYear(), current.getMonth() + 1, 1);
    renderCalendar();
  });

  // Keyboard: Escape closes any open modal
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      [eventModal, viewModal, deleteModal].forEach(function (m) {
        if (m.classList.contains("is-open")) closeModal(m);
      });
    }
  });

  /* ============================================================
       INIT
       ============================================================ */
  refresh();
})();
