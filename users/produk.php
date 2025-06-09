<?php
//session_start();

include "koneksi.php";


//if(!isset($_SESSION['id'])) {
//    header("location:login.php?pesan=logindulu");
//    exit;
//}



$sql = "SELECT * FROM produk"; 
$query = mysqli_query($koneksi,$sql); 
 
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

      <!-- Header -->
  <header class="bg-white fixed w-full shadow-md">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold text-gray-800">FLAZ</h1>
      <nav>
        <ul class="flex space-x-6">
          <li><a href="./home.php" class="text-gray-600 hover:text-gray-900">Home</a></li>
          <li><a href="#" class="text-gray-600 hover:text-gray-900">Produk</a></li>
          <li><a href="./about.php" class="text-gray-600 hover:text-gray-900">Tentang Kami</a></li>
          <li><a href="./kontak.php" class="text-gray-600 hover:text-gray-900">Kontak</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <div class="pt-20"></div>

<div class="container-card">
    <div class="cont">
        <?php while ($produk = mysqli_fetch_assoc($query)) { ?>
            <div class="product-card">
                <div class="product-card__image">
                    <img src="../uploads/<?= $produk['foto'] ?>" alt="<?= $produk['nama'] ?>">
                </div>
                <div class="product-card__info">
                    <h2 class="product-card__title"><?= $produk['nama'] ?></h2>
                    <p class="product-card__description"><?= $produk['deskripsi'] ?></p>
                    <div class="product-card__price-row">
                        <span class="product-card__price">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></span>
                        <span class="product-card__size">Ukuran: <?= $produk['ukuran'] ?></span>
                    </div>
                    <p>Ketersediaan: <?= $produk['ketersediaan'] ?></p>
                    <div style="margin-top: 10px;">
                        <a href="detail_produk.php?id_produk=<?= $produk['id_produk'] ?>">
                            <button class="product-card__btn">Detail Produk</button>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>