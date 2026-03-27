/**
 * mod_feed.js
 * scripts/management/moderator/mod_feed.js
 *
 * Handles: search/filter/sort, Lock/Flag/Remove actions,
 * confirm modal, toast notifications, and pagination.
 */

document.addEventListener("DOMContentLoaded", () => {
  /* ── ELEMENT REFS ──────────────────────────────────────── */

  const grid = document.getElementById("mod-feed-grid");
  const noResults = document.getElementById("mod-no-results");
  const countLabel = document.getElementById("mod-feed-count");

  const searchInput = document.getElementById("mod-feed-search");
  const selCategory = document.getElementById("mod-feed-category");
  const selStatus = document.getElementById("mod-feed-status");
  const selPriority = document.getElementById("mod-feed-priority");
  const selSort = document.getElementById("mod-feed-sort");

  const overlay = document.getElementById("mod-confirm-overlay");
  const confirmIcon = document.getElementById("mod-confirm-icon");
  const confirmTitle = document.getElementById("mod-confirm-title");
  const confirmBody = document.getElementById("mod-confirm-body");
  const confirmOk = document.getElementById("mod-confirm-ok");
  const confirmCancel = document.getElementById("mod-confirm-cancel");

  const toast = document.getElementById("mod-toast");

  /* ── FILTER & SORT ─────────────────────────────────────── */

  function getCards() {
    return Array.from(grid.querySelectorAll(".mod-feed-card"));
  }

  function applyFilters() {
    const q = searchInput.value.toLowerCase().trim();
    const category = selCategory.value;
    const status = selStatus.value;
    const priority = selPriority.value;

    let visible = 0;

    getCards().forEach((card) => {
      const titleEl = card.querySelector(".mod-feed-title");
      const excerptEl = card.querySelector(".mod-feed-excerpt");
      const text = (
        (titleEl?.textContent || "") +
        " " +
        (excerptEl?.textContent || "")
      ).toLowerCase();

      const matchSearch = !q || text.includes(q);
      const matchCategory =
        category === "all" || card.dataset.category === category;
      const matchStatus = status === "all" || card.dataset.status === status;
      const matchPriority =
        priority === "all" || card.dataset.priority === priority;

      const show = matchSearch && matchCategory && matchStatus && matchPriority;
      card.style.display = show ? "" : "none";
      if (show) visible++;
    });

    countLabel.textContent = `Showing ${visible} thread${
      visible !== 1 ? "s" : ""
    }`;
    noResults.style.display = visible === 0 ? "flex" : "none";
  }

  function applySort() {
    const order = selSort.value;
    const cards = getCards();

    cards.sort((a, b) => {
      if (order === "newest" || order === "oldest") {
        const timeA = new Date(a.querySelector("time")?.dateTime || 0);
        const timeB = new Date(b.querySelector("time")?.dateTime || 0);
        return order === "newest" ? timeB - timeA : timeA - timeB;
      }
      if (order === "comments") {
        const numA = parseInt(
          a.querySelector(".mod-feed-comments")?.textContent || "0"
        );
        const numB = parseInt(
          b.querySelector(".mod-feed-comments")?.textContent || "0"
        );
        return numB - numA;
      }
      if (order === "reports") {
        const hasA = a.classList.contains("mod-feed-card--reported") ? 1 : 0;
        const hasB = b.classList.contains("mod-feed-card--reported") ? 1 : 0;
        return hasB - hasA;
      }
      return 0;
    });

    cards.forEach((card) => grid.appendChild(card));
  }

  searchInput.addEventListener("input", () => applyFilters());
  selCategory.addEventListener("change", () => applyFilters());
  selStatus.addEventListener("change", () => applyFilters());
  selPriority.addEventListener("change", () => applyFilters());
  selSort.addEventListener("change", () => {
    applySort();
    applyFilters();
  });

  /* ── TOAST HELPER ──────────────────────────────────────── */

  let toastTimer = null;

  function showToast(message, type = "success") {
    clearTimeout(toastTimer);
    toast.textContent = message;
    toast.className = `mod-toast mod-toast--${type} mod-toast--show`;
    toastTimer = setTimeout(() => {
      toast.classList.remove("mod-toast--show");
    }, 3200);
  }

  /* ── CONFIRM MODAL ─────────────────────────────────────── */

  let pendingAction = null;

  function openConfirm({ icon, title, body, okLabel, okDanger, onConfirm }) {
    confirmIcon.textContent = icon;
    confirmTitle.textContent = title;
    confirmBody.textContent = body;
    confirmOk.textContent = okLabel || "Confirm";
    confirmOk.className = okDanger
      ? "mod-confirm-ok mod-confirm-ok--danger"
      : "mod-confirm-ok";
    pendingAction = onConfirm;
    overlay.style.display = "flex";
  }

  function closeConfirm() {
    overlay.style.display = "none";
    pendingAction = null;
  }

  confirmOk.addEventListener("click", () => {
    if (typeof pendingAction === "function") pendingAction();
    closeConfirm();
  });

  confirmCancel.addEventListener("click", closeConfirm);

  overlay.addEventListener("click", (e) => {
    if (e.target === overlay) closeConfirm();
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeConfirm();
  });

  /* ── ACTION BUTTONS ────────────────────────────────────── */

  grid.addEventListener("click", (e) => {
    /* ── LOCK / UNLOCK ── */
    const lockBtn = e.target.closest(".mod-action-lock");
    if (lockBtn) {
      const card = lockBtn.closest(".mod-feed-card");
      const isLocked = lockBtn.classList.contains("mod-action-lock--active");
      const id = lockBtn.dataset.id;

      if (isLocked) {
        openConfirm({
          icon: "🔓",
          title: "Unlock Thread",
          body: `Unlock this thread so community members can reply again? (Thread #${id})`,
          okLabel: "Unlock",
          onConfirm: () => {
            card.classList.remove("mod-feed-card--locked");
            lockBtn.classList.remove("mod-action-lock--active");
            lockBtn.title = "Lock Thread";
            lockBtn.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                            </svg>Lock`;
            removeLockIndicator(card);
            showToast("Thread unlocked.", "success");
            // TODO: POST /backend/routes/moderator/lock_thread.php { id, locked: false }
          },
        });
      } else {
        openConfirm({
          icon: "🔒",
          title: "Lock Thread",
          body: `Lock this thread? Community members will no longer be able to reply. (Thread #${id})`,
          okLabel: "Lock",
          onConfirm: () => {
            card.classList.add("mod-feed-card--locked");
            lockBtn.classList.add("mod-action-lock--active");
            lockBtn.title = "Unlock Thread";
            lockBtn.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                            </svg>Unlock`;
            addLockIndicator(card);
            showToast("Thread locked.", "success");
            // TODO: POST /backend/routes/moderator/lock_thread.php { id, locked: true }
          },
        });
      }
      return;
    }

    /* ── FLAG / UNFLAG ── */
    const flagBtn = e.target.closest(".mod-action-flag");
    if (flagBtn) {
      const card = flagBtn.closest(".mod-feed-card");
      const isFlagged = flagBtn.classList.contains("mod-action-flag--active");
      const id = flagBtn.dataset.id;

      if (isFlagged) {
        openConfirm({
          icon: "🏳️",
          title: "Remove Flag",
          body: `Remove the flag from this thread? (Thread #${id})`,
          okLabel: "Remove Flag",
          onConfirm: () => {
            card.classList.remove("mod-feed-card--flagged");
            flagBtn.classList.remove("mod-action-flag--active");
            flagBtn.title = "Flag for Review";
            flagBtn.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/>
                            </svg>Flag`;
            removeFlagIndicator(card);
            showToast("Flag removed.", "success");
            // TODO: POST /backend/routes/moderator/flag_thread.php { id, flagged: false }
          },
        });
      } else {
        openConfirm({
          icon: "🚩",
          title: "Flag Thread",
          body: `Flag this thread for moderator review? (Thread #${id})`,
          okLabel: "Flag",
          onConfirm: () => {
            card.classList.add("mod-feed-card--flagged");
            flagBtn.classList.add("mod-action-flag--active");
            flagBtn.title = "Unflag Thread";
            flagBtn.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 2.25a.75.75 0 0 1 .75.75v.54l1.838-.46a9.75 9.75 0 0 1 6.725.738l.108.054A8.25 8.25 0 0 0 18 4.524l3.11-.732a.75.75 0 0 1 .917.81 47.784 47.784 0 0 0 .005 10.337.75.75 0 0 1-.574.812l-3.114.733a9.75 9.75 0 0 1-6.594-.77l-.108-.054a8.25 8.25 0 0 0-5.69-.625l-2.202.55V21a.75.75 0 0 1-1.5 0V3A.75.75 0 0 1 3 2.25Z" clip-rule="evenodd"/>
                            </svg>Unflag`;
            addFlagIndicator(card);
            showToast("Thread flagged for review.", "warning");
            // TODO: POST /backend/routes/moderator/flag_thread.php { id, flagged: true }
          },
        });
      }
      return;
    }

    /* ── REMOVE ── */
    const removeBtn = e.target.closest(".mod-action-remove");
    if (removeBtn) {
      const card = removeBtn.closest(".mod-feed-card");
      const id = removeBtn.dataset.id;
      const title =
        card.querySelector(".mod-feed-title")?.textContent?.trim() ||
        `Thread #${id}`;

      openConfirm({
        icon: "🗑️",
        title: "Remove Thread",
        body: `Permanently remove "${title}"? This action cannot be undone.`,
        okLabel: "Remove",
        okDanger: true,
        onConfirm: () => {
          card.style.transition = "opacity 0.3s, transform 0.3s";
          card.style.opacity = "0";
          card.style.transform = "scale(0.95)";
          setTimeout(() => {
            card.remove();
            applyFilters();
            showToast("Thread removed.", "danger");
          }, 300);
          // TODO: POST /backend/routes/moderator/remove_thread.php { id }
        },
      });
      return;
    }
  });

  /* ── BADGE INDICATOR HELPERS ───────────────────────────── */

  function addLockIndicator(card) {
    if (card.querySelector(".mod-lock-indicator")) return;
    const badges = card.querySelector(".mod-feed-badges");
    const el = document.createElement("span");
    el.className = "mod-lock-indicator";
    el.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>Locked`;
    badges.appendChild(el);
  }

  function removeLockIndicator(card) {
    card.querySelector(".mod-lock-indicator")?.remove();
  }

  function addFlagIndicator(card) {
    if (card.querySelector(".mod-flag-indicator")) return;
    const badges = card.querySelector(".mod-feed-badges");
    const el = document.createElement("span");
    el.className = "mod-flag-indicator";
    el.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></svg>Flagged`;
    badges.appendChild(el);
  }

  function removeFlagIndicator(card) {
    card.querySelector(".mod-flag-indicator")?.remove();
  }

  /* ── PAGINATION (client-side stub) ─────────────────────── */

  const prevBtn = document.getElementById("mod-prev-btn");
  const nextBtn = document.getElementById("mod-next-btn");
  const pageNumbers = document.getElementById("mod-page-numbers");

  pageNumbers.addEventListener("click", (e) => {
    const btn = e.target.closest(".mod-page-num");
    if (!btn) return;
    pageNumbers
      .querySelectorAll(".mod-page-num")
      .forEach((b) => b.classList.remove("active"));
    btn.classList.add("active");
    const current =
      Array.from(pageNumbers.querySelectorAll(".mod-page-num")).indexOf(btn) +
      1;
    const total = pageNumbers.querySelectorAll(".mod-page-num").length;
    prevBtn.disabled = current === 1;
    nextBtn.disabled = current === total;
    // TODO: fetch page from backend and re-render grid
  });

  prevBtn.addEventListener("click", () => {
    const active = pageNumbers.querySelector(".mod-page-num.active");
    const prev = active?.previousElementSibling;
    if (prev) prev.click();
  });

  nextBtn.addEventListener("click", () => {
    const active = pageNumbers.querySelector(".mod-page-num.active");
    const next = active?.nextElementSibling;
    if (next) next.click();
  });

  /* ── INIT ──────────────────────────────────────────────── */
  applyFilters();
});
