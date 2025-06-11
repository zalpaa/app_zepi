<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Pastikan session aktif
}

if (!empty($_SESSION['flash'])) {
    echo '<div class="alert alert-success">'.$_SESSION['flash'].'</div>';
    unset($_SESSION['flash']); // Hapus pesan setelah ditampilkan
}
?>



<h3>Daftar Pesanan</h3>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "koneksi.php";
        $result = mysqli_query($koneksi, "SELECT ps.*, u.nama FROM pemesanan ps JOIN users u ON ps.id_users = u.id_users ORDER BY ps.id_pemesanan DESC");
        while ($row = mysqli_fetch_assoc($result)) :
        ?>
        <tr>
            <td>#<?= $row['id_pemesanan'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['tanggal_pemesanan'] ?></td>
            <td>Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
            <td><span class="badge bg-info"><?= $row['status'] ?></span></td>
            <td>
                <a href="ubah-status-pesanan.php?id=<?= $row['id_pemesanan'] ?>" class="btn btn-sm btn-primary">Ubah Status</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
