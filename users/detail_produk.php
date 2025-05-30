<?php
include "koneksi.php";

// Ambil ID produk dari URL
$id_produk = $_GET['id_produk'];

// Query produk berdasarkan ID
$sql = "SELECT * FROM produk WHERE id_produk = $id_produk";
$query = mysqli_query($koneksi, $sql);
$produk = mysqli_fetch_assoc($query);

// Jika produk tidak ditemukan, tampilkan pesan error
if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        .detail-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            gap: 20px;
        }

        .detail-image img {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }

        .detail-info {
            flex: 1;
        }

        .detail-info h1 {
            margin-top: 0;
        }

        .price {
            font-size: 1.5rem;
            color: #333;
            margin: 10px 0;
        }

         .btn-keranjang, .btn-beli {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
        }

        .btn-beli {
            background-color: #28a745;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="detail-container">
        <div class="detail-image">
            <img src="../uploads/<?= $produk['foto'] ?>" alt="<?= $produk['nama'] ?>">
        </div>
        <div class="detail-info">
            <h1><?= $produk['nama'] ?></h1>
            <p><?= $produk['deskripsi'] ?></p>
            <p class="price">Harga: Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>
            <p>Ukuran: <?= $produk['ukuran'] ?></p>
            <p>Ketersediaan: <?= $produk['ketersediaan'] ?></p>

            <a href="tambah_keranjang.php?id_produk=<?= $produk['id_produk'] ?>" class="btn-keranjang">Masukkan ke Keranjang</a>
            <a href="checkout.php?id_produk=<?= $produk['id_produk'] ?>&beli=sekarang" class="btn-beli">Beli Sekarang</a>

            <br>
            <a href="javascript:history.back()" class="back-btn">Kembali</a>
        </div>
    </div>
</body>
</html>
