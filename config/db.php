<?php
// Koneksi database (Laragon: user "root", password kosong).
$host     = "localhost";
$user     = "root";
$password = "";
$database = "cozyhouse_db";

// Ekstensi mysqli tidak aktif -> pakai data cadangan, jangan mati.
if (!class_exists('mysqli')) {
    $conn = null;
    return;
}

// Matikan exception bawaan PHP 8.1+ agar website tetap tampil
// (memakai data cadangan) walaupun database belum diimpor.
mysqli_report(MYSQLI_REPORT_OFF);

$conn = @new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    error_log("CozyHouse: koneksi database gagal - " . $conn->connect_error);
    $conn = null;
} else {
    $conn->set_charset("utf8mb4");
}
