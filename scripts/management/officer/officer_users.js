(function () {
  /* ============================================================
       HARDCODED USERS  (placeholder — replace with DB fetch later)
       ============================================================ */
  var usersData = [
    {
      id: 1,
      name: "Maria Santos",
      email: "maria.santos@email.com",
      phone: "0917-123-4567",
      address: "123 Sampaguita St., Brgy. Poblacion",
      dob: "2001-04-15",
      age: 24,
      verified: true,
      joined: "2025-01-10",
      requests: { total: 5, approved: 4, pending: 1 },
      activity: [
        {
          text: "Scholarship request <strong>approved</strong>",
          time: "Feb 20, 2026 · 10:30 AM",
          color: "dot-green",
        },
        {
          text: "Submitted <strong>medical assistance</strong> request",
          time: "Feb 15, 2026 · 2:00 PM",
          color: "",
        },
        {
          text: "Account verified by officer",
          time: "Jan 12, 2026 · 9:00 AM",
          color: "dot-slate",
        },
      ],
    },
    {
      id: 2,
      name: "Pedro Cruz",
      email: "pedro.cruz@email.com",
      phone: "0918-234-5678",
      address: "45 Rizal Ave., Brgy. Poblacion",
      dob: "2000-08-22",
      age: 25,
      verified: true,
      joined: "2025-02-03",
      requests: { total: 3, approved: 2, pending: 1 },
      activity: [
        {
          text: "<strong>Barangay Clearance</strong> request submitted",
          time: "Mar 5, 2026 · 11:00 AM",
          color: "",
        },
        {
          text: "Cert. of Residency <strong>approved</strong>",
          time: "Feb 28, 2026 · 3:00 PM",
          color: "dot-green",
        },
        {
          text: "Posted in community feed",
          time: "Feb 22, 2026 · 8:45 AM",
          color: "dot-slate",
        },
      ],
    },
    {
      id: 3,
      name: "Ana Reyes",
      email: "ana.reyes@email.com",
      phone: "0919-345-6789",
      address: "78 Mabini St., Brgy. Bagong Silang",
      dob: "2003-12-01",
      age: 22,
      verified: false,
      joined: "2025-03-18",
      requests: { total: 2, approved: 1, pending: 1 },
      activity: [
        {
          text: "Cert. of Residency request <strong>processing</strong>",
          time: "Mar 5, 2026 · 9:15 AM",
          color: "dot-coral",
        },
        {
          text: "Account registered",
          time: "Mar 18, 2025 · 10:00 AM",
          color: "dot-slate",
        },
      ],
    },
    {
      id: 4,
      name: "Jose Lim",
      email: "jose.lim@email.com",
      phone: "0920-456-7890",
      address: "12 Bonifacio St., Brgy. Poblacion",
      dob: "1999-06-14",
      age: 26,
      verified: true,
      joined: "2025-01-25",
      requests: { total: 4, approved: 3, pending: 1 },
      activity: [
        {
          text: "Indigency Cert. request <strong>flagged</strong> for review",
          time: "Mar 4, 2026 · 2:15 PM",
          color: "dot-coral",
        },
        {
          text: "<strong>Business Permit</strong> request approved",
          time: "Feb 10, 2026 · 1:00 PM",
          color: "dot-green",
        },
        {
          text: "Updated profile information",
          time: "Jan 30, 2026 · 4:30 PM",
          color: "dot-slate",
        },
      ],
    },
    {
      id: 5,
      name: "Luisa Fernandez",
      email: "luisa.fernandez@email.com",
      phone: "0921-567-8901",
      address: "55 Luna St., Brgy. Sta. Cruz",
      dob: "2005-03-28",
      age: 20,
      verified: false,
      joined: "2026-02-14",
      requests: { total: 1, approved: 0, pending: 1 },
      activity: [
        {
          text: "Medical assistance request <strong>submitted</strong>",
          time: "Feb 20, 2026 · 4:00 PM",
          color: "",
        },
        {
          text: "Account registered",
          time: "Feb 14, 2026 · 12:00 PM",
          color: "dot-slate",
        },
      ],
    },
    {
      id: 6,
      name: "Ramon dela Cruz",
      email: "ramon.delacruz@email.com",
      phone: "0922-678-9012",
      address: "99 Aguinaldo Rd., Brgy. Bagong Silang",
      dob: "1998-11-05",
      age: 27,
      verified: true,
      joined: "2024-12-01",
      requests: { total: 6, approved: 6, pending: 0 },
      activity: [
        {
          text: "Livelihood training application <strong>approved</strong>",
          time: "Mar 1, 2026 · 10:00 AM",
          color: "dot-green",
        },
        {
          text: "Commented on community announcement",
          time: "Feb 25, 2026 · 3:30 PM",
          color: "dot-slate",
        },
        {
          text: "Scholarship request <strong>approved</strong>",
          time: "Feb 10, 2026 · 9:00 AM",
          color: "dot-green",
        },
      ],
    },
    {
      id: 7,
      name: "Carla Mendoza",
      email: "carla.mendoza@email.com",
      phone: "0923-789-0123",
      address: "34 Quezon Blvd., Brgy. Poblacion",
      dob: "2004-07-19",
      age: 21,
      verified: true,
      joined: "2025-06-10",
      requests: { total: 2, approved: 2, pending: 0 },
      activity: [
        {
          text: "Cert. of Residency <strong>approved</strong>",
          time: "Feb 28, 2026 · 11:30 AM",
          color: "dot-green",
        },
        {
          text: "Account verified by officer",
          time: "Jun 12, 2025 · 2:00 PM",
          color: "dot-slate",
        },
      ],
    },
    {
      id: 8,
      name: "Eduardo Villanueva",
      email: "e.villanueva@email.com",
      phone: "0924-890-1234",
      address: "67 MacArthur Hwy., Brgy. Sta. Cruz",
      dob: "2002-02-10",
      age: 23,
      verified: false,
      joined: "2026-01-20",
      requests: { total: 0, approved: 0, pending: 0 },
      activity: [
        {
          text: "Account registered",
          time: "Jan 20, 2026 · 8:00 AM",
          color: "dot-slate",
        },
      ],
    },
  ];

  /* ============================================================
       STATE
       ============================================================ */
  var searchQuery = "";
  var filterStatus = "all";
  var filterAge = "all";
  var sortBy = "name-asc";
  var openUserId = null;

  /* ============================================================
       DOM REFS
       ============================================================ */
  var tbody = document.getElementById("usr-tbody");
  var emptyEl = document.getElementById("usr-empty");
  var countEl = document.getElementById("usr-count");
  var searchEl = document.getElementById("usr-search");
  var filterStatusEl = document.getElementById("usr-filter-status");
  var filterAgeEl = document.getElementById("usr-filter-age");
  var sortEl = document.getElementById("usr-sort");

  var statTotal = document.getElementById("stat-total");
  var statVerified = document.getElementById("stat-verified");
  var statNew = document.getElementById("stat-new");
  var statActive = document.getElementById("stat-active");

  var drawerOverlay = document.getElementById("usrDrawerOverlay");
  var drawerClose = document.getElementById("usrDrawerClose");
  var drawerAvatar = document.getElementById("drawerAvatar");
  var drawerName = document.getElementById("drawerName");
  var drawerEmail = document.getElementById("drawerEmail");
  var drawerPhone = document.getElementById("drawerPhone");
  var drawerDob = document.getElementById("drawerDob");
  var drawerAge = document.getElementById("drawerAge");
  var drawerAddress = document.getElementById("drawerAddress");
  var drawerVerified = document.getElementById("drawerVerified");
  var drawerJoined = document.getElementById("drawerJoined");
  var drawerReqSummary = document.getElementById("drawerReqSummary");
  var drawerActivity = document.getElementById("drawerActivity");

  /* ============================================================
       HELPERS
       ============================================================ */
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
  var AVATAR_COLORS = ["av-0", "av-1", "av-2", "av-3", "av-4"];

  var today = new Date();
  var currentYear = today.getFullYear();
  var currentMonth = today.getMonth();

  function initials(name) {
    return name
      .split(" ")
      .map(function (p) {
        return p[0];
      })
      .slice(0, 2)
      .join("")
      .toUpperCase();
  }

  function formatDate(dateStr) {
    var parts = dateStr.split("-").map(Number);
    return MONTHS_SHORT[parts[1] - 1] + " " + parts[2] + ", " + parts[0];
  }

  function escHtml(str) {
    return String(str)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;");
  }

  function ageGroup(age) {
    if (age >= 15 && age <= 17) return "15-17";
    if (age >= 18 && age <= 24) return "18-24";
    if (age >= 25 && age <= 30) return "25-30";
    return "other";
  }

  function isNewThisMonth(joinedStr) {
    var parts = joinedStr.split("-").map(Number);
    return parts[0] === currentYear && parts[1] - 1 === currentMonth;
  }

  /* ============================================================
       STATS
       ============================================================ */
  function updateStats() {
    statTotal.textContent = usersData.length;
    statVerified.textContent = usersData.filter(function (u) {
      return u.verified;
    }).length;
    statNew.textContent = usersData.filter(function (u) {
      return isNewThisMonth(u.joined);
    }).length;
    statActive.textContent = usersData.filter(function (u) {
      return u.requests.pending > 0;
    }).length;
  }

  /* ============================================================
       FILTER + SORT
       ============================================================ */
  function getFiltered() {
    var list = usersData.slice();

    if (searchQuery) {
      var q = searchQuery.toLowerCase();
      list = list.filter(function (u) {
        return (
          u.name.toLowerCase().indexOf(q) !== -1 ||
          u.email.toLowerCase().indexOf(q) !== -1 ||
          u.address.toLowerCase().indexOf(q) !== -1
        );
      });
    }

    if (filterStatus !== "all") {
      list = list.filter(function (u) {
        return filterStatus === "verified" ? u.verified : !u.verified;
      });
    }

    if (filterAge !== "all") {
      list = list.filter(function (u) {
        return ageGroup(u.age) === filterAge;
      });
    }

    list.sort(function (a, b) {
      if (sortBy === "name-asc") return a.name.localeCompare(b.name);
      if (sortBy === "name-desc") return b.name.localeCompare(a.name);
      if (sortBy === "date-desc") return b.joined.localeCompare(a.joined);
      if (sortBy === "date-asc") return a.joined.localeCompare(b.joined);
      return 0;
    });

    return list;
  }

  /* ============================================================
       RENDER TABLE
       ============================================================ */
  function renderTable() {
    var list = getFiltered();
    tbody.innerHTML = "";

    countEl.textContent =
      list.length + " resident" + (list.length !== 1 ? "s" : "");

    if (list.length === 0) {
      emptyEl.style.display = "block";
      return;
    }
    emptyEl.style.display = "none";

    list.forEach(function (user, i) {
      var avColor = AVATAR_COLORS[i % AVATAR_COLORS.length];

      var verifiedHtml = user.verified
        ? '<span class="usr-status-pill verified">' +
          '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>' +
          "Verified</span>"
        : '<span class="usr-status-pill unverified">' +
          '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>' +
          "Unverified</span>";

      var reqCount = user.requests.total;
      var reqBadgeClass =
        reqCount > 0 ? "usr-req-badge has-requests" : "usr-req-badge";

      var tr = document.createElement("tr");
      tr.innerHTML =
        "<td>" +
        '<div class="usr-name-cell">' +
        '<div class="usr-avatar ' +
        avColor +
        '">' +
        initials(user.name) +
        "</div>" +
        '<span class="usr-name-text">' +
        escHtml(user.name) +
        "</span>" +
        "</div>" +
        "</td>" +
        "<td>" +
        '<div class="usr-contact-cell">' +
        '<span class="usr-email">' +
        escHtml(user.email) +
        "</span>" +
        '<span class="usr-phone">' +
        escHtml(user.phone) +
        "</span>" +
        "</div>" +
        "</td>" +
        "<td>" +
        '<span class="usr-address-text" title="' +
        escHtml(user.address) +
        '">' +
        escHtml(user.address) +
        "</span>" +
        "</td>" +
        '<td><span class="usr-age-val">' +
        user.age +
        "</span></td>" +
        "<td>" +
        verifiedHtml +
        "</td>" +
        "<td>" +
        formatDate(user.joined) +
        "</td>" +
        '<td style="text-align:center"><span class="' +
        reqBadgeClass +
        '">' +
        reqCount +
        "</span></td>" +
        '<td style="text-align:center">' +
        '<button class="usr-view-btn" data-id="' +
        user.id +
        '" title="View details">' +
        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">' +
        '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>' +
        '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>' +
        "</svg>" +
        "</button>" +
        "</td>";

      tbody.appendChild(tr);
    });
  }

  /* ============================================================
       DRAWER
       ============================================================ */
  function openDrawer(id) {
    var user = null;
    for (var i = 0; i < usersData.length; i++) {
      if (usersData[i].id === id) {
        user = usersData[i];
        break;
      }
    }
    if (!user) return;
    openUserId = id;

    var avIdx = usersData.indexOf(user) % AVATAR_COLORS.length;
    drawerAvatar.textContent = initials(user.name);
    drawerAvatar.className = "usr-drawer-avatar " + AVATAR_COLORS[avIdx];
    drawerName.textContent = user.name;
    drawerEmail.textContent = user.email;
    drawerPhone.textContent = user.phone;
    drawerDob.textContent = formatDate(user.dob);
    drawerAge.textContent = user.age + " years old";
    drawerAddress.textContent = user.address;
    drawerJoined.textContent = formatDate(user.joined);

    drawerVerified.innerHTML = user.verified
      ? '<span class="usr-status-pill verified">' +
        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>' +
        "Verified</span>"
      : '<span class="usr-status-pill unverified">' +
        '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/></svg>' +
        "Unverified</span>";

    drawerReqSummary.innerHTML =
      '<div class="usr-req-stat stat-total">' +
      '<span class="usr-req-stat-num">' +
      user.requests.total +
      "</span>" +
      '<span class="usr-req-stat-lbl">Total</span>' +
      "</div>" +
      '<div class="usr-req-stat stat-approved">' +
      '<span class="usr-req-stat-num">' +
      user.requests.approved +
      "</span>" +
      '<span class="usr-req-stat-lbl">Approved</span>' +
      "</div>" +
      '<div class="usr-req-stat stat-pending">' +
      '<span class="usr-req-stat-num">' +
      user.requests.pending +
      "</span>" +
      '<span class="usr-req-stat-lbl">Pending</span>' +
      "</div>";

    drawerActivity.innerHTML = "";
    if (!user.activity.length) {
      drawerActivity.innerHTML =
        '<li style="font-size:12.5px;color:var(--off-text-muted);font-style:italic;padding:10px 0;">No activity recorded.</li>';
    } else {
      user.activity.forEach(function (act) {
        var li = document.createElement("li");
        li.className = "usr-activity-item";
        li.innerHTML =
          '<div class="usr-activity-dot ' +
          act.color +
          '"></div>' +
          '<div class="usr-activity-content">' +
          '<p class="usr-activity-text">' +
          act.text +
          "</p>" +
          '<span class="usr-activity-time">' +
          act.time +
          "</span>" +
          "</div>";
        drawerActivity.appendChild(li);
      });
    }

    drawerOverlay.classList.add("is-open");
    document.body.style.overflow = "hidden";
  }

  function closeDrawer() {
    drawerOverlay.classList.remove("is-open");
    document.body.style.overflow = "";
    openUserId = null;
  }

  /* ============================================================
       EVENT LISTENERS
       ============================================================ */
  searchEl.addEventListener("input", function () {
    searchQuery = this.value.trim();
    renderTable();
  });

  filterStatusEl.addEventListener("change", function () {
    filterStatus = this.value;
    renderTable();
  });

  filterAgeEl.addEventListener("change", function () {
    filterAge = this.value;
    renderTable();
  });

  sortEl.addEventListener("change", function () {
    sortBy = this.value;
    renderTable();
  });

  tbody.addEventListener("click", function (e) {
    var btn = e.target.closest(".usr-view-btn");
    if (!btn) return;
    openDrawer(parseInt(btn.dataset.id, 10));
  });

  drawerClose.addEventListener("click", closeDrawer);

  drawerOverlay.addEventListener("click", function (e) {
    if (e.target === drawerOverlay) closeDrawer();
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape" && drawerOverlay.classList.contains("is-open"))
      closeDrawer();
  });

  /* ============================================================
       INIT
       ============================================================ */
  updateStats();
  renderTable();
})();
