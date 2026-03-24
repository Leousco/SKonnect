
document.addEventListener("DOMContentLoaded", () => {
  /* ── ELEMENT REFS ──────────────────────────────────────── */

  const tbody = document.getElementById("log-tbody");
  const noResults = document.getElementById("log-no-results");
  const countLabel = document.getElementById("log-count");

  const searchInput = document.getElementById("log-search");
  const selAction = document.getElementById("log-action-type");
  const selMod = document.getElementById("log-moderator");
  const dateFrom = document.getElementById("log-date-from");
  const dateTo = document.getElementById("log-date-to");
  const clearBtn = document.getElementById("log-clear-btn");
  const exportBtn = document.getElementById("log-export-btn");

  const prevBtn = document.getElementById("log-prev-btn");
  const nextBtn = document.getElementById("log-next-btn");
  const pageNumbers = document.getElementById("log-page-numbers");

  /* ── STATE ─────────────────────────────────────────────── */

  let sortCol = "datetime";
  let sortDir = "desc"; 

  /* ── HELPERS ───────────────────────────────────────────── */

  function getRows() {
    return Array.from(tbody.querySelectorAll("tr"));
  }

  function rowText(row) {
    // Grab searchable text from target + moderator columns
    const target = row.querySelector(".col-target")?.textContent || "";
    const mod = row.querySelector(".col-moderator")?.textContent || "";
    return (target + " " + mod).toLowerCase();
  }

  /* ── FILTER ────────────────────────────────────────────── */

  function applyFilters() {
    const q = searchInput.value.toLowerCase().trim();
    const action = selAction.value;
    const mod = selMod.value;
    const from = dateFrom.value ? new Date(dateFrom.value) : null;
    const to = dateTo.value ? new Date(dateTo.value + "T23:59:59") : null;

    let visible = 0;

    getRows().forEach((row) => {
      const matchSearch = !q || rowText(row).includes(q);
      const matchAction = action === "all" || row.dataset.action === action;
      const matchMod = mod === "all" || row.dataset.moderator === mod;

      let matchDate = true;
      if (from || to) {
        const dt = new Date(row.dataset.datetime);
        if (from && dt < from) matchDate = false;
        if (to && dt > to) matchDate = false;
      }

      const show = matchSearch && matchAction && matchMod && matchDate;
      row.style.display = show ? "" : "none";
      if (show) visible++;
    });

    countLabel.textContent = `Showing ${visible} entr${
      visible !== 1 ? "ies" : "y"
    }`;
    noResults.style.display = visible === 0 ? "flex" : "none";
  }

  searchInput.addEventListener("input", applyFilters);
  selAction.addEventListener("change", applyFilters);
  selMod.addEventListener("change", applyFilters);
  dateFrom.addEventListener("change", applyFilters);
  dateTo.addEventListener("change", applyFilters);

  /* ── CLEAR FILTERS ─────────────────────────────────────── */

  clearBtn.addEventListener("click", () => {
    searchInput.value = "";
    selAction.value = "all";
    selMod.value = "all";
    dateFrom.value = "";
    dateTo.value = "";
    applyFilters();
  });

  /* ── SORTING ───────────────────────────────────────────── */

  document.querySelectorAll(".log-table thead th.sortable").forEach((th) => {
    th.addEventListener("click", () => {
      const col = th.dataset.col;

      if (sortCol === col) {
        sortDir = sortDir === "asc" ? "desc" : "asc";
      } else {
        sortCol = col;
        sortDir = "asc";
      }

      // Update header indicators
      document.querySelectorAll(".log-table thead th.sortable").forEach((h) => {
        h.classList.remove("sort-asc", "sort-desc");
      });
      th.classList.add(sortDir === "asc" ? "sort-asc" : "sort-desc");

      sortRows(col, sortDir);
    });
  });

  function cellValue(row, col) {
    switch (col) {
      case "id":
        return parseInt(row.querySelector(".col-id")?.textContent || "0");
      case "datetime":
        return new Date(row.dataset.datetime || 0).getTime();
      case "moderator":
        return (
          row.querySelector(".log-mod-cell span")?.textContent?.toLowerCase() ||
          ""
        );
      default:
        return "";
    }
  }

  function sortRows(col, dir) {
    const rows = getRows();
    rows.sort((a, b) => {
      const va = cellValue(a, col);
      const vb = cellValue(b, col);
      if (va < vb) return dir === "asc" ? -1 : 1;
      if (va > vb) return dir === "asc" ? 1 : -1;
      return 0;
    });
    rows.forEach((r) => tbody.appendChild(r));
    applyFilters();
  }

  // Default sort: newest first
  sortRows("datetime", "desc");
  document.querySelector('[data-col="datetime"]')?.classList.add("sort-desc");

  /* ── CSV EXPORT ────────────────────────────────────────── */

  exportBtn.addEventListener("click", () => {
    const headers = [
      "#",
      "Date & Time",
      "Moderator",
      "Action",
      "Target Type",
      "Target",
      "Posted By",
      "Notes",
    ];

    const visibleRows = getRows().filter((r) => r.style.display !== "none");

    const csvRows = visibleRows.map((row) => {
      const id = row.querySelector(".col-id")?.textContent?.trim() || "";
      const date = row.querySelector(".log-date")?.textContent?.trim() || "";
      const time = row.querySelector(".log-time")?.textContent?.trim() || "";
      const mod =
        row.querySelector(".log-mod-cell span")?.textContent?.trim() || "";
      const action =
        row
          .querySelector(".log-action-badge")
          ?.textContent?.trim()
          .replace(/\s+/g, " ") || "";
      const targetType =
        row.querySelector(".log-target-type")?.textContent?.trim() || "";
      const targetName =
        row.querySelector(".log-target-name")?.textContent?.trim() || "";
      const targetUser =
        row.querySelector(".log-target-user")?.textContent?.trim() || "";
      const notes =
        row.querySelector(".log-notes-text")?.textContent?.trim() || "";

      return [
        id,
        `${date} ${time}`,
        mod,
        action,
        targetType,
        targetName,
        targetUser,
        notes,
      ]
        .map((v) => `"${v.replace(/"/g, '""')}"`)
        .join(",");
    });

    const csv = [headers.map((h) => `"${h}"`).join(","), ...csvRows].join("\n");
    const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);

    const link = document.createElement("a");
    link.href = url;
    link.download = `activity_logs_${new Date()
      .toISOString()
      .slice(0, 10)}.csv`;
    link.click();
    URL.revokeObjectURL(url);
  });

  /* ── PAGINATION (client-side stub) ─────────────────────── */

  pageNumbers.addEventListener("click", (e) => {
    const btn = e.target.closest(".mod-page-num");
    if (!btn) return;
    pageNumbers
      .querySelectorAll(".mod-page-num")
      .forEach((b) => b.classList.remove("active"));
    btn.classList.add("active");
    const nums = Array.from(pageNumbers.querySelectorAll(".mod-page-num"));
    const current = nums.indexOf(btn) + 1;
    prevBtn.disabled = current === 1;
    nextBtn.disabled = current === nums.length;
    // TODO: fetch page from backend and re-render tbody
  });

  prevBtn.addEventListener("click", () => {
    pageNumbers
      .querySelector(".mod-page-num.active")
      ?.previousElementSibling?.click();
  });

  nextBtn.addEventListener("click", () => {
    pageNumbers
      .querySelector(".mod-page-num.active")
      ?.nextElementSibling?.click();
  });

  /* ── INIT ──────────────────────────────────────────────── */
  applyFilters();
});
