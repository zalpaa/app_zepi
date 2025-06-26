<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_users'])) {
    echo "<script>alert('Silakan login dulu'); location='login.php';</script>";
    exit;
}

$id_pemesanan = $_GET['id_pemesanan'] ?? 0;
$sql = "SELECT 
            p.tanggal_pemesanan, 
            p.status AS status_pesanan, 
            pay.status AS status_pembayaran,
            p.nama_lengkap, p.alamat, p.no_hp,
            pr.nama AS nama_produk, pr.foto, p.ukuran, p.jumlah_produk, p.total_bayar
        FROM pemesanan p 
        JOIN produk pr ON p.id_produk = pr.id_produk
        LEFT JOIN pembayaran pay ON p.id_pemesanan = pay.id_pemesanan 
        WHERE p.id_pemesanan = '$id_pemesanan'";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Status tidak ditemukan.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="max-w-3xl mx-auto mt-20 bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-center mb-6 text-blue-700">Status Pesanan</h2>

    <div class="flex items-start gap-6">
        <img src="../uploads/<?= $data['foto'] ?>" alt="<?= $data['nama_produk'] ?>" class="w-28 h-28 object-cover rounded shadow">
        <div class="flex-1 space-y-2">
            <p><span class="font-medium text-gray-700">Produk:</span> <?= $data['nama_produk'] ?></p>
            <p><span class="font-medium text-gray-700">Ukuran:</span> <?= $data['ukuran'] ?></p>
            <p><span class="font-medium text-gray-700">Jumlah:</span> <?= $data['jumlah_produk'] ?></p>
            <p><span class="font-medium text-gray-700">Total Bayar:</span> <span class="text-green-600 font-semibold">Rp <?= number_format($data['total_bayar'], 0, ',', '.') ?></span></p>
        </div>
    </div>

    <div class="border-t mt-6 pt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <h4 class="font-semibold text-gray-800 mb-2">Informasi Penerima</h4>
            <p><span class="font-medium text-gray-700">Nama:</span> <?= $data['nama_lengkap'] ?></p>
            <p><span class="font-medium text-gray-700">No HP:</span> <?= $data['no_hp'] ?></p>
            <p><span class="font-medium text-gray-700">Alamat:</span><br><?= $data['alamat'] ?></p>
        </div>
        <div>
            <h4 class="font-semibold text-gray-800 mb-2">Status Pemesanan</h4>
            <p><span class="font-medium text-gray-700">Tanggal:</span> <?= $data['tanggal_pemesanan'] ?></p>
            <p><span class="font-medium text-gray-700">Status Pesanan:</span> 
                <span class="inline-block px-3 py-1 rounded-full text-white text-sm 
                    <?= $data['status_pesanan'] == 'selesai' ? 'bg-green-600' : ($data['status_pesanan'] == 'dikirim' ? 'bg-blue-500' : 'bg-yellow-500') ?>">
                    <?= ucfirst($data['status_pesanan']) ?>
                </span>
            </p>
            <p><span class="font-medium text-gray-700">Status Pembayaran:</span> 
                <span class="inline-block px-3 py-1 rounded-full text-white text-sm 
                    <?= $data['status_pembayaran'] == 'dibayar' ? 'bg-green-600' : 'bg-red-500' ?>">
                    <?= $data['status_pembayaran'] ? ucfirst($data['status_pembayaran']) : 'Belum Dibayar' ?>
                </span>
            </p>
        </div>
    </div>

    <div class="mt-6 text-center">
        <a href="riwayat_pesanan.php" class="inline-block bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
            Kembali ke Riwayat Pesanan
        </a>
    </div>
</div>

</body>
</html>
