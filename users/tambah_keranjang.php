<?php
include "koneksi.php";
session_start();

// Cek login user
if (!isset($_SESSION['id_users'])) {
    echo "<script>alert('Silakan login dulu'); window.location.href='login.php';</script>";
    exit;
}

$id_produk = $_GET['id_produk'];
$id_users = $_SESSION['id_users'];
$tanggal = date("Y-m-d");

// Cek apakah produk sudah ada di keranjang
$cek = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_produk='$id_produk' AND id_users='$id_users'");
if (mysqli_num_rows($cek) > 0) {
    // Jika sudah ada, tambahkan jumlah
    mysqli_query($koneksi, "UPDATE keranjang SET jumlah=jumlah+1 WHERE id_produk='$id_produk' AND id_users='$id_users'");
} else {
    // Jika belum ada, tambahkan baru
    mysqli_query($koneksi, "INSERT INTO keranjang (id_users, id_produk, jumlah, tanggal) VALUES ('$id_users', '$id_produk', 1, '$tanggal')");
}

echo "<script>alert('Produk ditambahkan ke keranjang'); window.location.href='keranjang.php';</script>";
