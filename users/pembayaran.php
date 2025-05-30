<?php
include "koneksi.php";
session_start();

// Cek login user
if (!isset($_SESSION['id_users'])) {
    echo "<script>alert('Silakan login dulu'); window.location.href='login.php';</script>";
    exit;
}

$id_pemesanan = $_GET['id_pemesanan'];

// Ambil detail pesanan
$sql = "SELECT p.*, pr.nama, pr.foto FROM pemesanan p 
        JOIN produk pr ON p.id_produk = pr.id_produk 
        WHERE p.id_pemesanan = '$id_pemesanan'";
$query = mysqli_query($koneksi, $sql);
$pemesanan = mysqli_fetch_assoc($query);

if (!$pemesanan) {
    echo "Pesanan tidak ditemukan.";
    exit;
}

// Proses form pembayaran
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $provider = $_POST['provider'];
    $status = 'pending';
    $status_pembayaran = 'menunggu konfirmasi';

    // Upload file bukti
    $bukti_name = $_FILES['bukti']['name'];
    $bukti_tmp = $_FILES['bukti']['tmp_name'];
    $bukti_ext = pathinfo($bukti_name, PATHINFO_EXTENSION);
    $bukti_new = 'bukti_' . time() . '.' . $bukti_ext;

    move_uploaded_file($bukti_tmp, '../uploads/' . $bukti_new);

    // Update status di pemesanan
    $update = mysqli_query($koneksi, "UPDATE pemesanan SET status='$status' WHERE id_pemesanan='$id_pemesanan'");

    // Masukkan ke tabel pembayaran
    $insert_bayar = mysqli_query($koneksi, "INSERT INTO pembayaran (id_pemesanan, provider, bukti_pembayaran, status) VALUES ('$id_pemesanan', '$provider', '$bukti_new', '$status_pembayaran')");

    if ($update && $insert_bayar) {
        echo "<script>alert('Pembayaran berhasil. Silakan tunggu konfirmasi.'); window.location.href='riwayat_pesanan.php';</script>";
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran</title>
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }
        .container h1 {
            text-align: center;
        }
        .produk {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .produk img {
            width: 100px;
            margin-right: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pembayaran</h1>

        <div class="produk">
            <img src="../uploads/<?= $pemesanan['foto'] ?>" alt="<?= $pemesanan['nama'] ?>">
            <div>
                <h3><?= $pemesanan['nama'] ?></h3>
                <p>Jumlah: <?= $pemesanan['jumlah_produk'] ?></p>
                <p>Total Bayar: Rp <?= number_format($pemesanan['total_bayar'], 0, ',', '.') ?></p>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="provider">Pilih provider Pembayaran:</label>
                <select name="provider" id="provider" required>
                    <option value="">--Pilih--</option>
                    <option value="bca">BCA</option>
                    <option value="bni">BNI</option>
                    <option value="bri">BRI</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="bukti">Upload Bukti Pembayaran:</label>
                <input type="file" name="bukti" id="bukti" accept="image/*" required>
            </div>

            <button type="submit">Konfirmasi Pembayaran</button>
        </form>
    </div>
</body>
</html>
