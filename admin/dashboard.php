<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['id'])) {
    header("location:login.php?pesan=logindulu");
    exit;
}

$sql = "SELECT * FROM produk"; 
$query = mysqli_query($koneksi,$sql); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Produk</title>
</head>
<body>
    <h1>Produk</h1>
    <a href="logout.php">Logout</a><br><br>
    <a href="tambah.php">Tambah</a><br><br>

    <table border="1">
        <tr>
            <th>Id Produk</th>
            <th>Id Kategori</th>
            <th>Nama</th>
            <th>Foto</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Ukuran</th>
            <th>Ketersediaan</th>
            <th>Aksi</th>
        </tr>
        <?php while ($produk = mysqli_fetch_assoc($query)) { ?>
        <tr>
            <td><?= $produk['id_produk'] ?></td>
            <td><?= $produk['id_kategori'] ?></td>
            <td><?= $produk['nama'] ?></td>
            <td>
                <img src="../uploads/<?= $produk['foto'] ?>" alt="" height="100">
            </td>
            <td><?= $produk['deskripsi'] ?></td>
            <td><?= $produk['harga'] ?></td>
            <td><?= $produk['ukuran'] ?></td>
            <td><?= $produk['ketersediaan'] ?></td>
            <td>
                <a href="edit.php?id_produk=<?= $produk['id_produk'] ?>">Edit</a>
                <a href="hapus.php?id_produk=<?= $produk['id_produk'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
