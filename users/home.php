<?php
include "koneksi.php";

$sql = "SELECT * FROM produk ORDER BY id_produk DESC LIMIT 4";
$query = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FLAZ | Home</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
  <!-- Header -->
  <header class="bg-white shadow-md fixed w-full">
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

  <!-- Hero Section -->
  <section class="bg-gradient-to-r from-red-500 via-red-400 to-red-500 text-white h-screen pt-20 flex items-center">
    <div class="container mx-auto text-center">
      <h2 class="text-4xl font-bold mb-4">Selamat Datang di Store FLAZ</h2>
      <p class="text-lg mb-8">Temukan fashion terkini untuk gaya kamu!</p>
      <a href="./produk.php" class="bg-white text-red-500 px-6 py-3 rounded-full font-semibold hover:bg-gray-100">Belanja Sekarang</a>
    </div>
  </section>

  <!-- Produk Terbaru -->
  <section class="py-16">
    <div class="container mx-auto px-4">
      <h3 class="text-2xl font-bold text-gray-800 mb-8 text-center">Produk Terbaru</h3>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <?php while ($produk = mysqli_fetch_assoc($query)) { ?>
          <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <img src="../uploads/<?= $produk['foto'] ?>" alt="<?= $produk['nama'] ?>" class="w-full h-60 object-cover">
            <div class="p-4">
              <h4 class="font-semibold text-lg"><?= $produk['nama'] ?></h4>
              <p class="text-gray-600">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="text-center mt-8">
        <a href="./produk.php" class="bg-pink-500 text-white px-6 py-2 rounded-md hover:bg-pink-600">Tampilkan Lebih Banyak Produk</a>
      </div>
    </div>
  </section>

  <!-- Lokasi Toko -->
  <section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4 text-center">
      <h3 class="text-2xl font-bold text-gray-800 mb-8">Lokasi Toko Kami</h3>
      <div class="flex justify-center">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31693.126907397675!2d107.61861065!3d-6.90344405!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64a03c325cd%3A0x401e8f1fc28de60!2sBandung!5e0!3m2!1sid!2sid!4v1620224567890!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-6 mt-10">
    <div class="container mx-auto text-center">
      <p>&copy; 2025 FLAZ. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
