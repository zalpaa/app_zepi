<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_users'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login.php';</script>";
    exit;
}

$id_users = $_SESSION['id_users'];
$tanggal_pemesanan = date("Y-m-d H:i:s");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $checkout_items = $_POST['checkout_item'] ?? [];

    if (empty($checkout_items)) {
        echo "<script>alert('Pilih minimal 1 produk untuk di-checkout.'); window.location='keranjang.php';</script>";
        exit;
    }

    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan']);
    $id_jasa_kurir = mysqli_real_escape_string($koneksi, $_POST['id_jasa_kurir']);

    foreach ($checkout_items as $id_keranjang) {
        $query_keranjang = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_keranjang='$id_keranjang' AND id_users='$id_users'");
        if (mysqli_num_rows($query_keranjang) == 0) continue;

        $row = mysqli_fetch_assoc($query_keranjang);
        $id_produk = $row['id_produk'];
        $jumlah_produk = $row['jumlah_produk'];
        $ukuran = $row['ukuran'];

        // Ambil harga produk
        $query_produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
        $produk = mysqli_fetch_assoc($query_produk);
        $harga = $produk['harga'];
        $diskon = 0;
        $total_harga = $harga * $jumlah_produk;
        $total_bayar = $total_harga - $diskon;

        // Simpan ke pemesanan
        mysqli_query($koneksi, "INSERT INTO pemesanan (
                id_users, id_produk, id_keranjang, tanggal_pemesanan, jumlah_produk, 
                total_harga, diskon, total_bayar, ukuran, catatan, status, 
                id_jasa_kurir, nama_lengkap, alamat, no_hp
            ) VALUES (
                '$id_users', '$id_produk', '$id_keranjang', '$tanggal_pemesanan', '$jumlah_produk', 
                '$total_harga', '$diskon', '$total_bayar', '$ukuran', '$catatan', 'pending', 
                '$id_jasa_kurir', '$nama_lengkap', '$alamat', '$no_hp'
            )");

        // Hapus dari keranjang
        mysqli_query($koneksi, "DELETE FROM keranjang WHERE id_keranjang='$id_keranjang'");
    }

    // Redirect aman
    echo "<script>alert('Checkout berhasil! Silakan lanjutkan pembayaran.'); window.location='riwayat_pesanan.php';</script>";
    exit;
}
?>
