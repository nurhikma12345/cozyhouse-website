// ===== HALAMAN MENU: filter kategori =====
(function () {
  const chips = document.querySelectorAll(".chip");
  const cards = document.querySelectorAll(".menu-card");
  const groupTitle = document.querySelector(".group-title");
  if (!chips.length) return;

  const apply = (cat) => {
    cards.forEach((card) =>
      card.classList.toggle("hide", cat !== "all" && card.dataset.cat !== cat),
    );

    // Sembunyikan grid yang kosong supaya tidak ada ruang kosong
    document.querySelectorAll(".menu-grid").forEach((grid) => {
      grid.hidden = !grid.querySelector(".menu-card:not(.hide)");
    });
    if (groupTitle) groupTitle.hidden = cat !== "all";
  };

  chips.forEach((chip) => {
    chip.setAttribute("aria-pressed", chip.classList.contains("active"));
    chip.addEventListener("click", () => {
      chips.forEach((c) => {
        c.classList.remove("active");
        c.setAttribute("aria-pressed", "false");
      });
      chip.classList.add("active");
      chip.setAttribute("aria-pressed", "true");
      apply(chip.dataset.filter);
    });
  });
})();
