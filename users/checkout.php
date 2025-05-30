<?php
include "koneksi.php";
session_start();

// Cek login user
if (!isset($_SESSION['id_users'])) {
    echo "<script>alert('Silakan login dulu'); window.location.href='login.php';</script>";
    exit;
}

$id_users = $_SESSION['id_users'];
$id_produk = $_GET['id_produk'];

// Cek apakah ada di keranjang
$keranjang = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_users='$id_users' AND id_produk='$id_produk' LIMIT 1");
$data_keranjang = mysqli_fetch_assoc($keranjang);

if (!$data_keranjang) {
    // Kalau tidak ada, tambahkan dulu
    $tanggal = date("Y-m-d");
    mysqli_query($koneksi, "INSERT INTO keranjang (id_users, id_produk, jumlah_produk, ukuran) VALUES ('$id_users', '$id_produk', 1, '$ukuran')");
    $id_keranjang = mysqli_insert_id($koneksi);
} else {
    $id_keranjang = $data_keranjang['id_keranjang'];
}

// Proses checkout form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jumlah_produk = $_POST['jumlah_produk'];
    $ukuran = $_POST['ukuran'];
    $catatan = $_POST['catatan'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $tanggal_pemesanan = date("Y-m-d H:i:s");
    $id_jasa_kurir = $_POST['id_jasa_kurir'];
    $diskon = 0; // Sesuaikan kalau ada
    $total_harga = $_POST['harga'] * $jumlah_produk;
    $total_bayar = $total_harga - $diskon ;

    $sql = "INSERT INTO pemesanan (id_users, id_produk, id_keranjang, tanggal_pemesanan, jumlah_produk, total_harga, diskon, total_bayar, ukuran, catatan, status, id_jasa_kurir, nama_lengkap, alamat, no_hp) 
            VALUES ('$id_users', '$id_produk', '$id_keranjang', '$tanggal_pemesanan', '$jumlah_produk', '$total_harga', '$diskon', '$total_bayar', '$ukuran', '$catatan', 'pending', '$id_jasa_kurir', '$nama_lengkap', '$alamat', '$no_hp')";
    if (mysqli_query($koneksi, $sql)) {
        $id_pemesanan = mysqli_insert_id($koneksi);
        echo '<script>alert("Pesanan berhasil!"); window.location.href="pembayaran.php?id_pemesanan=' . $id_pemesanan . '";</script>';
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
    exit;
}


// Ambil data produk
$produk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout Produk</h1>
    <p>Nama Produk: <?= $produk['nama'] ?></p>
    <p>Harga: Rp <?= number_format($produk['harga']) ?></p>

    <form method="POST">
    <input type="hidden" name="harga" value="<?= $produk['harga'] ?>">

    <label>Jumlah: <input type="number" name="jumlah_produk" value="1" min="1" required></label><br><br>

    <label>Ukuran: <input type="text" name="ukuran" required></label><br><br>

    <label>Catatan: <input type="text" name="catatan"></label><br><br>

    <label>Nama Lengkap: <input type="text" name="nama_lengkap" required></label><br><br>

    <label>Alamat Lengkap: <textarea name="alamat" required></textarea></label><br><br>

    <label>No. HP: <input type="text" name="no_hp" required></label><br><br>

    <label>Pilih Kurir:
        <select name="id_jasa_kurir" required>
            <option value="1">JNE</option>
            <option value="2">J&T</option>
            <option value="3">Sicepat</option>
        </select>
    </label><br><br>

    <button type="submit">Proses Checkout</button>
</form>

</body>
</html>
