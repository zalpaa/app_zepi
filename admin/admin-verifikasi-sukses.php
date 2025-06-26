<?php
session_start();
include "koneksi.php";

// Cek login admin
if (!isset($_SESSION['id'])) {
    header("Location: login.php?pesan=logindulu");
    exit;
}

// Cek ID pembayaran
if (!isset($_GET['id'])) {
    echo "<script>alert('ID pembayaran tidak ditemukan.'); history.back();</script>";
    exit;
}

$id_pembayaran = $_GET['id'];

// Ambil id_pemesanan dari pembayaran
$result = mysqli_query($koneksi, "SELECT id_pemesanan FROM pembayaran WHERE id_pembayaran = '$id_pembayaran'");
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>alert('Data pembayaran tidak ditemukan.'); history.back();</script>";
    exit;
}

$id_pemesanan = $data['id_pemesanan'];

// Update status pembayaran jadi 'dibayar'
$updatePembayaran = mysqli_query($koneksi, "UPDATE pembayaran SET status = 'dibayar' WHERE id_pembayaran = '$id_pembayaran'");

// Update status pemesanan jadi 'dikemas'
$updatePemesanan = mysqli_query($koneksi, "UPDATE pemesanan SET status = 'dikemas' WHERE id_pemesanan = '$id_pemesanan'");

if ($updatePembayaran && $updatePemesanan) {
    echo "<script>alert('Pembayaran berhasil diverifikasi. Pesanan kini dikemas.'); window.location.href='admin-dashboard.php?page=verifikasi';</script>";
} else {
    echo "<script>alert('Gagal memperbarui status.'); history.back();</script>";
}
?>
