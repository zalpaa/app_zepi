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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f0f4f8;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .container-card  {
        max-width: 700px;
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    h2 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .struk img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        display: block;
        margin: 0 auto 20px auto;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table td {
        padding: 12px 8px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    table td:first-child {
        color: #555;
        width: 40%;
        font-weight: 500;
    }

    table td:last-child {
        text-align: right;
        color: #333;
    }

    .status {
        display: inline-block;
        padding: 5px 12px;
        background-color: #3498db;
        color: #fff;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .bayar-btn {
        display: block;
        width: 100%;
        text-align: center;
        margin-top: 20px;
        padding: 12px 0;
        background: linear-gradient(to right, #27ae60, #2ecc71);
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.2s ease, background 0.3s ease;
    }

    .bayar-btn:hover {
        transform: translateY(-3px);
        background: linear-gradient(to right, #2ecc71, #27ae60);
    }

    .bukti {
        text-align: center;
        margin-top: 25px;
    }

    .bukti img {
        max-width: 300px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    p.no-bukti {
        color: red;
        text-align: center;
        font-weight: 500;
        margin-top: 20px;
    }

    @media(max-width: 600px) {
        .container {
            margin: 20px;
            padding: 20px;
        }

        table td {
            display: block;
            width: 100%;
            text-align: left;
            border: none;
            padding: 8px 0;
        }

        table td:last-child {
            text-align: left;
            margin-top: -8px;
        }
    }
</style>

</head>
<body>

    
<!-- Header -->
<header class="bg-white fixed w-full shadow-md z-10">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">FLAZ</h1>
        <nav>
            <ul class="flex space-x-6">
                <li><a href="./home.php" class="text-gray-600 hover:text-gray-900">Home</a></li>
                <li><a href="./produk.php" class="text-gray-600 hover:text-gray-900">Produk</a></li>
                <li><a href="./about.php" class="text-gray-600 hover:text-gray-900">Tentang Kami</a></li>
                <li><a href="./kontak.php" class="text-gray-600 hover:text-gray-900">Kontak</a></li>
            </ul>
        </nav>
    </div>
</header>


<div class="w-screen flex justify-center pt-20">
        <div class="container-card w-full">
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
</div>
</body>
</html>
