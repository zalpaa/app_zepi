<?php
include "koneksi.php";

$id_produk = $_GET['id_produk'];

// Ambil semua id_pemesanan yang terkait dengan produk ini
$result = mysqli_query($koneksi, "SELECT id_pemesanan FROM pemesanan WHERE id_produk = '$id_produk'");
while ($row = mysqli_fetch_assoc($result)) {
    $id_pemesanan = $row['id_pemesanan'];

    // Hapus pembayaran terkait pemesanan ini
    mysqli_query($koneksi, "DELETE FROM pembayaran WHERE id_pemesanan = '$id_pemesanan'");
}

// Hapus pemesanan terkait produk ini (atau yang terkait keranjang produk)
mysqli_query($koneksi, "DELETE FROM pemesanan WHERE id_produk = '$id_produk' OR id_keranjang IN (SELECT id_keranjang FROM keranjang WHERE id_produk = '$id_produk')");

// Hapus keranjang terkait produk ini
mysqli_query($koneksi, "DELETE FROM keranjang WHERE id_produk = '$id_produk'");

// Hapus produk
mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk = '$id_produk'");

// Redirect
header("location:dashboard.php");
exit;
?>
