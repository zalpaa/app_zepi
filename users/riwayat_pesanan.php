<?php
include "koneksi.php";
session_start();

// Cek login user
if (!isset($_SESSION['id_users'])) {
    echo "<script>alert('Silakan login dulu'); window.location.href='login.php';</script>";
    exit;
}

$id_users = $_SESSION['id_users'];

// Ambil data pemesanan user + status pembayaran
$sql = "SELECT 
            p.id_pemesanan, 
            p.tanggal_pemesanan, 
            p.jumlah_produk, 
            p.total_bayar, 
            p.status AS status_pesanan, 
            p.nama_lengkap, 
            p.alamat, 
            p.no_hp, 
            pr.nama AS nama_produk, 
            pr.foto,
            pay.status AS status_pembayaran, 
            pay.bukti_pembayaran
        FROM pemesanan p 
        JOIN produk pr ON p.id_produk = pr.id_produk 
        LEFT JOIN pembayaran pay ON p.id_pemesanan = pay.id_pemesanan 
        WHERE p.id_users = '$id_users'
        ORDER BY p.tanggal_pemesanan DESC";
$query = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .pesanan {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            padding: 20px;
            display: flex;
            gap: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 800px;
            min-width: 800px;
        }
        .pesanan:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .pesanan img {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            object-fit: cover;
        }
        .pesanan-info h3 {
            margin: 0 0 10px;
            font-weight: 600;
            color: #34495e;
        }
        .pesanan-info p {
            margin: 4px 0;
            font-size: 14px;
            color: #555;
        }
        .status {
            font-weight: 600;
            color: #2980b9;
        }
        .btn {
            margin-top: 10px;
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .btn:hover {
            transform: scale(1.05);
        }
        .btn-bayar {
            background-color: #27ae60;
            color: #fff;
        }
        .btn-struk {
            background-color: #3498db;
            color: #fff;
        }
        .btn-cek {
            background-color: #f39c12;
            color: #fff;
        }
        .btn-bayar:hover {
            background-color: #2ecc71;
        }
        .btn-struk:hover {
            background-color: #5dade2;
        }
        .btn-cek:hover {
            background-color: #f1c40f;
        }
        @media (max-width: 600px) {
            .pesanan {
                flex-direction: column;
                align-items: center;
            }
            .pesanan img {
                width: 100px;
                height: 100px;
            }
            .pesanan-info {
                text-align: center;
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

<!-- Main Content -->
<div class="min-h-screen flex items-center justify-center pt-32 px-4">
    <div class="container-card text-center">
        <h1 class="text-3xl font-semibold mb-8">Riwayat Pesanan Anda</h1>

        <div class="flex flex-col items-center">
            <?php if (mysqli_num_rows($query) > 0) { ?>
                <?php while ($pesanan = mysqli_fetch_assoc($query)) { ?>
                    <div class="pesanan">
                        <img src="../uploads/<?= $pesanan['foto'] ?>" alt="<?= $pesanan['nama_produk'] ?>">
                        <div class="pesanan-info text-left">
                            <h3><?= $pesanan['nama_produk'] ?></h3>
                            <p>Tanggal: <?= $pesanan['tanggal_pemesanan'] ?></p>
                            <p>Jumlah: <?= $pesanan['jumlah_produk'] ?></p>
                            <p>Total Bayar: Rp <?= number_format($pesanan['total_bayar'], 0, ',', '.') ?></p>
                            <p>Status Pembayaran: <span class="status"><?= $pesanan['status_pembayaran'] ?? 'Belum Dibayar' ?></span></p>
                            <p>Status Pesanan: <span class="status"><?= $pesanan['status_pesanan'] ?></span></p>

                            <?php if ($pesanan['status_pembayaran'] == 'belum dibayar' || $pesanan['status_pembayaran'] == NULL) { ?>
                                <a href="pembayaran.php?id_pemesanan=<?= $pesanan['id_pemesanan'] ?>" class="btn btn-bayar">Bayar Sekarang</a>
                            <?php } elseif ($pesanan['status_pembayaran'] == 'dibayar') { ?>
                                <a href="struk.php?id_pemesanan=<?= $pesanan['id_pemesanan'] ?>" class="btn btn-struk">Lihat Struk</a>
                            <?php } ?>
                            <a href="struk.php?id_pemesanan=<?= $pesanan['id_pemesanan'] ?>" class="btn btn-cek">Cek Status</a>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>Tidak ada pesanan.</p>
            <?php } ?>
        </div>
    </div>
</div>

</body>
</html>

