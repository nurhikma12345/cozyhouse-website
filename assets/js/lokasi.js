// ===== HALAMAN LOKASI: status buka/tutup & salin alamat =====
(function () {
  const OPEN = 11,
    CLOSE = 23; // jam operasional 11.00 – 23.00
  const status = document.getElementById("status-buka");
  if (status) {
    // Jam di Palopo (WITA, UTC+8) agar akurat di zona waktu mana pun
    const hour = Number(
      new Intl.DateTimeFormat("en-GB", {
        hour: "2-digit",
        hour12: false,
        timeZone: "Asia/Makassar",
      }).format(new Date()),
    );
    const isOpen = hour >= OPEN && hour < CLOSE;
    status.textContent = isOpen
      ? "Buka sekarang"
      : "Tutup, buka lagi pukul 11.00";
    status.classList.toggle("open", isOpen);
  }

  const copyBtn = document.getElementById("salin-alamat");
  if (copyBtn)
    copyBtn.addEventListener("click", async () => {
      const text = document.getElementById("alamat").textContent.trim();
      try {
        await navigator.clipboard.writeText(text);
        copyBtn.textContent = "Alamat disalin";
      } catch {
        copyBtn.textContent = "Gagal menyalin";
      }
      setTimeout(() => (copyBtn.textContent = "Salin alamat"), 2000);
    });
})();
