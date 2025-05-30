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
    <style>
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
        }
        .pesanan {
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 15px;
            display: flex;
            align-items: center;
        }
        .pesanan img {
            width: 100px;
            margin-right: 20px;
        }
        .pesanan-info h3 {
            margin: 0;
        }
        .pesanan-info p {
            margin: 5px 0;
        }
        .status {
            font-weight: bold;
            color: blue;
        }
        .btn {
            margin-top: 10px;
            padding: 5px 10px;
            background-color: green;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .btn-struk {
            background-color: blue;
        }
        .btn-cek {
            background-color: orange;
        }
        .btn-bayar {
            background-color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Riwayat Pesanan Anda</h1>

        <?php if (mysqli_num_rows($query) > 0) { ?>
            <?php while ($pesanan = mysqli_fetch_assoc($query)) { ?>
                <div class="pesanan">
                    <img src="../uploads/<?= $pesanan['foto'] ?>" alt="<?= $pesanan['nama_produk'] ?>">
                    <div class="pesanan-info">
                        <h3><?= $pesanan['nama_produk'] ?></h3>
                        <p>Tanggal: <?= $pesanan['tanggal_pemesanan'] ?></p>
                        <p>Jumlah: <?= $pesanan['jumlah_produk'] ?></p>
                        <p>Total Bayar: Rp <?= number_format($pesanan['total_bayar'], 0, ',', '.') ?></p>
                        <p>Status Pembayaran: <span class="status"><?= $pesanan['status_pembayaran'] ?? 'Belum Dibayar' ?></span></p>
                        <p>Status Pesanan: <span class="status"><?= $pesanan['status_pesanan'] ?></span></p>

                        <!-- Tombol sesuai status -->
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
</body>
</html>
