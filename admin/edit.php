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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        img.preview {
            max-height: 150px;
            margin-top: 10px;
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card shadow mx-auto" style="max-width: 600px;">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Edit Produk</h4>
        </div>
        <div class="card-body">
            <form action="proses_edit.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>">

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="id_kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php while ($kategori = mysqli_fetch_assoc($query_kategori)) {
                            $selected = ($kategori['id_kategori'] == $produk['id_kategori']) ? 'selected' : '';
                            echo "<option value='{$kategori['id_kategori']}' $selected>{$kategori['nama']}</option>";
                        } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama" class="form-control" value="<?= $produk['nama'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Baru (Opsional)</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    <img src="./uploads/<?= $produk['foto'] ?>" alt="Preview Foto Lama" class="preview mt-2">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3" required><?= $produk['deskripsi'] ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" step="0.01" value="<?= $produk['harga'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ukuran</label>
                    <select name="ukuran" class="form-select" required>
                        <option value="M" <?= $produk['ukuran'] == 'M' ? 'selected' : '' ?>>M</option>
                        <option value="L" <?= $produk['ukuran'] == 'L' ? 'selected' : '' ?>>L</option>
                        <option value="XL" <?= $produk['ukuran'] == 'XL' ? 'selected' : '' ?>>XL</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Ketersediaan</label>
                    <select name="ketersediaan" class="form-select" required>
                        <option value="ya" <?= $produk['ketersediaan'] == 'ya' ? 'selected' : '' ?>>Tersedia</option>
                        <option value="tidak" <?= $produk['ketersediaan'] == 'tidak' ? 'selected' : '' ?>>Habis</option>
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Update Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
