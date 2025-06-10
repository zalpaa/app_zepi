<?php
session_start();
include "koneksi.php";

// Pastikan user sudah login
$id_users = $_SESSION['id_users'] ?? 1; // Ganti 1 dengan ID User login jika ada sistem login
$id_produk = $_GET['id_produk'];
$ukuran = $_GET['ukuran'] ?? 'M';
$jumlah = 1; // Default tambah 1 item

// Cek apakah produk dengan ukuran yang sama sudah ada di keranjang
$cek = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_users='$id_users' AND id_produk='$id_produk' AND ukuran='$ukuran'");
if(mysqli_num_rows($cek) > 0){
    // Jika sudah ada, update jumlah_produk
    mysqli_query($koneksi, "UPDATE keranjang SET jumlah_produk = jumlah_produk + $jumlah WHERE id_users='$id_users' AND id_produk='$id_produk' AND ukuran='$ukuran'");
} else {
    // Jika belum ada, insert baru
    mysqli_query($koneksi, "INSERT INTO keranjang (id_users, id_produk, ukuran, jumlah_produk) VALUES ('$id_users', '$id_produk', '$ukuran', '$jumlah')");
}

header("Location: keranjang.php");
exit;
?>
