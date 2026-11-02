<?php
require __DIR__ . '/includes/bootstrap.php';
wajib_login($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_wajib();
    $id = (int) ($_POST['id'] ?? 0);
    $stmt = $conn->prepare('DELETE FROM galeri WHERE id_galeri = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    flash($stmt->affected_rows ? 'success' : 'error', $stmt->affected_rows ? 'Foto dihapus dari galeri.' : 'Foto tidak ditemukan.');
}
redirect('galeri.php');
