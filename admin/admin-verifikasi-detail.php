<?php
include "koneksi.php";

$id_pembayaran = $_GET['id'] ?? null;

if (!$id_pembayaran) {
    echo "ID tidak valid.";
    exit;
}

$query = "
SELECT p.*, 
       u.nama AS nama_user, 
       u.email, 
       mp.provider, 
       mp.no_akun,
       ps.total_bayar, 
       ps.tanggal_pemesanan
FROM pembayaran p
JOIN pemesanan ps ON ps.id_pemesanan = p.id_pemesanan
JOIN users u ON ps.id_users = u.id_users
JOIN metode_pembayaran mp ON mp.id_metode_pembayaran = p.id_metode_pembayaran
WHERE p.id_pembayaran = $id_pembayaran
";

$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Detail Pembayaran</h3>
    <table class="table table-bordered">
        <tr>
            <th>Nama Pelanggan</th>
            <td><?= htmlspecialchars($data['nama_user']) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($data['email']) ?></td>
        </tr>
        <tr>
            <th>Tanggal Pemesanan</th>
            <td><?= $data['tanggal_pemesanan'] ?></td>
        </tr>
        <tr>
            <th>Total Bayar</th>
            <td>Rp <?= number_format($data['total_bayar'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <th>Metode Pembayaran</th>
            <td><?= $data['provider'] ?> - <?= $data['no_akun'] ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><span class="badge bg-primary"><?= $data['status'] ?></span></td>
        </tr>
        <tr>
            <th>Bukti Pembayaran</th>
            <td>
                <?php if ($data['bukti_pembayaran']): ?>
                    <img src="../uploads/<?= $data['bukti_pembayaran'] ?>" alt="Bukti Pembayaran" width="300">
                <?php else: ?>
                    <span class="text-danger">Tidak ada bukti pembayaran</span>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <a href="admin-verifikasi.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
