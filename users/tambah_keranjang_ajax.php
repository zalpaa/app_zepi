<?php
session_start();
include "koneksi.php";

header('Content-Type: application/json');

if (!isset($_SESSION['id_users'])) {
    echo json_encode(['status' => 'error', 'pesan' => 'Silakan login terlebih dahulu.']);
    exit;
}

$id_users = $_SESSION['id_users'];
$id_produk = $_POST['id_produk'] ?? 0;
$ukuran = $_POST['ukuran'] ?? '';
$jumlah = $_POST['jumlah'] ?? 1;

if (!$id_produk || !$ukuran || $jumlah < 1) {
    echo json_encode(['status' => 'error', 'pesan' => 'Data tidak lengkap.']);
    exit;
}

// Cek apakah produk sudah ada di keranjang dengan ukuran sama
$cek = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_users='$id_users' AND id_produk='$id_produk' AND ukuran='$ukuran'");
if (mysqli_num_rows($cek) > 0) {
    // Update jumlah
    mysqli_query($koneksi, "UPDATE keranjang SET jumlah_produk = jumlah_produk + $jumlah WHERE id_users='$id_users' AND id_produk='$id_produk' AND ukuran='$ukuran'");
    echo json_encode(['status' => 'success', 'pesan' => 'Jumlah produk berhasil diperbarui di keranjang.']);
} else {
    // Insert baru
    mysqli_query($koneksi, "INSERT INTO keranjang (id_users, id_produk, ukuran, jumlah_produk) VALUES ('$id_users', '$id_produk', '$ukuran', '$jumlah')");
    echo json_encode(['status' => 'success', 'pesan' => 'Produk berhasil ditambahkan ke keranjang.']);
}
?>
