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
</head>
<body>
    <h1>Produk</h1>

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