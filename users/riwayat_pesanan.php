<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['id_users'])) {
    echo "<script>alert('Silakan login dulu'); window.location.href='login.php';</script>";
    exit;
}

$id_users = $_SESSION['id_users'];

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
            pay.status AS status_pembayaran 
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
</head>
<body class="bg-gray-100 font-[Poppins]">

<?php include "header.php"; ?>

<div class="pt-28 px-4 min-h-screen flex flex-col items-center">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Riwayat Pesanan Anda</h1>

    <?php if (mysqli_num_rows($query) > 0) { ?>
        <div class="grid grid-cols-1 gap-6 w-full max-w-4xl">
            <?php while ($pesanan = mysqli_fetch_assoc($query)) { ?>
                <div class="bg-white rounded-lg shadow-md p-6 flex gap-4 items-start hover:shadow-lg transition">
                    <img src="../uploads/<?= $pesanan['foto'] ?>" alt="<?= $pesanan['nama_produk'] ?>" class="w-24 h-24 rounded object-cover">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-800"><?= $pesanan['nama_produk'] ?></h3>
                        <p class="text-sm text-gray-600">Tanggal: <?= $pesanan['tanggal_pemesanan'] ?></p>
                        <p class="text-sm text-gray-600">Jumlah: <?= $pesanan['jumlah_produk'] ?></p>
                        <p class="text-sm text-gray-600">Total Bayar: <span class="font-medium text-green-600">Rp <?= number_format($pesanan['total_bayar'], 0, ',', '.') ?></span></p>
                        <p class="text-sm">Status Pembayaran: <span class="font-semibold <?= $pesanan['status_pembayaran'] == 'dibayar' ? 'text-green-600' : 'text-red-500' ?>">
                            <?= $pesanan['status_pembayaran'] ?? 'Belum Dibayar' ?></span></p>
                        <p class="text-sm">Status Pesanan: <span class="font-semibold text-blue-600"><?= ucfirst($pesanan['status_pesanan']) ?></span></p>

                        <div class="mt-3 space-x-2">
                            <?php if ($pesanan['status_pembayaran'] == 'belum dibayar' || $pesanan['status_pembayaran'] == NULL) { ?>
                                <a href="pembayaran.php?id_pemesanan=<?= $pesanan['id_pemesanan'] ?>" class="inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 text-sm">Bayar Sekarang</a>
                            <?php } elseif ($pesanan['status_pembayaran'] == 'dibayar') { ?>
                                <a href="cetak_struk.php?id_pemesanan=<?= $pesanan['id_pemesanan'] ?>" class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">Cetak Struk</a>
                            <?php } ?>
                            <a href="status_pesanan.php?id_pemesanan=<?= $pesanan['id_pemesanan'] ?>" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">Status Pesanan</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p class="text-gray-500 text-center">Belum ada pesanan.</p>
    <?php } ?>
</div>

<?php include "footer.php"; ?>

</body>
</html>
