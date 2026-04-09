/**
 * services_mgmt.js
 * scripts/management/officer/services_mgmt.js
 *
 * Handles: search/filter, Add/Edit modal, toggle active/inactive,
 * delete confirmation, toast notifications.
 */

document.addEventListener("DOMContentLoaded", () => {
  /* ── ELEMENT REFS ──────────────────────────────────────── */

  const grid = document.getElementById("svc-grid");
  const noResults = document.getElementById("svc-no-results");
  const countLabel = document.getElementById("svc-count");

  const searchInput = document.getElementById("svc-search");
  const selCategory = document.getElementById("svc-category");
  const selStatus = document.getElementById("svc-status");

  // Add/Edit modal
  const modalOverlay = document.getElementById("svc-modal-overlay");
  const modalTitle = document.getElementById("svc-modal-title");
  const modalClose = document.getElementById("svc-modal-close");
  const modalCancel = document.getElementById("svc-modal-cancel");
  const saveBtn = document.getElementById("svc-save-btn");

  const fieldId = document.getElementById("svc-id");
  const fieldName = document.getElementById("svc-name");
  const fieldCategory = document.getElementById("svc-category-field");
  const fieldDesc = document.getElementById("svc-desc");
  const fieldEligibility = document.getElementById("svc-eligibility");
  const fieldTime = document.getElementById("svc-time");
  const fieldRequirements = document.getElementById("svc-requirements");
  const fieldStatus = document.getElementById("svc-status-field");

  const errName = document.getElementById("err-svc-name");
  const errCategory = document.getElementById("err-svc-category");
  const errDesc = document.getElementById("err-svc-desc");

  // Delete confirm modal
  const confirmOverlay = document.getElementById("svc-confirm-overlay");
  const confirmBody = document.getElementById("svc-confirm-body");
  const confirmDelete = document.getElementById("svc-confirm-delete");
  const confirmCancel = document.getElementById("svc-confirm-cancel");

  // Toast
  const toast = document.getElementById("svc-toast");

  /* ── TOAST ─────────────────────────────────────────────── */

  let toastTimer = null;

  function showToast(message, type = "success") {
    clearTimeout(toastTimer);
    toast.textContent = message;
    toast.className = `svc-toast svc-toast--${type} svc-toast--show`;
    toastTimer = setTimeout(
      () => toast.classList.remove("svc-toast--show"),
      3200
    );
  }

  /* ── FILTER ────────────────────────────────────────────── */

  function getCards() {
    return Array.from(grid.querySelectorAll(".svc-card"));
  }

  function applyFilters() {
    const q = searchInput.value.toLowerCase().trim();
    const category = selCategory.value;
    const status = selStatus.value;

    let visible = 0;

    getCards().forEach((card) => {
      const name = card.dataset.name || "";
      const matchQ = !q || name.includes(q);
      const matchCat = category === "all" || card.dataset.category === category;
      const matchSt = status === "all" || card.dataset.status === status;

      const show = matchQ && matchCat && matchSt;
      card.style.display = show ? "" : "none";
      if (show) visible++;
    });

    countLabel.textContent = `Showing ${visible} service${
      visible !== 1 ? "s" : ""
    }`;
    noResults.style.display = visible === 0 ? "flex" : "none";
  }

  searchInput.addEventListener("input", applyFilters);
  selCategory.addEventListener("change", applyFilters);
  selStatus.addEventListener("change", applyFilters);

  /* ── MODAL OPEN / CLOSE ────────────────────────────────── */

  function clearErrors() {
    [errName, errCategory, errDesc].forEach((el) => {
      if (el) el.textContent = "";
    });
  }

  function openModal(mode = "add", data = null) {
    clearErrors();
    fieldId.value = "";
    fieldName.value = "";
    fieldCategory.value = "";
    fieldDesc.value = "";
    fieldEligibility.value = "";
    fieldTime.value = "";
    fieldRequirements.value = "";
    fieldStatus.value = "active";

    if (mode === "edit" && data) {
      modalTitle.textContent = "Edit Service";
      fieldId.value = data.id || "";
      fieldName.value = data.name || "";
      fieldCategory.value = data.category || "";
      fieldDesc.value = data.description || "";
      fieldEligibility.value = data.eligibility || "";
      fieldTime.value = data.processing_time || "";
      fieldRequirements.value = data.requirements || "";
      fieldStatus.value = data.status || "active";
    } else {
      modalTitle.textContent = "Add Service";
    }

    modalOverlay.style.display = "flex";
    fieldName.focus();
  }

  function closeModal() {
    modalOverlay.style.display = "none";
  }

  document
    .getElementById("svc-add-btn")
    .addEventListener("click", () => openModal("add"));
  modalClose.addEventListener("click", closeModal);
  modalCancel.addEventListener("click", closeModal);

  modalOverlay.addEventListener("click", (e) => {
    if (e.target === modalOverlay) closeModal();
  });

  // Edit buttons — delegated
  grid.addEventListener("click", (e) => {
    const editBtn = e.target.closest(".svc-edit-btn");
    if (editBtn) {
      try {
        const data = JSON.parse(editBtn.dataset.service);
        openModal("edit", data);
      } catch {
        showToast("Could not load service data.", "danger");
      }
    }
  });

  /* ── FORM VALIDATION ───────────────────────────────────── */

  function validate() {
    let valid = true;

    if (!fieldName.value.trim()) {
      errName.textContent = "Service name is required.";
      valid = false;
    } else {
      errName.textContent = "";
    }

    if (!fieldCategory.value) {
      errCategory.textContent = "Please select a category.";
      valid = false;
    } else {
      errCategory.textContent = "";
    }

    if (!fieldDesc.value.trim()) {
      errDesc.textContent = "Description is required.";
      valid = false;
    } else {
      errDesc.textContent = "";
    }

    return valid;
  }

  /* ── SAVE (ADD / EDIT) ─────────────────────────────────── */

  saveBtn.addEventListener("click", () => {
    if (!validate()) return;

    const isEdit = !!fieldId.value;
    const payload = {
      id: fieldId.value,
      name: fieldName.value.trim(),
      category: fieldCategory.value,
      description: fieldDesc.value.trim(),
      eligibility: fieldEligibility.value.trim(),
      processing_time: fieldTime.value.trim(),
      requirements: fieldRequirements.value.trim(),
      status: fieldStatus.value,
    };

    if (isEdit) {
      // ── UPDATE CARD IN DOM ─────────────────────────
      const card = grid.querySelector(`.svc-card[data-id="${payload.id}"]`);
      if (card) {
        card.dataset.category = payload.category;
        card.dataset.status = payload.status;
        card.dataset.name = payload.name.toLowerCase();

        card.querySelector(".svc-card-title").textContent = payload.name;
        card.querySelector(".svc-card-desc").textContent = payload.description;

        // Update details list
        const lis = card.querySelectorAll(".svc-details-list li");
        if (lis[0])
          lis[0].lastElementChild.textContent = payload.eligibility || "—";
        if (lis[1])
          lis[1].lastElementChild.textContent = payload.processing_time || "—";
        if (lis[2])
          lis[2].lastElementChild.textContent = payload.requirements || "—";

        // Update status badge
        updateCardStatus(card, payload.status);

        // Update category tag
        const catTag = card.querySelector(".svc-cat-tag");
        if (catTag) {
          catTag.className = `svc-cat-tag svc-cat-${payload.category}`;
          catTag.textContent =
            payload.category.charAt(0).toUpperCase() +
            payload.category.slice(1);
        }

        // Update icon wrap
        const iconWrap = card.querySelector(".svc-icon-wrap");
        if (iconWrap) {
          iconWrap.className = `svc-icon-wrap svc-icon-${payload.category}`;
        }

        // Refresh edit button data
        const editBtn = card.querySelector(".svc-edit-btn");
        if (editBtn) editBtn.dataset.service = JSON.stringify(payload);

        showToast(`"${payload.name}" updated successfully.`, "success");
      }
      // TODO: PATCH /backend/routes/officer/update_service.php
    } else {
      // ── ADD CARD TO DOM ────────────────────────────
      const newId = Date.now(); // temp ID until DB assigns one
      payload.id = newId;
      const newCard = buildCard(payload);
      grid.prepend(newCard);
      showToast(`"${payload.name}" added successfully.`, "success");
      // TODO: POST /backend/routes/officer/add_service.php
    }

    closeModal();
    applyFilters();
  });

  /* ── TOGGLE ACTIVE / INACTIVE ──────────────────────────── */

  grid.addEventListener("click", (e) => {
    const toggleBtn = e.target.closest(".svc-toggle-btn");
    if (!toggleBtn) return;

    const card = toggleBtn.closest(".svc-card");
    const currentSt = toggleBtn.dataset.status;
    const newStatus = currentSt === "active" ? "inactive" : "active";
    const name =
      card.querySelector(".svc-card-title")?.textContent || "Service";

    updateCardStatus(card, newStatus);
    applyFilters();

    const verb = newStatus === "active" ? "activated" : "deactivated";
    showToast(
      `"${name}" ${verb}.`,
      newStatus === "active" ? "success" : "warning"
    );

    // TODO: PATCH /backend/routes/officer/toggle_service.php { id, status: newStatus }
  });

  function updateCardStatus(card, status) {
    card.dataset.status = status;

    // Accent stripe handled by CSS [data-status] — nothing extra needed

    // Status badge
    const badge = card.querySelector(".svc-status-badge");
    if (badge) {
      badge.className = `svc-status-badge svc-badge-${status}`;
      badge.innerHTML =
        status === "active"
          ? `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>Active`
          : `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/></svg>Inactive`;
    }

    // Toggle button
    const toggleBtn = card.querySelector(".svc-toggle-btn");
    if (toggleBtn) {
      toggleBtn.dataset.status = status;
      toggleBtn.className = `svc-toggle-btn svc-toggle-${status}`;
      toggleBtn.title =
        status === "active" ? "Deactivate service" : "Activate service";
      toggleBtn.innerHTML =
        status === "active"
          ? `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9"/></svg>Deactivate`
          : `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9"/></svg>Activate`;
    }

    // Sync edit button data
    const editBtn = card.querySelector(".svc-edit-btn");
    if (editBtn) {
      try {
        const d = JSON.parse(editBtn.dataset.service);
        d.status = status;
        editBtn.dataset.service = JSON.stringify(d);
      } catch {
        /* noop */
      }
    }
  }

  /* ── DELETE ────────────────────────────────────────────── */

  let pendingDeleteId = null;
  let pendingDeleteCard = null;

  grid.addEventListener("click", (e) => {
    const deleteBtn = e.target.closest(".svc-delete-btn");
    if (!deleteBtn) return;

    pendingDeleteId = deleteBtn.dataset.id;
    pendingDeleteCard = deleteBtn.closest(".svc-card");
    const name = deleteBtn.dataset.name || "this service";

    confirmBody.textContent = `Are you sure you want to delete "${name}"? This cannot be undone.`;
    confirmOverlay.style.display = "flex";
  });

  confirmDelete.addEventListener("click", () => {
    if (pendingDeleteCard) {
      const name =
        pendingDeleteCard.querySelector(".svc-card-title")?.textContent ||
        "Service";
      pendingDeleteCard.style.transition = "opacity 0.3s, transform 0.3s";
      pendingDeleteCard.style.opacity = "0";
      pendingDeleteCard.style.transform = "scale(0.95)";
      setTimeout(() => {
        pendingDeleteCard.remove();
        applyFilters();
      }, 300);
      showToast(`"${name}" deleted.`, "danger");
      // TODO: DELETE /backend/routes/officer/delete_service.php { id: pendingDeleteId }
    }
    closeConfirm();
  });

  confirmCancel.addEventListener("click", closeConfirm);
  confirmOverlay.addEventListener("click", (e) => {
    if (e.target === confirmOverlay) closeConfirm();
  });

  function closeConfirm() {
    confirmOverlay.style.display = "none";
    pendingDeleteId = null;
    pendingDeleteCard = null;
  }

  /* ── BUILD NEW CARD (for Add flow) ─────────────────────── */

  const categoryIcons = {
    medical: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>`,
    education: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84 51.39 51.39 0 0 0-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/></svg>`,
    scholarship: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0"/></svg>`,
    livelihood: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z"/></svg>`,
  };

  const categoryLabels = {
    medical: "Medical",
    education: "Education",
    scholarship: "Scholarship",
    livelihood: "Livelihood",
  };

  function buildCard(d) {
    const icon = categoryIcons[d.category] || "";
    const label = categoryLabels[d.category] || d.category;

    const article = document.createElement("article");
    article.className = "svc-card";
    article.dataset.id = d.id;
    article.dataset.category = d.category;
    article.dataset.status = d.status;
    article.dataset.name = d.name.toLowerCase();

    article.innerHTML = `
        <div class="svc-card-body">
            <div class="svc-card-top">
                <div class="svc-icon-wrap svc-icon-${d.category}">${icon}</div>
                <span class="svc-status-badge svc-badge-${d.status}">
                    ${
                      d.status === "active"
                        ? `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>Active`
                        : `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/></svg>Inactive`
                    }
                </span>
            </div>
            <h3 class="svc-card-title">${escHtml(d.name)}</h3>
            <span class="svc-cat-tag svc-cat-${d.category}">${label}</span>
            <p class="svc-card-desc">${escHtml(d.description)}</p>
            <ul class="svc-details-list">
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
                    <span class="svc-detail-label">Eligibility</span>
                    <span>${escHtml(d.eligibility || "—")}</span>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    <span class="svc-detail-label">Processing</span>
                    <span>${escHtml(d.processing_time || "—")}</span>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                    <span class="svc-detail-label">Requirements</span>
                    <span>${escHtml(d.requirements || "—")}</span>
                </li>
            </ul>
        </div>
        <div class="svc-card-footer">
            <button class="svc-toggle-btn svc-toggle-${d.status}" data-id="${
      d.id
    }" data-status="${d.status}" title="${
      d.status === "active" ? "Deactivate" : "Activate"
    } service">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9"/></svg>
                ${d.status === "active" ? "Deactivate" : "Activate"}
            </button>
            <div class="svc-card-actions-right">
                <button class="svc-edit-btn" data-service='${escAttr(
                  JSON.stringify(d)
                )}' title="Edit service">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                    Edit
                </button>
                <button class="svc-delete-btn" data-id="${
                  d.id
                }" data-name="${escAttr(d.name)}" title="Delete service">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                    Delete
                </button>
            </div>
        </div>`;

    return article;
  }

  /* ── ESCAPE HELPERS ────────────────────────────────────── */

  function escHtml(str) {
    return String(str)
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;");
  }

  function escAttr(str) {
    return String(str).replace(/'/g, "&#39;");
  }

  /* ── KEYBOARD ESC ──────────────────────────────────────── */

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      closeModal();
      closeConfirm();
    }
  });

  /* ── INIT ──────────────────────────────────────────────── */
  applyFilters();
});
