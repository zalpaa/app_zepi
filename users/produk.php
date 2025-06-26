<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "koneksi.php";

// Ambil ID user jika login
$id_users = $_SESSION['id_users'] ?? 0;

// Ambil semua produk
$sql = "SELECT * FROM produk ORDER BY id_produk DESC";
$query = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Produk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .product-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
            transition: transform 0.2s ease;
            width: 280px;
        }
        .product-card:hover {
            transform: translateY(-4px);
        }
        .product-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        .product-card__info {
            padding: 15px;
        }
        .product-card__title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #111827;
        }
        .product-card__description {
            font-size: 0.9rem;
            color: #6b7280;
            margin-top: 6px;
            min-height: 45px;
        }
        .product-card__price-row {
            margin-top: 10px;
            font-size: 1rem;
            font-weight: 600;
            color: #10b981;
        }
        .product-card__btn {
            margin-top: 10px;
            background-color: #3b82f6;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-align: center;
            transition: background-color 0.3s;
        }
        .product-card__btn:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body class="bg-gray-100">

<!-- Header -->
<?php include "header.php"; ?>

<div class="pt-24"></div>

<section class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold text-gray-800 text-center mb-10">Semua Produk</h1>

    <div class="flex flex-wrap gap-6 justify-center">
        <?php while ($produk = mysqli_fetch_assoc($query)) { ?>
            <div class="product-card">
                <img src="../uploads/<?= $produk['foto'] ?>" alt="<?= $produk['nama'] ?>">
                <div class="product-card__info">
                    <h2 class="product-card__title"><?= $produk['nama'] ?></h2>
                    <p class="product-card__description"><?= $produk['deskripsi'] ?></p>
                    <div class="product-card__price-row">
                        Rp <?= number_format($produk['harga'], 0, ',', '.') ?>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Stok: <?= $produk['stok'] ?></p>
                    <a href="detail_produk.php?id_produk=<?= $produk['id_produk'] ?>">
                        <div class="product-card__btn">Detail Produk</div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>

<!-- Footer -->
<?php include "footer.php"; ?>

</body>
</html>
