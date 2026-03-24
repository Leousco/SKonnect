document.addEventListener("DOMContentLoaded", function () {
  /* ── FORM COLLAPSE TOGGLE ────────────────────────────── */
  const formToggle = document.getElementById("ms-form-toggle");
  const formBody = document.getElementById("ms-form-body");

  if (formToggle && formBody) {
    formToggle.addEventListener("click", function () {
      const collapsed = formBody.classList.toggle("collapsed");
      this.innerHTML = collapsed
        ? `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg> Expand`
        : `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg> Collapse`;
    });
  }

  /* ── CLEAR FORM ──────────────────────────────────────── */
  document.getElementById("ms-cancel")?.addEventListener("click", function () {
    document.getElementById("ms-username").value = "";
    document.getElementById("ms-reason").value = "";
    document.getElementById("ms-level").value = "1";
  });

  /* ── ISSUE WARNING (stub) ────────────────────────────── */
  document.getElementById("ms-submit")?.addEventListener("click", function () {
    const username = document.getElementById("ms-username")?.value.trim();
    const reason = document.getElementById("ms-reason")?.value.trim();
    const level = document.getElementById("ms-level")?.value;

    if (!username || !reason) {
      alert("Please fill in the username and reason before issuing a warning.");
      return;
    }

    // TODO: connect to backend API
    alert(
      `Warning issued to ${username} (Level ${level}). Connect this to your backend.`
    );
  });

  /* ── FILTER BUTTONS ──────────────────────────────────── */
  const filterBtns = document.querySelectorAll(".ms-filter-btn");
  const searchInput = document.getElementById("ms-search");
  const list = document.getElementById("ms-list");
  const emptyState = document.getElementById("ms-empty");
  const shownCount = document.getElementById("ms-shown");

  let activeFilter = "all";

  filterBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      filterBtns.forEach((b) => b.classList.remove("active"));
      this.classList.add("active");
      activeFilter = this.dataset.filter;
      applyFilters();
    });
  });

  /* ── SEARCH ──────────────────────────────────────────── */
  searchInput?.addEventListener("input", debounce(applyFilters, 250));

  /* ── APPLY FILTERS ───────────────────────────────────── */
  function applyFilters() {
    const query = (searchInput?.value || "").toLowerCase().trim();
    const items = list.querySelectorAll(".ms-item");
    let visible = 0;

    items.forEach((item) => {
      const level = item.dataset.level || "";
      const text = item.innerText.toLowerCase();
      const matchFilter = activeFilter === "all" || level === activeFilter;
      const matchSearch = !query || text.includes(query);

      if (matchFilter && matchSearch) {
        item.style.display = "";
        visible++;
      } else {
        item.style.display = "none";
      }
    });

    if (emptyState) emptyState.style.display = visible === 0 ? "flex" : "none";
    if (shownCount) shownCount.textContent = visible;
  }

  /* ── ACTION BUTTONS ──────────────────────────────────── */
  list?.addEventListener("click", function (e) {
    const btn = e.target.closest(".ms-action-btn");
    if (!btn) return;
    e.preventDefault();

    const item = btn.closest(".ms-item");
    const username =
      item.querySelector(".ms-username")?.textContent || "this user";

    if (btn.classList.contains("ms-btn-dismiss")) {
      if (confirm(`Dismiss the warning for ${username}?`)) {
        item.style.opacity = "0";
        item.style.transform = "translateX(20px)";
        item.style.transition = "opacity 0.3s, transform 0.3s";
        setTimeout(() => {
          item.remove();
          applyFilters();
        }, 300);
      }
    }

    if (btn.classList.contains("ms-btn-ban")) {
      if (
        confirm(
          `Ban ${username}? This action cannot be undone without admin access.`
        )
      ) {
        // TODO: connect to backend ban API
        alert(`${username} ban submitted. Connect this to your backend.`);
      }
    }

    if (btn.classList.contains("ms-btn-view")) {
      // TODO: link to user profile
      alert(
        `Viewing profile for ${username}. Connect this to your user profile page.`
      );
    }
  });

  /* ── UTILITY ─────────────────────────────────────────── */
  function debounce(fn, delay) {
    let t;
    return (...args) => {
      clearTimeout(t);
      t = setTimeout(() => fn(...args), delay);
    };
  }

  applyFilters();
});
