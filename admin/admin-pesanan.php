<?php
include "koneksi.php";

// Ambil data pesanan + user
$query = "SELECT ps.*, u.nama 
          FROM pemesanan ps
          JOIN users u ON ps.id_users = u.id_users
          ORDER BY ps.id_pemesanan DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Daftar Pesanan</h3>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>No. HP</th>
                <th>Alamat</th>
                <th>Catatan</th>
                <!-- <th>Kurir</th> --> <!-- opsional jika ingin diaktifkan -->
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status Pesanan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td>#<?= $row['id_pemesanan'] ?></td>
                <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                <td><?= htmlspecialchars($row['no_hp']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['catatan']) ?></td>
                <!-- <td><?= htmlspecialchars($row['kurir'] ?? '-') ?></td> --> <!-- jika ingin tampilkan kurir -->
                <td><?= $row['tanggal_pemesanan'] ?></td>
                <td>Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($row['status']) ?></span></td>
                <td>
                    <a href="ubah-status-pesanan.php?id=<?= $row['id_pemesanan'] ?>" class="btn btn-sm btn-primary">Ubah Status</a>
                </td>
            </tr>
            <?php endwhile ?>
        </tbody>
    </table>
</div>
</body>
</html>
