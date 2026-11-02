<?php
require __DIR__ . '/includes/bootstrap.php';
wajib_login($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_wajib();
    $id = (int) ($_POST['id'] ?? 0);
    $stmt = $conn->prepare('DELETE FROM menu WHERE id_menu = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    flash($stmt->affected_rows ? 'success' : 'error', $stmt->affected_rows ? 'Menu dihapus.' : 'Menu tidak ditemukan.');
}
redirect('menu.php');
