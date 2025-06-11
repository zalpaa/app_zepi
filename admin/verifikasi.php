<?php
include "koneksi.php";

$query = "SELECT pembayaran.*, users.nama FROM pembayaran
          JOIN pemesanan ON pembayaran.id_pemesanan = pemesanan.id_pemesanan
          JOIN users ON pemesanan.id_users = users.id_users
          ORDER BY pembayaran.id_pembayaran DESC";
$result = mysqli_query($koneksi, $query);
?>

<h3>Verifikasi Pembayaran</h3>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Bukti</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td>#<?= $row['id_pembayaran'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td>
                <?php if ($row['bukti_pembayaran']) : ?>
                    <img src="../uploads/<?= $row['bukti_pembayaran'] ?>" width="100">
                <?php else : ?>
                    <em>Belum upload</em>
                <?php endif ?>
            </td>
            <td>
                <span class="badge bg-<?= $row['status'] == 'terverifikasi' ? 'success' : 'warning' ?>">
                    <?= ucfirst($row['status']) ?>
                </span>
            </td>
            <td>
                <?php if ($row['status'] != 'terverifikasi') : ?>
                    <a href="admin-verifikasi-update.php?id=<?= $row['id_pembayaran'] ?>" class="btn btn-sm btn-success">Verifikasi</a>
                <?php else : ?>
                    <span class="text-muted">Sudah diverifikasi</span>
                <?php endif ?>
            </td>
        </tr>
        <?php endwhile ?>
    </tbody>
</table>
