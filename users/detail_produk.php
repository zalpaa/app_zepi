<?php
include "koneksi.php";

// Ambil ID produk dari URL
$id_produk = $_GET['id_produk'];

// Query produk berdasarkan ID
$sql = "SELECT * FROM produk WHERE id_produk = $id_produk";
$query = mysqli_query($koneksi, $sql);
$produk = mysqli_fetch_assoc($query);

// Jika produk tidak ditemukan
if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit;
}

// Ambil ukuran dari enum secara manual (karena ENUM di DB)
$ukuran_options = ['M', 'L', 'XL', 'XXL'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .detail-container {
            max-width: 900px;
            padding: 30px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .detail-image {
            flex: 1 1 300px;
            text-align: center;
        }

        .detail-image img {
            margin-top: 3rem;
            width: 100%;
            max-width: 350px;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #ccc;
        }

        .detail-info {
            flex: 2 1 400px;
        }

        .detail-info h1 {
            margin-top: 4rem;
            font-size: 2rem;
        }

        .price {
            font-size: 1.7rem;
            color: #e63946;
            margin: 15px 0;
            font-weight: bold;
        }

        select {
            padding: 8px 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn-keranjang, .btn-beli {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-keranjang:hover {
            background-color: #0056b3;
        }

        .btn-beli {
            background-color: #28a745;
        }

        .btn-beli:hover {
            background-color: #1e7e34;
        }

        .btn-disabled {
            background-color: #ccc !important;
            cursor: not-allowed;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php
        include ('./header.php');
    ?>
    <div class="pt-20"></div>
        <div class="detail-container mx-auto ">
            <div class="detail-image">
                <img src="../uploads/<?= $produk['foto'] ?>" alt="<?= $produk['nama'] ?>">
            </div>
            <div class="detail-info">
                <h1><?= $produk['nama'] ?></h1>
                <p style="color: #666;"><?= $produk['deskripsi'] ?></p>
                <p class="price">Harga: Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>
                <p>Ukuran: 
                    <select id="ukuranSelect">
                        <?php foreach ($ukuran_options as $ukuran): ?>
                            <option value="<?= $ukuran ?>" <?= ($produk['ukuran'] == $ukuran) ? 'selected' : '' ?>>
                                <?= $ukuran ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>Stok: <?= $produk['stok'] ?></p>

                    <a href="tambah_keranjang.php?id_produk=<?= $produk['id_produk'] ?>&ukuran=M" 
                    class="btn-keranjang" id="keranjangBtn">Masukkan ke Keranjang</a>
                    <a href="checkout.php?id_produk=<?= $produk['id_produk'] ?>&beli=sekarang&ukuran=M" 
                    class="btn-beli" id="beliBtn">Beli Sekarang</a>

                    <!-- <a href="#" class="btn-keranjang btn-disabled" onclick="return false;">Masukkan ke Keranjang</a>
                    <a href="#" class="btn-beli btn-disabled" onclick="return false;">Beli Sekarang</a> -->

                <br>
                <a href="javascript:history.back()" class="back-btn">Kembali</a>
            </div>
        </div>

    <script>
        const ukuranSelect = document.getElementById('ukuranSelect');
        const keranjangBtn = document.getElementById('keranjangBtn');
        const beliBtn = document.getElementById('beliBtn');

        ukuranSelect.addEventListener('change', function() {
            const selectedUkuran = this.value;
            keranjangBtn.href = `keranjang.php?id_produk=<?= $produk['id_produk'] ?>&ukuran=${selectedUkuran}`;
            beliBtn.href = `checkout.php?id_produk=<?= $produk['id_produk'] ?>&beli=sekarang&ukuran=${selectedUkuran}`;
        });
    </script>
</body>
</html>
