<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_users'])) {
    echo "<script>alert('Silakan login terlebih dahulu.'); window.location='login.php';</script>";
    exit;
}

$id_users = $_SESSION['id_users'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan']);
    $id_jasa_kurir = mysqli_real_escape_string($koneksi, $_POST['id_jasa_kurir']);
    $tanggal_pemesanan = date("Y-m-d H:i:s");

    // Ambil isi keranjang user
    $keranjang = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_users='$id_users'");

    // Cek apakah keranjang kosong
    if(mysqli_num_rows($keranjang) == 0){
        echo "<script>alert('Keranjang Anda kosong!'); window.location='keranjang.php';</script>";
        exit;
    }

    while ($row = mysqli_fetch_assoc($keranjang)) {
        $id_produk = $row['id_produk'];
        $id_keranjang = $row['id_keranjang'];
        $jumlah_produk = $row['jumlah_produk'];
        $ukuran = $row['ukuran'];

        $produk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'"));
        $harga = $produk['harga'];
        $diskon = 0;
        $total_harga = $harga * $jumlah_produk;
        $total_bayar = $total_harga - $diskon;

        $query = "INSERT INTO pemesanan 
            (id_users, id_produk, id_keranjang, tanggal_pemesanan, jumlah_produk, total_harga, diskon, total_bayar, ukuran, catatan, status, id_jasa_kurir, nama_lengkap, alamat, no_hp)
            VALUES
            ('$id_users', '$id_produk', '$id_keranjang', '$tanggal_pemesanan', '$jumlah_produk', '$total_harga', '$diskon', '$total_bayar', '$ukuran', '$catatan', 'pending', '$id_jasa_kurir', '$nama_lengkap', '$alamat', '$no_hp')";

        if (!mysqli_query($koneksi, $query)) {
            die("Gagal insert pemesanan: " . mysqli_error($koneksi));
        }

        // Ambil ID pemesanan terakhir dari loop ini
        $id_pemesanan_terakhir = mysqli_insert_id($koneksi);
    }

    // Kosongkan keranjang setelah checkout
    mysqli_query($koneksi, "DELETE FROM keranjang WHERE id_users='$id_users'");

    // Redirect ke pembayaran.php bawa ID pemesanan terakhir
    echo "<script>
        alert('Checkout berhasil! Silakan lakukan pembayaran.');
        window.location='pembayaran.php?id_pemesanan=$id_pemesanan_terakhir';
    </script>";
    exit;
}
?>
