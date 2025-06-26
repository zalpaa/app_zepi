<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_users'])) {
    echo "<script>alert('Silakan login dulu'); location='login.php';</script>";
    exit;
}

$id_pemesanan = $_GET['id_pemesanan'] ?? 0;
$sql = "SELECT p.*, pr.nama AS nama_produk, pr.harga, pr.foto 
        FROM pemesanan p 
        JOIN produk pr ON p.id_produk = pr.id_produk 
        WHERE p.id_pemesanan = '$id_pemesanan'";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tidak ditemukan";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Struk Pemesanan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 30px;
            color: #333;
        }
        .struk-wrapper {
            background: #fff;
            max-width: 700px;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .info, .produk {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
            font-size: 15px;
        }
        .produk-detail {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .produk-detail img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #ccc;
        }
        .produk-detail-info {
            flex: 1;
        }
        .produk-detail-info p {
            margin: 4px 0;
        }
        .total {
            font-size: 18px;
            font-weight: 600;
            color: #27ae60;
            margin-top: 10px;
        }
        .status {
            margin-top: 10px;
            font-weight: 500;
            color: #3498db;
        }
        .btn-print {
            display: block;
            margin: 30px auto 0;
            padding: 12px 30px;
            background: #2ecc71;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn-print:hover {
            background: #27ae60;
        }

        @media print {
            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="struk-wrapper">
    <h2>Struk Pemesanan</h2>

    <div class="info">
        <p><strong>ID Pemesanan:</strong> <?= $data['id_pemesanan'] ?></p>
        <p><strong>Tanggal:</strong> <?= $data['tanggal_pemesanan'] ?></p>
        <p><strong>Nama:</strong> <?= $data['nama_lengkap'] ?></p>
        <p><strong>Alamat:</strong> <?= $data['alamat'] ?></p>
        <p><strong>No HP:</strong> <?= $data['no_hp'] ?></p>
        <p><strong>Status Pemesanan:</strong> <?= ucfirst($data['status']) ?></p>
    </div>

    <div class="produk">
        <div class="produk-detail">
            <img src="../uploads/<?= $data['foto'] ?>" alt="<?= $data['nama_produk'] ?>">
            <div class="produk-detail-info">
                <p><strong>Produk:</strong> <?= $data['nama_produk'] ?></p>
                <p><strong>Ukuran:</strong> <?= $data['ukuran'] ?></p>
                <p><strong>Jumlah:</strong> <?= $data['jumlah_produk'] ?></p>
                <p class="total">Total Bayar: Rp <?= number_format($data['total_bayar'], 0, ',', '.') ?></p>
            </div>
        </div>
    </div>

    <button class="btn-print" onclick="window.print()">Cetak Struk</button>
</div>

</body>
</html>
