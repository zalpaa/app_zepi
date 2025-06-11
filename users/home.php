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
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body >
 
<!-- Header -->
<?php include "header.php"?>

  <section class="text-white h-screen pt-20 flex items-center" 
    style="background-image: url('../uploads/res087c28c3dbbe82526614d337cc14bc44fr (1).jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
  <div class="container mx-auto text-center">
    <h2 class="text-4xl font-bold mb-4">Selamat Datang di Store FLAZ</h2>
    <p class="text-lg mb-8">Temukan fashion terkini untuk gaya kamu!</p>
    <a href="./produk.php" class="bg-white text-red-500 px-6 py-3 rounded-full font-semibold hover:bg-gray-100">Belanja Sekarang</a>
  </div>
</section>


  <!-- Produk Terbaru -->
     <h3 class="text-2xl font-bold text-gray-800 mb-8 text-center" style="margin-top:3rem;">Produk Terbaru</h3>
  <div class="container-card">
    <div class="cont flex flex-wrap justify-center gap-6">
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
                        <!-- <span class="product-card__size">Ukuran: </span> -->
                    </div>
                    <p>Stok: <?= $produk['stok'] ?></p>
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

  

  <!-- Lokasi Toko -->
  <section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4 text-center">
      <h3 class="text-2xl font-bold text-gray-800 mb-8">Lokasi Toko Kami</h3>
      <div class="flex justify-center">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31693.126907397675!2d107.61861065!3d-6.90344405!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e64a03c325cd%3A0x401e8f1fc28de60!2sBandung!5e0!3m2!1sid!2sid!4v1620224567890!5m2!1sid!2sid" width="900" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include "footer.php"; ?>
</body>
</html>
