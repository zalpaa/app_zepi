<?php
include "koneksi.php";
session_start();

$id_users = $_SESSION['id_users'] ?? 0;

$sql = "SELECT * FROM produk ORDER BY id_produk DESC LIMIT 4";
$query = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>FLAZ | Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .product-card {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      width: 280px;
      transition: transform 0.3s ease;
    }
    .product-card:hover {
      transform: translateY(-5px);
    }
    .product-card img {
      width: 100%;
      height: 240px;
      object-fit: cover;
    }
    .product-card__info {
      padding: 15px;
    }
    .product-card__title {
      font-size: 1.2rem;
      font-weight: bold;
      color: #1f2937;
    }
    .product-card__description {
      font-size: 0.9rem;
      color: #6b7280;
      margin-top: 4px;
      min-height: 48px;
    }
    .product-card__price {
      color: #10b981;
      font-weight: bold;
      margin-top: 8px;
    }
    .product-card__btn {
      margin-top: 10px;
      background-color: #3b82f6;
      color: white;
      padding: 8px 16px;
      border-radius: 8px;
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

<!-- Hero Section -->
<section class="text-white h-screen pt-20 flex items-center justify-center"
  style="background-image: url('../uploads/res087c28c3dbbe82526614d337cc14bc44fr (1).jpg'); background-size: cover; background-position: center;">
  <div class="text-center bg-black bg-opacity-50 p-10 rounded-lg">
    <h2 class="text-4xl font-bold mb-4">Selamat Datang di Store FLAZ</h2>
    <p class="text-lg mb-8">Temukan fashion terkini untuk gaya kamu!</p>
    <a href="./produk.php" class="bg-white text-red-500 px-6 py-3 rounded-full font-semibold hover:bg-gray-200">Belanja Sekarang</a>
  </div>
</section>

<!-- Produk Terbaru -->
<section class="max-w-7xl mx-auto px-4 py-16">
  <h3 class="text-3xl font-bold text-gray-800 mb-10 text-center">Produk Terbaru</h3>
  <div class="flex flex-wrap justify-center gap-8">
    <?php while ($produk = mysqli_fetch_assoc($query)) { ?>
      <div class="product-card">
        <img src="../uploads/<?= $produk['foto'] ?>" alt="<?= $produk['nama'] ?>">
        <div class="product-card__info">
          <h2 class="product-card__title"><?= $produk['nama'] ?></h2>
          <p class="product-card__description"><?= $produk['deskripsi'] ?></p>
          <p class="product-card__price">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>
          <p class="text-sm text-gray-500">Stok: <?= $produk['stok'] ?></p>
          <a href="detail_produk.php?id_produk=<?= $produk['id_produk'] ?>">
            <div class="product-card__btn text-center">Detail Produk</div>
          </a>
        </div>
      </div>
    <?php } ?>
  </div>
</section>

<!-- Lokasi Toko -->
<section class="py-16 bg-gray-100">
  <div class="container mx-auto px-4 text-center">
    <h3 class="text-2xl font-bold text-gray-800 mb-8">Lokasi Toko Kami</h3>
    <div class="flex justify-center">
      <iframe class="rounded-lg shadow-md"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31693.126907397675!2d107.61861065!3d-6.90344405!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64a03c325cd%3A0x401e8f1fc28de60!2sBandung!5e0!3m2!1sid!2sid!4v1620224567890!5m2!1sid!2sid"
        width="900" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </div>
</section>

<!-- Footer -->
<?php include "footer.php"; ?>
</body>
</html>
