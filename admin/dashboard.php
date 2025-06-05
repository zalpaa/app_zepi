<?php
session_start();
include "koneksi.php";

if(!isset($_SESSION['id'])) {
    header("location:login.php?pesan=logindulu");
    exit;
}

$sql = "SELECT * FROM produk"; 
$query = mysqli_query($koneksi, $sql); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
    <div class="d-flex">
      <a href="logout.php" class="btn btn-outline-light me-2">Logout</a>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Produk</h2>
        <a href="tambah.php" class="btn btn-primary">+ Tambah Produk</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Kategori</th>
                    <th>Nama</th>
                    <th>Foto</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Ukuran</th>
                    <th>Ketersediaan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($produk = mysqli_fetch_assoc($query)) { ?>
                <tr>
                    <td><?= $produk['id_produk'] ?></td>
                    <td><?= $produk['id_kategori'] ?></td>
                    <td><?= $produk['nama'] ?></td>
                    <td>
                        <img src="../uploads/<?= $produk['foto'] ?>" alt="Foto Produk" class="img-thumbnail" style="height: 80px;">
                    </td>
                    <td><?= $produk['deskripsi'] ?></td>
                    <td>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></td>
                    <td><?= $produk['ukuran'] ?></td>
                    <td>
                        <span class="badge bg-<?= $produk['ketersediaan'] == 'tersedia' ? 'success' : 'danger' ?>">
                            <?= ucfirst($produk['ketersediaan']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="edit.php?id_produk=<?= $produk['id_produk'] ?>" class="btn btn-sm btn-warning mb-1">Edit</a>
                        <a href="hapus.php?id_produk=<?= $produk['id_produk'] ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
