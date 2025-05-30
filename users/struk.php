<?php
include "koneksi.php";
session_start();

// Cek login user
if (!isset($_SESSION['id_users'])) {
    echo "<script>alert('Silakan login dulu'); window.location.href='login.php';</script>";
    exit;
}

$id_users = $_SESSION['id_users'];

// Cek jika ada id_pemesanan di URL
if (!isset($_GET['id_pemesanan'])) {
    echo "<script>alert('ID Pemesanan tidak ditemukan'); window.location.href='riwayat.php';</script>";
    exit;
}

$id_pemesanan = $_GET['id_pemesanan'];

// Ambil detail pemesanan
$sql = "SELECT p.*, pr.nama AS nama_produk, pr.foto, bayar.bukti_pembayaran AS bukti_bayar, bayar.status AS status_pembayaran
        FROM pemesanan p
        JOIN produk pr ON p.id_produk = pr.id_produk
        LEFT JOIN pembayaran bayar ON p.id_pemesanan = bayar.id_pemesanan
        WHERE p.id_users = '$id_users' AND p.id_pemesanan = '$id_pemesanan'";

$query = mysqli_query($koneksi, $sql);
$pesanan = mysqli_fetch_assoc($query);

if (!$pesanan) {
    echo "<script>alert('Data pemesanan tidak ditemukan'); window.location.href='riwayat.php';</script>";
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
        .container {
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #f9f9f9;
        }
        .struk h2 {
            text-align: center;
        }
        .struk img {
            width: 120px;
            display: block;
            margin: 10px auto;
        }
        .struk table {
            width: 100%;
            border-collapse: collapse;
        }
        .struk table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .status {
            font-weight: bold;
            color: blue;
        }
        .bayar-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 8px 15px;
            background-color: green;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .bukti {
            text-align: center;
            margin-top: 20px;
        }
        .bukti img {
            max-width: 300px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="struk">
            <h2>Struk Pembayaran</h2>
            <img src="../uploads/<?= $pesanan['foto'] ?>" alt="<?= $pesanan['nama_produk'] ?>">
            <table>
                <tr>
                    <td><strong>Nama Produk</strong></td>
                    <td><?= $pesanan['nama_produk'] ?></td>
                </tr>
                <tr>
                    <td><strong>Tanggal Pemesanan</strong></td>
                    <td><?= $pesanan['tanggal_pemesanan'] ?></td>
                </tr>
                <tr>
                    <td><strong>Jumlah Produk</strong></td>
                    <td><?= $pesanan['jumlah_produk'] ?></td>
                </tr>
                <tr>
                    <td><strong>Total Bayar</strong></td>
                    <td>Rp <?= number_format($pesanan['total_bayar'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td><strong>Status Pembayaran</strong></td>
                    <td><span class="status"><?= $pesanan['status_pembayaran'] ?></span></td>
                </tr>
                <tr>
                    <td><strong>Status Pesanan</strong></td>
                    <td><?= $pesanan['status'] ?? '-' ?></td>
                </tr>
            </table>

            <?php if (!empty($pesanan['bukti_bayar'])) { ?>
                <div class="bukti">
                    <h3>Bukti Pembayaran</h3>
                    <img src="../uploads/<?= $pesanan['bukti_bayar'] ?>" alt="Bukti Pembayaran">
                </div>
            <?php } else { ?>
                <p style="color:red; text-align:center;">Belum ada bukti pembayaran</p>
            <?php } ?>

            <?php if ($pesanan['status'] == 'Menunggu Pembayaran') { ?>
                <a href="pembayaran.php?id_pemesanan=<?= $pesanan['id_pemesanan'] ?>" class="bayar-btn">Bayar Sekarang</a>
            <?php } ?>
        </div>
    </div>
</body>
</html>
