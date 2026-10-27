// ===== HALAMAN GALERI: lightbox =====
(function () {
  const photos = [...document.querySelectorAll(".gallery .photo img")];
  if (!photos.length) return;
  let index = 0;

  const box = document.createElement("div");
  box.className = "lightbox";
  box.hidden = true;
  box.setAttribute("role", "dialog");
  box.setAttribute("aria-modal", "true");
  box.setAttribute("aria-label", "Pratinjau foto");
  box.innerHTML = `
    <button class="lb-close" aria-label="Tutup">&times;</button>
    <button class="lb-prev" aria-label="Foto sebelumnya">&#8249;</button>
    <figure><img alt=""><figcaption></figcaption></figure>
    <button class="lb-next" aria-label="Foto berikutnya">&#8250;</button>`;
  document.body.appendChild(box);

  const img = box.querySelector("img");
  const caption = box.querySelector("figcaption");

  const show = (i) => {
    index = (i + photos.length) % photos.length;
    img.src = photos[index].src;
    img.alt = photos[index].alt;
    caption.textContent = `${photos[index].alt} (${index + 1}/${photos.length})`;
  };
  const open = (i) => {
    show(i);
    box.hidden = false;
    document.body.style.overflow = "hidden";
    box.querySelector(".lb-close").focus();
  };
  const close = () => {
    box.hidden = true;
    document.body.style.overflow = "";
    photos[index].closest(".photo").focus();
  };

  photos.forEach((p, i) => {
    const wrap = p.closest(".photo");
    wrap.tabIndex = 0;
    wrap.style.cursor = "zoom-in";
    wrap.addEventListener("click", () => open(i));
    wrap.addEventListener("keydown", (e) => {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        open(i);
      }
    });
  });

  box.querySelector(".lb-close").addEventListener("click", close);
  box
    .querySelector(".lb-prev")
    .addEventListener("click", () => show(index - 1));
  box
    .querySelector(".lb-next")
    .addEventListener("click", () => show(index + 1));
  box.addEventListener("click", (e) => {
    if (e.target === box) close();
  });
  document.addEventListener("keydown", (e) => {
    if (box.hidden) return;
    if (e.key === "Escape") close();
    if (e.key === "ArrowLeft") show(index - 1);
    if (e.key === "ArrowRight") show(index + 1);
  });
})();
