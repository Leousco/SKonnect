/* thread_view.js — SKonnect Thread View Page */

document.addEventListener("DOMContentLoaded", () => {
  /* ---- TOAST ---- */

  function showToast(msg, type = "success") {
    const toast = document.getElementById("feed-toast");
    if (!toast) return;
    toast.textContent = msg;
    toast.className = `feed-toast toast-${type} show`;
    setTimeout(() => {
      toast.className = "feed-toast";
    }, 3000);
  }

  /* ---- THREAD SUPPORT ---- */

  const threadSupportBtn = document.getElementById("thread-support-btn");
  const threadSupportCount = document.getElementById("thread-support-count");

  threadSupportBtn?.addEventListener("click", async () => {
    const fd = new FormData();
    fd.append("type", "thread");
    fd.append("id", THREAD_ID);

    try {
      const res = await fetch(
        "../../backend/controllers/ToggleSupportController.php",
        { method: "POST", body: fd }
      );
      const data = await res.json();
      if (data.status === "success") {
        threadSupportBtn.classList.toggle("active", data.supported);
        threadSupportBtn.title = data.supported
          ? "Remove support"
          : "I support this";
        threadSupportCount.textContent = data.total;
        const labelSpan = threadSupportBtn.querySelectorAll("span")[2];
        if (labelSpan)
          labelSpan.textContent = data.supported ? "Supported" : "Support";
      }
    } catch (e) {
      showToast("Could not update support.", "error");
    }
  });

  /* ---- THREAD BOOKMARK ---- */

  const threadBookmarkBtn = document.getElementById("thread-bookmark-btn");

  threadBookmarkBtn?.addEventListener("click", async () => {
    const fd = new FormData();
    fd.append("thread_id", THREAD_ID);

    try {
      const res = await fetch(
        "../../backend/controllers/ToggleBookmarkController.php",
        { method: "POST", body: fd }
      );
      const data = await res.json();
      if (data.status === "success") {
        threadBookmarkBtn.classList.toggle("active", data.bookmarked);
        threadBookmarkBtn.title = data.bookmarked
          ? "Remove bookmark"
          : "Bookmark this thread";
        const labelSpan = threadBookmarkBtn.querySelector(".bm-label");
        if (labelSpan) {
          labelSpan.textContent = data.bookmarked ? "Bookmarked" : "Bookmark";
        }
      }
    } catch (e) {
      showToast("Could not update bookmark.", "error");
    }
  });

  /* ---- COMMENT SUPPORT ---- */

  function bindCommentSupportButtons(container) {
    container.querySelectorAll(".comment-support-btn").forEach((btn) => {
      if (btn.dataset.bound) return;
      btn.dataset.bound = "1";

      btn.addEventListener("click", async () => {
        const commentId = btn.dataset.commentId;
        const fd = new FormData();
        fd.append("type", "comment");
        fd.append("id", commentId);

        try {
          const res = await fetch(
            "../../backend/controllers/ToggleSupportController.php",
            { method: "POST", body: fd }
          );
          const data = await res.json();
          if (data.status === "success") {
            btn.classList.toggle("active", data.supported);
            btn.querySelector(".comment-support-count").textContent =
              data.total;
          }
        } catch (e) {
          showToast("Could not update support.", "error");
        }
      });
    });
  }

  bindCommentSupportButtons(
    document.getElementById("comment-list") ?? document
  );

  /* ---- REPLY TOGGLE ---- */

  function bindReplyUI(commentEl) {
    if (commentEl.dataset.replyBound) return;
    commentEl.dataset.replyBound = "1";

    const commentId = commentEl.id.replace("comment-", "");
    const toggleBtn = commentEl.querySelector(".reply-toggle-btn");
    const replyBox = document.getElementById(`reply-box-${commentId}`);
    const cancelBtn = replyBox?.querySelector(".btn-cancel-reply");
    const submitBtn = replyBox?.querySelector(".btn-submit-reply");
    const textarea = replyBox?.querySelector(".inline-reply-textarea");
    const replyList = document.getElementById(`reply-list-${commentId}`);

    if (!toggleBtn || !replyBox) return;

    toggleBtn.addEventListener("click", () => {
      const isOpen = replyBox.style.display !== "none";
      replyBox.style.display = isOpen ? "none" : "block";
      if (!isOpen) textarea?.focus();
    });

    cancelBtn?.addEventListener("click", () => {
      replyBox.style.display = "none";
      if (textarea) textarea.value = "";
    });

    submitBtn?.addEventListener("click", async () => {
      const message = textarea?.value.trim();
      if (!message || message.length < 2) {
        if (textarea) textarea.style.borderColor = "#e11d48";
        textarea?.focus();
        return;
      }
      if (textarea) textarea.style.borderColor = "";

      const labelEl = submitBtn.querySelector(".reply-submit-label");
      if (labelEl) labelEl.textContent = "Posting…";
      submitBtn.disabled = true;

      const fd = new FormData();
      fd.append("comment_id", commentId);
      fd.append("message", message);

      try {
        const res = await fetch(
          "../../backend/controllers/PostReplyController.php",
          { method: "POST", body: fd }
        );
        const data = await res.json();

        if (data.status === "success") {
          if (textarea) textarea.value = "";
          replyBox.style.display = "none";

          const r = data.reply;
          const dateStr = new Date(r.created_at).toLocaleString("en-US", {
            month: "short",
            day: "numeric",
            year: "numeric",
            hour: "numeric",
            minute: "2-digit",
            hour12: true,
          });
          const initials = (r.first_name?.[0] ?? "U").toUpperCase();
          const fullName = `${r.first_name} ${r.last_name}`;

          const item = document.createElement("div");
          item.className = `reply-item${
            r.is_mod_comment ? " reply-item--mod" : ""
          }`;
          item.id = `reply-${r.id}`;
          item.innerHTML = `
            <div class="reply-avatar">${initials}</div>
            <div class="reply-body">
              <div class="comment-header">
                <span class="comment-author">${escapeHtml(fullName)}</span>
                ${
                  r.is_mod_comment
                    ? '<span class="mod-reply-badge">SK Official</span>'
                    : ""
                }
                <time class="comment-date" datetime="${
                  r.created_at
                }">${dateStr}</time>
              </div>
              <div class="comment-text">${escapeHtml(r.message).replace(
                /\n/g,
                "<br>"
              )}</div>
            </div>
          `;

          replyList?.appendChild(item);
          item.scrollIntoView({ behavior: "smooth", block: "end" });
          showToast("Reply posted!", "success");
        } else {
          showToast(data.message || "Could not post reply.", "error");
        }
      } catch (e) {
        showToast("Network error. Try again.", "error");
      } finally {
        if (labelEl) labelEl.textContent = "Post Reply";
        submitBtn.disabled = false;
      }
    });

    // Allow Ctrl+Enter inside reply textarea
    textarea?.addEventListener("keydown", (e) => {
      if (e.key === "Enter" && (e.ctrlKey || e.metaKey)) submitBtn?.click();
    });
  }

  // Bind reply UI on all server-rendered comments
  document.querySelectorAll(".comment-item").forEach((el) => bindReplyUI(el));

  /* ---- POST COMMENT ---- */

  const replyTextarea = document.getElementById("reply-textarea");
  const replySubmit = document.getElementById("reply-submit-btn");
  const replyLabel = document.getElementById("reply-label");
  const commentList = document.getElementById("comment-list");
  const commentCount = document.getElementById("comments-count");
  const noComments = document.getElementById("no-comments");

  replySubmit?.addEventListener("click", async () => {
    const message = replyTextarea?.value.trim();
    if (!message || message.length < 2) {
      replyTextarea.style.borderColor = "#e11d48";
      replyTextarea.focus();
      return;
    }
    replyTextarea.style.borderColor = "";

    replyLabel.textContent = "Posting…";
    replySubmit.disabled = true;

    const fd = new FormData();
    fd.append("thread_id", THREAD_ID);
    fd.append("message", message);

    try {
      const res = await fetch(
        "../../backend/controllers/PostCommentController.php",
        { method: "POST", body: fd }
      );
      const data = await res.json();

      if (data.status === "success") {
        replyTextarea.value = "";
        noComments?.remove();

        const c = data.comment;
        const dateStr = new Date(c.created_at).toLocaleString("en-US", {
          month: "short",
          day: "numeric",
          year: "numeric",
          hour: "numeric",
          minute: "2-digit",
          hour12: true,
        });
        const initials = (c.first_name?.[0] ?? "U").toUpperCase();
        const fullName = `${c.first_name} ${c.last_name}`;

        const item = document.createElement("div");
        item.className = `comment-item${
          c.is_mod_comment ? " comment-item--mod" : ""
        }`;
        item.id = `comment-${c.id}`;
        // Newly posted comments are always the current user's own, so no report btn
        item.innerHTML = `
          <div class="comment-avatar">${initials}</div>
          <div class="comment-body">
            <div class="comment-header">
              <span class="comment-author">${escapeHtml(fullName)}</span>
              ${
                c.is_mod_comment
                  ? '<span class="mod-reply-badge">SK Official</span>'
                  : ""
              }
              <time class="comment-date" datetime="${
                c.created_at
              }">${dateStr}</time>
            </div>
            <div class="comment-text">${escapeHtml(c.message).replace(
              /\n/g,
              "<br>"
            )}</div>
            <div class="comment-actions">
              <button class="comment-support-btn" data-comment-id="${
                c.id
              }" title="Support this comment">
                  <img src="../../assets/img/handshake-icon.png" alt="Support" class="comment-support-icon">
                <span class="comment-support-count">0</span>
              </button>
              <button class="reply-toggle-btn" data-comment-id="${
                c.id
              }" title="Reply to this comment">
                💬 Reply
              </button>
            </div>
            <div class="reply-list" id="reply-list-${c.id}"></div>
            <div class="inline-reply-box" id="reply-box-${
              c.id
            }" style="display:none;">
              <textarea
                class="concern-textarea reply-textarea inline-reply-textarea"
                rows="2"
                placeholder="Write a reply…"
                data-comment-id="${c.id}"
              ></textarea>
              <div class="inline-reply-footer">
                <button class="btn-cancel-reply" data-comment-id="${
                  c.id
                }">Cancel</button>
                <button class="btn-submit-reply btn-primary-portal" data-comment-id="${
                  c.id
                }">
                  <span class="reply-submit-label">Post Reply</span>
                </button>
              </div>
            </div>
          </div>
        `;

        commentList?.appendChild(item);
        // Re-sort: mod comments always stay above regular comments
        if (commentList) {
          const items = Array.from(
            commentList.querySelectorAll(".comment-item")
          );
          items.sort(
            (a, b) =>
              (b.classList.contains("comment-item--mod") ? 1 : 0) -
              (a.classList.contains("comment-item--mod") ? 1 : 0)
          );
          items.forEach((el) => commentList.appendChild(el));
        }
        bindCommentSupportButtons(item);
        bindReplyUI(item);

        if (commentCount) {
          const curr = parseInt(commentCount.textContent) || 0;
          commentCount.textContent = curr + 1;
        }

        item.scrollIntoView({ behavior: "smooth", block: "end" });
        showToast("Comment posted!", "success");
      } else {
        showToast(data.message || "Could not post comment.", "error");
      }
    } catch (e) {
      showToast("Network error. Try again.", "error");
    } finally {
      replyLabel.textContent = "Post Comment";
      replySubmit.disabled = false;
    }
  });

  // Ctrl+Enter on main comment textarea
  replyTextarea?.addEventListener("keydown", (e) => {
    if (e.key === "Enter" && (e.ctrlKey || e.metaKey)) replySubmit.click();
  });

  /* ---- IMAGE CAROUSEL ---- */

  (function initCarousel() {
    const grid = document.querySelector(".thread-images-grid");
    if (!grid) return;

    const items = Array.from(grid.querySelectorAll(".thread-image-item"));
    if (!items.length) return;

    const slides = items.map((item) => ({
      src: item.dataset.src || item.querySelector("img")?.src,
      alt: item.querySelector("img")?.alt || "",
    }));

    // Single image — no carousel chrome needed
    if (slides.length === 1) {
      const { src, alt } = slides[0];
      const wrap = document.createElement("div");
      wrap.className = "thread-carousel single-image-mode";
      wrap.innerHTML = `
        <div class="carousel-track-wrap">
          <div class="carousel-track">
            <div class="carousel-slide active">
              <img src="${src}" alt="${alt}">
            </div>
          </div>
        </div>`;
      grid.replaceWith(wrap);
      wrap
        .querySelector(".carousel-slide")
        .addEventListener("click", () => openLightbox(src));
      return;
    }

    // Build peek carousel — track slides continuously, peek 20% on each side
    const carousel = document.createElement("div");
    carousel.className = "thread-carousel";
    carousel.innerHTML = `
      <div class="carousel-track-wrap">
        <div class="carousel-track">
          ${slides
            .map(
              (s, i) => `
            <div class="carousel-slide" data-index="${i}">
              <img src="${s.src}" alt="${s.alt}">
            </div>`
            )
            .join("")}
        </div>
        <button class="carousel-btn carousel-btn-prev" aria-label="Previous">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
          </svg>
        </button>
        <button class="carousel-btn carousel-btn-next" aria-label="Next">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
          </svg>
        </button>
      </div>
      <div class="carousel-dots">
        ${slides
          .map(
            (_, i) => `
          <button class="carousel-dot${
            i === 0 ? " active" : ""
          }" data-index="${i}" aria-label="Go to slide ${i + 1}"></button>`
          )
          .join("")}
      </div>`;

    grid.replaceWith(carousel);

    let current = 0;
    const track = carousel.querySelector(".carousel-track");
    const slideEls = carousel.querySelectorAll(".carousel-slide");
    const dotEls = carousel.querySelectorAll(".carousel-dot");
    const btnPrev = carousel.querySelector(".carousel-btn-prev");
    const btnNext = carousel.querySelector(".carousel-btn-next");

    function applyPosition(animated) {
      track.style.transition = animated
        ? "transform 0.32s cubic-bezier(0.25, 0.46, 0.45, 0.94)"
        : "none";
      track.style.transform = `translateX(${20 + current * -60}%)`;
    }

    function goTo(next) {
      next = ((next % slides.length) + slides.length) % slides.length;
      if (next === current) return;
      dotEls[current].classList.remove("active");
      slideEls[current].classList.remove("active");
      current = next;
      dotEls[current].classList.add("active");
      slideEls[current].classList.add("active");
      applyPosition(true);
    }

    slideEls[0].classList.add("active");
    applyPosition(false);

    btnPrev.addEventListener("click", () => goTo(current - 1));
    btnNext.addEventListener("click", () => goTo(current + 1));
    dotEls.forEach((dot) => {
      dot.addEventListener("click", () => goTo(parseInt(dot.dataset.index)));
    });

    carousel.setAttribute("tabindex", "0");
    carousel.addEventListener("keydown", (e) => {
      if (e.key === "ArrowLeft") goTo(current - 1);
      if (e.key === "ArrowRight") goTo(current + 1);
    });

    slideEls.forEach((slide, i) => {
      slide.addEventListener("click", () => {
        if (i === current) {
          openLightbox(slides[current].src);
        } else {
          goTo(i);
        }
      });
    });
  })();

  /* ---- LIGHTBOX ---- */

  const lightbox = document.getElementById("lightbox-overlay");
  const lightboxImg = document.getElementById("lightbox-img");
  const lightboxClose = document.getElementById("lightbox-close");

  function openLightbox(src) {
    if (!src || !lightbox) return;
    lightboxImg.src = src;
    lightbox.style.display = "flex";
    document.body.style.overflow = "hidden";
  }

  lightboxClose?.addEventListener("click", closeLightbox);
  lightbox?.addEventListener("click", (e) => {
    if (e.target === lightbox) closeLightbox();
  });

  function closeLightbox() {
    if (!lightbox) return;
    lightbox.style.display = "none";
    document.body.style.overflow = "";
    lightboxImg.src = "";
  }

  /* ---- REPORT MODAL ---- */

  const reportOverlay = document.getElementById("report-modal-overlay");
  const reportClose = document.getElementById("report-modal-close");
  const reportCancel = document.getElementById("report-modal-cancel");
  const reportSubmit = document.getElementById("report-modal-submit");
  const reportLabel = document.getElementById("report-submit-label");
  const reportNote = document.getElementById("report-note");
  const reportCatError = document.getElementById("report-category-error");

  // State: what we're currently reporting
  let _reportType = null;
  let _reportTarget = null;

  function openReportModal(reportType, targetId) {
    _reportType = reportType;
    _reportTarget = targetId;

    // Reset state
    document
      .querySelectorAll("input[name='report-category']")
      .forEach((r) => (r.checked = false));
    if (reportNote) reportNote.value = "";
    if (reportCatError) reportCatError.textContent = "";

    const title = document.getElementById("report-modal-title");
    if (title) {
      title.textContent =
        reportType === "thread"
          ? "Report Thread"
          : reportType === "comment"
          ? "Report Comment"
          : "Report Reply";
    }

    reportOverlay.style.display = "flex";
    document.body.style.overflow = "hidden";
  }

  function closeReportModal() {
    reportOverlay.style.display = "none";
    document.body.style.overflow = "";
    _reportType = null;
    _reportTarget = null;
  }

  reportClose?.addEventListener("click", closeReportModal);
  reportCancel?.addEventListener("click", closeReportModal);
  reportOverlay?.addEventListener("click", (e) => {
    if (e.target === reportOverlay) closeReportModal();
  });

  reportSubmit?.addEventListener("click", async () => {
    const selected = document.querySelector(
      "input[name='report-category']:checked"
    );

    if (!selected) {
      if (reportCatError)
        reportCatError.textContent = "Please select a reason for your report.";
      return;
    }
    if (reportCatError) reportCatError.textContent = "";

    reportLabel.textContent = "Submitting…";
    reportSubmit.disabled = true;

    const fd = new FormData();
    fd.append("report_type", _reportType);
    fd.append("target_id", _reportTarget);
    fd.append("category", selected.value);
    fd.append("note", reportNote?.value.trim() ?? "");

    try {
      const res = await fetch(
        "../../backend/controllers/SubmitReportController.php",
        { method: "POST", body: fd }
      );
      const data = await res.json();

      if (data.status === "success") {
        closeReportModal();
        showToast(data.message, "success");
      } else {
        showToast(data.message || "Could not submit report.", "error");
      }
    } catch (e) {
      showToast("Network error. Try again.", "error");
    } finally {
      reportLabel.textContent = "Submit Report";
      reportSubmit.disabled = false;
    }
  });

  // Escape key closes report modal
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      closeLightbox();
      closeReportModal();
    }
  });

  /* ---- BIND REPORT BUTTONS ---- */

  /**
   * Attaches click handlers to all .content-report-btn and
   * #thread-report-btn elements inside a given container.
   * Safe to call multiple times — checks data-report-bound.
   */
  function bindReportButtons(container) {
    container
      .querySelectorAll(
        ".content-report-btn, #thread-report-btn, .thread-report-btn"
      )
      .forEach((btn) => {
        if (btn.dataset.reportBound) return;
        btn.dataset.reportBound = "1";

        btn.addEventListener("click", () => {
          const type = btn.dataset.reportType;
          const targetId = btn.dataset.targetId;
          if (!type || !targetId) return;
          openReportModal(type, targetId);
        });
      });
  }

  // Bind on page load
  bindReportButtons(document);

  /* ---- UTIL ---- */

  function escapeHtml(str) {
    const d = document.createElement("div");
    d.appendChild(document.createTextNode(str));
    return d.innerHTML;
  }
});
