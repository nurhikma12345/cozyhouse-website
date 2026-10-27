// ===== NAVBAR (dipakai di semua halaman) =====
(function () {
  const navbar = document.querySelector(".navbar");
  const toggle = document.querySelector(".nav-toggle");
  const links = document.querySelector(".nav-links");
  if (!navbar || !toggle || !links) return;

  const setOpen = (open) => {
    links.classList.toggle("open", open);
    toggle.setAttribute("aria-expanded", String(open));
    toggle.innerHTML = open ? "&times;" : "&#9776;";
  };

  toggle.addEventListener("click", () =>
    setOpen(!links.classList.contains("open")),
  );
  links.addEventListener("click", (e) => {
    if (e.target.closest("a")) setOpen(false);
  });
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") setOpen(false);
  });
  window.addEventListener("resize", () => {
    if (window.innerWidth > 860) setOpen(false);
  });

  // Bayangan tipis saat halaman di-scroll
  const onScroll = () =>
    navbar.classList.toggle("scrolled", window.scrollY > 8);
  onScroll();
  window.addEventListener("scroll", onScroll, { passive: true });
})();

// ===== Foto belum ada: tampilkan label placeholder =====
(function () {
  document.querySelectorAll(".photo img").forEach((img) => {
    const mark = () => {
      const wrap = img.closest(".photo");
      wrap.classList.add("no-img");
      wrap.dataset.label = img.alt;
      img.hidden = true;
    };
    if (img.complete && img.naturalWidth === 0) mark();
    else img.addEventListener("error", mark);
  });
})();
