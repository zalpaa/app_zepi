<?php
// session_start();
include "koneksi.php";

// if (!isset($_SESSION['id'])) {
//     header("location:login.php?pesan=logindulu");
//     exit;
// }

$sql = "SELECT p.*, k.nama AS nama_kategori FROM produk p
        LEFT JOIN kategori k ON p.id_kategori = k.id_kategori 
        ORDER BY p.id_produk DESC";
$query = mysqli_query($koneksi, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Data Produk</h3>
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
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($produk = mysqli_fetch_assoc($query)) { ?>
            <tr>
                <td><?= $produk['id_produk'] ?></td>
                <td><?= $produk['nama_kategori'] ?></td>
                <td><?= $produk['nama'] ?></td>
                <td>
                    <img src="../uploads/<?= $produk['foto'] ?>" alt="Foto Produk" class="img-thumbnail" style="height: 80px;">
                </td>
                <td><?= $produk['deskripsi'] ?></td>
                <td>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></td>
                <td><?= $produk['ukuran'] ?></td>
                <td><?= $produk['stok'] ?></td>
                <td>
                    <a href="edit.php?id_produk=<?= $produk['id_produk'] ?>" class="btn btn-sm btn-warning mb-1">Edit</a>
                    <a href="hapus.php?id_produk=<?= $produk['id_produk'] ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
