<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['id'])) {
    header("location:login.php?pesan=logindulu");
    exit;
}

// Ambil ID produk
$id_produk = $_GET['id_produk'];

// Ambil data produk berdasarkan ID
$sql_produk = "SELECT * FROM produk WHERE id_produk = '$id_produk'";
$query_produk = mysqli_query($koneksi, $sql_produk);
$produk = mysqli_fetch_assoc($query_produk);

// Ambil data semua kategori
$sql_kategori = "SELECT * FROM kategori";
$query_kategori = mysqli_query($koneksi, $sql_kategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
</head>
<body>
    <h1>Edit Produk</h1>

    <form action="proses_edit.php" method="post" enctype="multipart/form-data">
        <!-- Hidden ID Produk -->
        <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>">

        <label>Kategori</label>
        <select name="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
            while ($kategori = mysqli_fetch_assoc($query_kategori)) {
                $selected = ($kategori['id_kategori'] == $produk['id_kategori']) ? 'selected' : '';
                echo "<option value='{$kategori['id_kategori']}' $selected>{$kategori['nama']}</option>";
            }
            ?>
        </select><br><br>

        <label>Nama</label>
        <input type="text" name="nama" value="<?= $produk['nama'] ?>" required><br><br>

        <label>Foto</label>
        <input type="file" name="foto" accept="image/*"><br><br>
        <img src="./uploads/<?= $produk['foto'] ?>" alt="">

        <label>Deskripsi</label>
        <textarea name="deskripsi" required><?= $produk['deskripsi'] ?></textarea><br><br>

        <label>Harga</label>
        <input type="number" name="harga" value="<?= $produk['harga'] ?>" step="0.01" required><br><br>

        <label>Ukuran</label>
        <select name="ukuran" required>
            <option value="M" <?= $produk['ukuran'] == 'M' ? 'selected' : '' ?>>M</option>
            <option value="L" <?= $produk['ukuran'] == 'L' ? 'selected' : '' ?>>L</option>
            <option value="XL" <?= $produk['ukuran'] == 'XL' ? 'selected' : '' ?>>XL</option>
        </select><br><br>

        <label>Ketersediaan</label>
        <select name="ketersediaan" required>
            <option value="ya" <?= $produk['ketersediaan'] == 'ya' ? 'selected' : '' ?>>Tersedia</option>
            <option value="tidak" <?= $produk['ketersediaan'] == 'tidak' ? 'selected' : '' ?>>Habis</option>
        </select><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
