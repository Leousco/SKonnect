document.addEventListener("DOMContentLoaded", () => {
  /* ── REFS ──────────────────────────────────────────────── */

  const tbody = document.getElementById("req-tbody");
  const noResults = document.getElementById("req-no-results");
  const countLabel = document.getElementById("req-count");

  const searchInput = document.getElementById("req-search");
  const selCategory = document.getElementById("req-category");
  const selSort = document.getElementById("req-sort");

  // Tabs
  const tabs = document.querySelectorAll(".req-tab");

  // Drawer
  const drawerOverlay = document.getElementById("req-drawer-overlay");
  const drawer = document.getElementById("req-drawer");
  const drawerClose = document.getElementById("req-drawer-close");
  const drawerTitle = document.getElementById("drawer-title");
  const drawerSubtitle = document.getElementById("drawer-subtitle");
  const drawerAvatar = document.getElementById("drawer-avatar");
  const drawerResident = document.getElementById("drawer-resident-name");
  const drawerService = document.getElementById("drawer-service");
  const drawerPurpose = document.getElementById("drawer-purpose");
  const drawerDate = document.getElementById("drawer-date");
  const drawerStatusWrap = document.getElementById("drawer-status-wrap");
  const drawerFiles = document.getElementById("drawer-files");
  const drawerResponse = document.getElementById("drawer-response");
  const drawerFooter = document.getElementById("req-drawer-footer");

  // Confirm modal
  const confirmOverlay = document.getElementById("req-confirm-overlay");
  const confirmIcon = document.getElementById("req-confirm-icon");
  const confirmTitle = document.getElementById("req-confirm-title");
  const confirmBody = document.getElementById("req-confirm-body");
  const confirmOk = document.getElementById("req-confirm-ok");
  const confirmCancel = document.getElementById("req-confirm-cancel");

  // Toast
  const toast = document.getElementById("req-toast");

  /* ── STATE ─────────────────────────────────────────────── */

  let activeTab = "all";
  let sortDir = "desc";
  let pendingAction = null;
  let activeDrawerRow = null;
  let toastTimer = null;

  /* ── TOAST ─────────────────────────────────────────────── */

  function showToast(msg, type = "info") {
    clearTimeout(toastTimer);
    toast.textContent = msg;
    toast.className = `req-toast req-toast--${type} req-toast--show`;
    toastTimer = setTimeout(
      () => toast.classList.remove("req-toast--show"),
      3400
    );
  }

  /* ── ROWS HELPER ───────────────────────────────────────── */

  function getRows() {
    return Array.from(tbody.querySelectorAll("tr"));
  }

  /* ── FILTER ────────────────────────────────────────────── */

  function applyFilters() {
    const q = searchInput.value.toLowerCase().trim();
    const category = selCategory.value;

    let visible = 0;

    getRows().forEach((row) => {
      const matchTab = activeTab === "all" || row.dataset.status === activeTab;
      const matchCat = category === "all" || row.dataset.category === category;
      const matchSearch =
        !q ||
        (row.dataset.resident || "").includes(q) ||
        (row.dataset.service || "").includes(q);

      const show = matchTab && matchCat && matchSearch;
      row.style.display = show ? "" : "none";
      if (show) visible++;
    });

    countLabel.textContent = `Showing ${visible} request${
      visible !== 1 ? "s" : ""
    }`;
    noResults.style.display = visible === 0 ? "flex" : "none";
  }

  searchInput.addEventListener("input", applyFilters);
  selCategory.addEventListener("change", applyFilters);

  /* ── TABS ──────────────────────────────────────────────── */

  tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      tabs.forEach((t) => t.classList.remove("active"));
      tab.classList.add("active");
      activeTab = tab.dataset.status;
      applyFilters();
    });
  });

  /* ── SORT ──────────────────────────────────────────────── */

  selSort.addEventListener("change", () => {
    sortDir = selSort.value === "newest" ? "desc" : "asc";
    sortRows();
  });

  document.querySelectorAll(".req-table thead th.sortable").forEach((th) => {
    th.addEventListener("click", () => {
      sortDir = sortDir === "desc" ? "asc" : "desc";
      document
        .querySelectorAll(".req-table thead th.sortable")
        .forEach((h) => h.classList.remove("sort-asc", "sort-desc"));
      th.classList.add(sortDir === "asc" ? "sort-asc" : "sort-desc");
      sortRows();
    });
  });

  function sortRows() {
    const rows = getRows();
    rows.sort((a, b) => {
      const da = new Date(a.dataset.date || 0).getTime();
      const db = new Date(b.dataset.date || 0).getTime();
      return sortDir === "desc" ? db - da : da - db;
    });
    rows.forEach((r) => tbody.appendChild(r));
    applyFilters();
  }

  /* ── DRAWER ────────────────────────────────────────────── */

  function openDrawer(row) {
    activeDrawerRow = row;

    const id = row.dataset.id;
    const resident =
      row.querySelector(".req-resident-name")?.textContent || "—";
    const initials =
      row.querySelector(".req-avatar")?.textContent?.trim() || "—";
    const service =
      row.querySelector(".req-service-badge")?.textContent?.trim() || "—";
    const purpose = row.dataset.purpose || "—";
    const dateStr = row.querySelector("time")?.textContent || "—";
    const status = row.dataset.status;
    const hasFiles = row.dataset.hasFiles === "true";
    const fileCount = parseInt(row.dataset.fileCount || "0");

    drawerTitle.textContent = resident;
    drawerSubtitle.textContent = `Request #${String(id).padStart(4, "0")}`;
    drawerAvatar.textContent = initials;
    drawerResident.textContent = resident;
    drawerService.textContent = service;
    drawerPurpose.textContent = purpose;
    drawerDate.textContent = dateStr;
    drawerResponse.value = "";

    // Status pill
    drawerStatusWrap.innerHTML = `<span class="req-status-pill status-${status}">${capitalize(
      status
    )}</span>`;

    // Files
    if (hasFiles && fileCount > 0) {
      const items = Array.from(
        { length: fileCount },
        (_, i) =>
          `<div class="drawer-file-item">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13"/></svg>
                      Attachment_${String(i + 1).padStart(2, "0")}.pdf
                  </div>`
      ).join("");
      drawerFiles.innerHTML = `<div class="drawer-files-list">${items}</div>`;
    } else {
      drawerFiles.innerHTML =
        '<p class="drawer-no-files">No attachments submitted.</p>';
    }

    // Footer buttons
    buildDrawerFooter(status, id);

    drawerOverlay.style.display = "flex";
  }

  function buildDrawerFooter(status, id) {
    drawerFooter.innerHTML = "";

    // Respond button always visible
    const respondBtn = makeDrawerBtn(
      "drawer-btn-respond",
      id,
      "respond",
      `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.127 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/></svg>Respond`
    );
    drawerFooter.appendChild(respondBtn);

    if (status === "pending") {
      drawerFooter.appendChild(
        makeDrawerBtn(
          "drawer-btn-process",
          id,
          "process",
          `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>Mark Processing`
        )
      );
    }

    if (status === "pending" || status === "processing") {
      drawerFooter.appendChild(
        makeDrawerBtn(
          "drawer-btn-approve",
          id,
          "approve",
          `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>Approve`
        )
      );
      drawerFooter.appendChild(
        makeDrawerBtn(
          "drawer-btn-decline",
          id,
          "decline",
          `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>Decline`
        )
      );
    }
  }

  function makeDrawerBtn(cls, id, action, innerHTML) {
    const btn = document.createElement("button");
    btn.className = cls;
    btn.dataset.id = id;
    btn.dataset.action = action;
    btn.innerHTML = innerHTML;
    return btn;
  }

  function closeDrawer() {
    drawerOverlay.style.display = "none";
    activeDrawerRow = null;
  }

  drawerClose.addEventListener("click", closeDrawer);
  drawerOverlay.addEventListener("click", (e) => {
    if (e.target === drawerOverlay) closeDrawer();
  });

  // View button in table
  tbody.addEventListener("click", (e) => {
    const viewBtn = e.target.closest(".req-btn-view");
    if (viewBtn) {
      const row = viewBtn.closest("tr");
      openDrawer(row);
    }
  });

  // Drawer footer buttons — delegated
  drawerFooter.addEventListener("click", (e) => {
    const btn = e.target.closest("button[data-action]");
    if (!btn) return;
    handleAction(btn.dataset.action, btn.dataset.id);
  });

  /* ── TABLE INLINE BUTTONS ──────────────────────────────── */

  tbody.addEventListener("click", (e) => {
    const processBtn = e.target.closest(".req-btn-process");
    const approveBtn = e.target.closest(".req-btn-approve");
    const declineBtn = e.target.closest(".req-btn-decline");

    if (processBtn) handleAction("process", processBtn.dataset.id);
    if (approveBtn) handleAction("approve", approveBtn.dataset.id);
    if (declineBtn) handleAction("decline", declineBtn.dataset.id);
  });

  /* ── ACTION HANDLER ────────────────────────────────────── */

  function handleAction(action, id) {
    const row = tbody.querySelector(`tr[data-id="${id}"]`);
    if (!row) return;

    const residentName =
      row.querySelector(".req-resident-name")?.textContent || "this resident";
    const serviceName =
      row.querySelector(".req-service-badge")?.textContent?.trim() ||
      "this request";

    const configs = {
      respond: {
        icon: "💬",
        title: "Send Response",
        body: `Send your response to ${residentName}?`,
        okLabel: "Send",
        okClass: "",
        onConfirm: () => {
          showToast(`Response sent to ${residentName}.`, "info");
          // TODO: POST /backend/routes/officer/respond_request.php { id, message: drawerResponse.value }
        },
      },
      process: {
        icon: "🔄",
        title: "Mark as Processing",
        body: `Mark ${residentName}'s ${serviceName} request as under review?`,
        okLabel: "Mark Processing",
        okClass: "",
        onConfirm: () => {
          updateRowStatus(row, "processing");
          showToast(`Request marked as processing.`, "info");
          // TODO: PATCH /backend/routes/officer/update_request_status.php { id, status: 'processing' }
        },
      },
      approve: {
        icon: "✅",
        title: "Approve Request",
        body: `Approve ${residentName}'s ${serviceName} request? The resident will be notified.`,
        okLabel: "Approve",
        okClass: "req-confirm-ok--approve",
        onConfirm: () => {
          updateRowStatus(row, "approved");
          showToast(`Request approved for ${residentName}.`, "success");
          // TODO: PATCH /backend/routes/officer/update_request_status.php { id, status: 'approved', message: drawerResponse.value }
        },
      },
      decline: {
        icon: "🚫",
        title: "Decline Request",
        body: `Decline ${residentName}'s ${serviceName} request? This action will notify the resident.`,
        okLabel: "Decline",
        okClass: "req-confirm-ok--decline",
        onConfirm: () => {
          updateRowStatus(row, "declined");
          showToast(`Request declined for ${residentName}.`, "warning");
          // TODO: PATCH /backend/routes/officer/update_request_status.php { id, status: 'declined', message: drawerResponse.value }
        },
      },
    };

    const cfg = configs[action];
    if (!cfg) return;

    pendingAction = cfg.onConfirm;
    confirmIcon.textContent = cfg.icon;
    confirmTitle.textContent = cfg.title;
    confirmBody.textContent = cfg.body;
    confirmOk.textContent = cfg.okLabel;
    confirmOk.className = `req-confirm-ok ${cfg.okClass}`.trim();
    confirmOverlay.style.display = "flex";
  }

  /* ── UPDATE ROW STATUS IN DOM ──────────────────────────── */

  function updateRowStatus(row, newStatus) {
    row.dataset.status = newStatus;

    // Status pill in table
    const pill = row.querySelector(".req-status-pill");
    if (pill) {
      pill.className = `req-status-pill status-${newStatus}`;
      pill.textContent = capitalize(newStatus);
    }

    // Update modal if this row is currently open
    if (activeDrawerRow === row) {
      drawerStatusWrap.innerHTML = `<span class="req-status-pill status-${newStatus}">${capitalize(
        newStatus
      )}</span>`;
      buildDrawerFooter(newStatus, row.dataset.id);
    }

    // Update tab counts
    updateTabCounts();
    applyFilters();
  }

  /* ── UPDATE TAB COUNTS ─────────────────────────────────── */

  function updateTabCounts() {
    const rows = getRows();
    const countMap = {
      all: rows.length,
      pending: 0,
      processing: 0,
      approved: 0,
      declined: 0,
    };
    rows.forEach((r) => {
      const s = r.dataset.status;
      if (s in countMap) countMap[s]++;
    });
    tabs.forEach((tab) => {
      const status = tab.dataset.status;
      const badge = tab.querySelector(".req-tab-count");
      if (badge && status in countMap) badge.textContent = countMap[status];
    });
  }

  /* ── CONFIRM MODAL ─────────────────────────────────────── */

  confirmOk.addEventListener("click", () => {
    if (typeof pendingAction === "function") pendingAction();
    closeConfirm();
    closeDrawer();
  });

  confirmCancel.addEventListener("click", closeConfirm);
  confirmOverlay.addEventListener("click", (e) => {
    if (e.target === confirmOverlay) closeConfirm();
  });

  function closeConfirm() {
    confirmOverlay.style.display = "none";
    pendingAction = null;
  }

  /* ── PAGINATION (stub) ─────────────────────────────────── */

  const prevBtn = document.getElementById("req-prev-btn");
  const nextBtn = document.getElementById("req-next-btn");
  const pageNumbers = document.getElementById("req-page-numbers");

  pageNumbers.addEventListener("click", (e) => {
    const btn = e.target.closest(".off-page-num");
    if (!btn) return;
    pageNumbers
      .querySelectorAll(".off-page-num")
      .forEach((b) => b.classList.remove("active"));
    btn.classList.add("active");
    const nums = Array.from(pageNumbers.querySelectorAll(".off-page-num"));
    const current = nums.indexOf(btn) + 1;
    prevBtn.disabled = current === 1;
    nextBtn.disabled = current === nums.length;
    // TODO: fetch page from backend
  });

  prevBtn.addEventListener("click", () =>
    pageNumbers
      .querySelector(".off-page-num.active")
      ?.previousElementSibling?.click()
  );
  nextBtn.addEventListener("click", () =>
    pageNumbers
      .querySelector(".off-page-num.active")
      ?.nextElementSibling?.click()
  );

  /* ── KEYBOARD ESC ──────────────────────────────────────── */

  document.addEventListener("keydown", (e) => {
    if (e.key !== "Escape") return;
    closeConfirm();
    closeDrawer();
  });

  /* ── HELPERS ───────────────────────────────────────────── */

  function capitalize(str) {
    return str ? str.charAt(0).toUpperCase() + str.slice(1) : str;
  }

  /* ── INIT ──────────────────────────────────────────────── */

  sortRows(); // default: newest first
  applyFilters();
});
