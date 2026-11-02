// ===== Sidebar (mobile) =====
(function () {
  const burger = document.getElementById("burger");
  const sidebar = document.getElementById("sidebar");
  if (!burger || !sidebar) return;
  const set = (open) => {
    sidebar.classList.toggle("open", open);
    burger.setAttribute("aria-expanded", String(open));
  };
  burger.addEventListener("click", () => set(!sidebar.classList.contains("open")));
  document.addEventListener("keydown", (e) => e.key === "Escape" && set(false));
  document.addEventListener("click", (e) => {
    if (sidebar.classList.contains("open") && !sidebar.contains(e.target) && e.target !== burger) set(false);
  });
})();

// ===== Konfirmasi sebelum hapus =====
document.addEventListener("submit", (e) => {
  const msg = e.target.dataset && e.target.dataset.confirm;
  if (msg && !window.confirm(msg)) e.preventDefault();
});

// ===== Pratinjau foto sebelum diunggah =====
document.querySelectorAll("input[type=file][data-preview]").forEach((input) => {
  input.addEventListener("change", () => {
    const box = document.getElementById(input.dataset.preview);
    const file = input.files && input.files[0];
    if (!box || !file) return;
    if (file.size > 3 * 1024 * 1024) {
      alert("Ukuran foto maksimal 3 MB.");
      input.value = "";
      return;
    }
    const img = document.createElement("img");
    img.alt = "Pratinjau";
    img.src = URL.createObjectURL(file);
    box.replaceChildren(img);
  });
});
