document.addEventListener("DOMContentLoaded", function () {
  /* ── TAB SWITCHING ─────────────────────────────────────── */
  const tabs = document.querySelectorAll(".ann-tab");
  const panels = {
    list: document.getElementById("panel-list"),
    create: document.getElementById("panel-create"),
    archive: document.getElementById("panel-archive"),
  };
  const btnSwitch = document.getElementById("btn-switch-create");

  function switchTab(target) {
    tabs.forEach((t) => t.classList.toggle("active", t.dataset.tab === target));
    Object.entries(panels).forEach(([key, el]) => {
      el.classList.toggle("ann-panel--hidden", key !== target);
    });
  }

  tabs.forEach((tab) =>
    tab.addEventListener("click", () => switchTab(tab.dataset.tab))
  );
  if (btnSwitch) btnSwitch.addEventListener("click", () => switchTab("create"));

  /* ── LIVE PREVIEW: TITLE ──────────────────────────────── */
  const titleInput = document.getElementById("ann-title");
  const previewTitle = document.getElementById("preview-title");
  const charCount = document.getElementById("title-char");
  const checkTitle = document.getElementById("check-title");

  if (titleInput) {
    titleInput.addEventListener("input", function () {
      const val = this.value.trim();
      previewTitle.textContent =
        val || "Your announcement title will appear here…";
      if (charCount) charCount.textContent = `${this.value.length} / 120`;
      toggleCheck(checkTitle, val.length > 0);
    });
  }

  /* ── LIVE PREVIEW: BODY ───────────────────────────────── */
  const bodyInput = document.getElementById("ann-body");
  const previewExcerpt = document.getElementById("preview-excerpt");
  const checkBody = document.getElementById("check-body");

  if (bodyInput) {
    bodyInput.addEventListener("input", function () {
      const val = this.value.trim();
      previewExcerpt.textContent = val
        ? val.slice(0, 160) + (val.length > 160 ? "…" : "")
        : "The announcement body text will be summarised here for the card view.";
      toggleCheck(checkBody, val.length > 0);
    });
  }

  /* ── LIVE PREVIEW: CATEGORY ───────────────────────────── */
  const catRadios = document.querySelectorAll('input[name="category"]');
  const previewCatPill = document.getElementById("preview-cat-pill");
  const checkCategory = document.getElementById("check-category");

  const catPillColors = {
    event:   "background:#d1fae5;color:#065f46;",
    program: "background:#dbeafe;color:#1d4ed8;",
    meeting: "background:#ede9fe;color:#5b21b6;",
    notice:  "background:#fef3c7;color:#92400e;",
    urgent:  "background:#fee2e2;color:#b91c1c;",
  };

  const catLabels = {
    event:   "Event",
    program: "Program",
    meeting: "Meeting",
    notice:  "Notice",
    urgent:  "Urgent",
  };

  catRadios.forEach((radio) => {
    radio.addEventListener("change", function () {
      if (previewCatPill) {
        previewCatPill.textContent = catLabels[this.value] || this.value;
        previewCatPill.setAttribute("style", catPillColors[this.value] || "");
      }
      toggleCheck(checkCategory, true);
    });
  });

  /* ── FEATURED TOGGLE ──────────────────────────────────── */
  const featuredCheckbox = document.getElementById("featured-checkbox");
  const featuredToggleCard = document.getElementById("featured-toggle-card");
  const previewFeaturedBadge = document.getElementById("preview-featured-badge");

  if (featuredCheckbox) {
    featuredCheckbox.addEventListener("change", function () {
      featuredToggleCard?.classList.toggle("is-featured", this.checked);
      if (previewFeaturedBadge) {
        previewFeaturedBadge.style.display = this.checked ? "inline-flex" : "none";
      }
    });
  }

  /* ── BANNER UPLOAD ────────────────────────────────────── */
  const bannerFileInput = document.getElementById("banner-file");
  const bannerDropZone = document.getElementById("banner-drop-zone");
  const bannerDropInner = document.getElementById("banner-drop-inner");
  const bannerPreview = document.getElementById("banner-preview");
  const bannerPreviewImg = document.getElementById("banner-preview-img");
  const bannerRemoveBtn = document.getElementById("banner-remove");
  const previewBannerImg = document.getElementById("preview-banner-img");
  const previewBannerPlaceholder = document.getElementById("preview-banner-placeholder");
  const checkBanner = document.getElementById("check-banner");

  function loadBanner(file) {
    if (!file || !file.type.startsWith("image/")) return;
    const url = URL.createObjectURL(file);

    // Form preview
    if (bannerDropInner) bannerDropInner.style.display = "none";
    if (bannerPreview) bannerPreview.style.display = "block";
    if (bannerPreviewImg) bannerPreviewImg.src = url;

    // Card preview
    if (previewBannerImg) {
      previewBannerImg.src = url;
      previewBannerImg.style.display = "block";
    }
    if (previewBannerPlaceholder) previewBannerPlaceholder.style.display = "none";

    toggleCheck(checkBanner, true);
  }

  if (bannerFileInput) {
    bannerFileInput.addEventListener("change", function () {
      if (this.files[0]) loadBanner(this.files[0]);
    });
  }

  if (bannerRemoveBtn) {
    bannerRemoveBtn.addEventListener("click", function () {
      if (bannerDropInner) bannerDropInner.style.display = "";
      if (bannerPreview) bannerPreview.style.display = "none";
      if (bannerPreviewImg) {
        bannerPreviewImg.src = "";
        bannerPreviewImg.style.display = "none";
      }
      if (previewBannerPlaceholder) previewBannerPlaceholder.style.display = "";
      if (bannerFileInput) bannerFileInput.value = "";
      toggleCheck(checkBanner, false);
    });
  }

  // Drag & drop for banner
  if (bannerDropZone) {
    bannerDropZone.addEventListener("dragover", function (e) {
      e.preventDefault();
      this.classList.add("drag-over");
    });
    bannerDropZone.addEventListener("dragleave", function () {
      this.classList.remove("drag-over");
    });
    bannerDropZone.addEventListener("drop", function (e) {
      e.preventDefault();
      this.classList.remove("drag-over");
      const file = e.dataTransfer.files[0];
      if (file) loadBanner(file);
    });
  }

  /* ── ATTACHMENT UPLOAD ────────────────────────────────── */
  const attachFileInput = document.getElementById("attach-files");
  const attachList = document.getElementById("attach-list");
  const attachDropZone = document.getElementById("attach-drop-zone");
  const previewAttachRow = document.getElementById("preview-attach-row");
  const previewAttachCount = document.getElementById("preview-attach-count");

  let attachments = [
    // Pre-populated example
    { name: "Program_Guidelines_2026.pdf", size: "980 KB", type: "pdf" },
  ];

  function getFileType(name) {
    const ext = name.split(".").pop().toLowerCase();
    if (ext === "pdf") return "pdf";
    if (["doc", "docx"].includes(ext)) return "doc";
    if (["xls", "xlsx"].includes(ext)) return "xls";
    return "img";
  }

  function formatSize(bytes) {
    if (bytes < 1024) return bytes + " B";
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + " KB";
    return (bytes / 1048576).toFixed(1) + " MB";
  }

  function renderAttachments() {
    if (!attachList) return;
    attachList.innerHTML = "";
    attachments.forEach((att, idx) => {
      const li = document.createElement("li");
      li.className = "ann-attach-item";
      li.innerHTML = `
        <div class="attach-icon attach-icon--${att.type}">${att.type.toUpperCase()}</div>
        <div class="attach-meta">
          <span class="attach-name">${att.name}</span>
          <span class="attach-size">${att.size}</span>
        </div>
        <button type="button" class="attach-remove-btn" data-idx="${idx}" title="Remove">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
        </button>`;
      attachList.appendChild(li);
    });

    // Remove buttons
    attachList.querySelectorAll(".attach-remove-btn").forEach((btn) => {
      btn.addEventListener("click", function () {
        attachments.splice(parseInt(this.dataset.idx), 1);
        renderAttachments();
        syncAttachPreview();
      });
    });

    syncAttachPreview();
  }

  function syncAttachPreview() {
    if (!previewAttachRow) return;
    if (attachments.length > 0) {
      previewAttachRow.style.display = "flex";
      previewAttachCount.textContent = `${attachments.length} attachment${
        attachments.length > 1 ? "s" : ""
      }`;
    } else {
      previewAttachRow.style.display = "none";
    }
  }

  if (attachFileInput) {
    attachFileInput.addEventListener("change", function () {
      Array.from(this.files).forEach((file) => {
        attachments.push({
          name: file.name,
          size: formatSize(file.size),
          type: getFileType(file.name),
        });
      });
      this.value = "";
      renderAttachments();
    });
  }

  if (attachDropZone) {
    attachDropZone.addEventListener("dragover", (e) => {
      e.preventDefault();
      attachDropZone.style.borderColor = "var(--op-accent)";
    });
    attachDropZone.addEventListener("dragleave", () => {
      attachDropZone.style.borderColor = "";
    });
    attachDropZone.addEventListener("drop", function (e) {
      e.preventDefault();
      this.style.borderColor = "";
      Array.from(e.dataTransfer.files).forEach((file) => {
        attachments.push({
          name: file.name,
          size: formatSize(file.size),
          type: getFileType(file.name),
        });
      });
      renderAttachments();
    });
  }

  // Initial render (pre-populated example)
  renderAttachments();

  /* ── PUBLISH DATE DEFAULT ────────────────────────────── */
  const publishDateInput = document.getElementById("ann-publish-date");
  if (publishDateInput) {
    const today = new Date().toISOString().split("T")[0];
    publishDateInput.value = today;

    const previewDate = document.getElementById("preview-date");
    if (previewDate) {
      previewDate.textContent = new Date().toLocaleDateString("en-US", {
        month: "short",
        day: "numeric",
        year: "numeric",
      });
    }
    publishDateInput.addEventListener("change", function () {
      if (previewDate && this.value) {
        previewDate.textContent = new Date(
          this.value + "T00:00:00"
        ).toLocaleDateString("en-US", {
          month: "short",
          day: "numeric",
          year: "numeric",
        });
      }
    });
  }

  /* ── HELPER: TOGGLE CHECKLIST ITEM ───────────────────── */
  function toggleCheck(el, done) {
    if (!el) return;
    el.classList.toggle("is-done", done);
    const empty = el.querySelector(".check-empty");
    const checkDone = el.querySelector(".check-done");
    if (empty) empty.style.display = done ? "none" : "";
    if (checkDone) checkDone.style.display = done ? "" : "none";
  }
});