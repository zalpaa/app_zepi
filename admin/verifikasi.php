<?php
include "koneksi.php";

$query = "SELECT pembayaran.*, users.nama FROM pembayaran
          JOIN pemesanan ON pembayaran.id_pemesanan = pemesanan.id_pemesanan
          JOIN users ON pemesanan.id_users = users.id_users
          ORDER BY pembayaran.id_pembayaran DESC";
$result = mysqli_query($koneksi, $query);
?>

<h3 class="mb-4">Verifikasi Pembayaran</h3>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
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
            <?php
                $status = strtolower($row['status']);
                $badge = match($status) {
                    'dibayar' => 'success',
                    'menunggu konfirmasi' => 'warning',
                    'gagal' => 'danger',
                    default => 'secondary'
                };
            ?>
            <tr>
                <td>#<?= $row['id_pembayaran'] ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td>
                    <?php if ($row['bukti_pembayaran']) : ?>
                        <img src="../uploads/<?= $row['bukti_pembayaran'] ?>" width="100" class="img-thumbnail">
                    <?php else : ?>
                        <em>Belum upload</em>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="badge bg-<?= $badge ?>"><?= ucfirst($status) ?></span>
                </td>
                <td>
                    <?php if ($status == 'menunggu konfirmasi') : ?>
                        <a href="admin-verifikasi-update.php?id=<?= $row['id_pembayaran'] ?>" class="btn btn-sm btn-success">Verifikasi</a>
                        <a href="admin-verifikasi-gagal.php?id=<?= $row['id_pembayaran'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menolak pembayaran ini?')">Tolak</a>
                    <?php else : ?>
                        <span class="text-muted">Selesai</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
