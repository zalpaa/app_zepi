
<?php
include "koneksi.php";

$status_filter = $_GET['status'] ?? 'menunggu konfirmasi';

$query = "SELECT 
    pembayaran.id_pembayaran,
    users.nama AS nama_user,
    users.email,
    pembayaran.status,
    pembayaran.bukti_pembayaran,
    pembayaran.id_pemesanan,
    metode_pembayaran.provider,
    metode_pembayaran.no_akun,
    pemesanan.total_bayar,
    pemesanan.tanggal_pemesanan
FROM pembayaran
JOIN pemesanan ON pembayaran.id_pemesanan = pemesanan.id_pemesanan
JOIN users ON pemesanan.id_users = users.id_users
JOIN metode_pembayaran ON pembayaran.id_metode_pembayaran = metode_pembayaran.id_metode_pembayaran
WHERE pembayaran.status = '$status_filter'
ORDER BY pembayaran.id_pembayaran DESC";

$result = mysqli_query($koneksi, $query);

// Ambil statistik jumlah
$menunggu = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE status = 'menunggu konfirmasi'"));
$berhasil = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE status = 'dibayar'"));
$gagal = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE status = 'gagal'"));
$total = $menunggu + $berhasil + $gagal;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin - Verifikasi Pembayaran</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h2>Verifikasi Pembayaran</h2>
  <p>Kelola dan verifikasi bukti pembayaran dari pelanggan</p>
  <div class="row mb-4">
    <div class="col">
      <div class="card text-white bg-warning"><div class="card-body">Menunggu Verifikasi: <?= $menunggu ?></div></div>
    </div>
    <div class="col">
      <div class="card text-white bg-success"><div class="card-body">Pembayaran Berhasil: <?= $berhasil ?></div></div>
    </div>
    <div class="col">
      <div class="card text-white bg-danger"><div class="card-body">Pembayaran Gagal: <?= $gagal ?></div></div>
    </div>
    <div class="col">
      <div class="card text-white bg-primary"><div class="card-body">Total Pembayaran: <?= $total ?></div></div>
    </div>
  </div>
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Pelanggan</th>
        <th>Tanggal</th>
        <th>Total</th>
        <th>Metode</th>
        <th>Status</th>
        <th>Bukti</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while($data = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td>#<?= $data['id_pembayaran'] ?></td>
        <td><?= $data['nama_user'] ?><br><small><?= $data['email'] ?></small></td>
        <td><?= date('d/m/Y H:i', strtotime($data['tanggal_pemesanan'])) ?></td>
        <td>Rp <?= number_format($data['total_bayar'], 0, ',', '.') ?></td>
        <td><?= $data['provider'] ?><br><small><?= $data['no_akun'] ?></small></td>
        <td>
          <?php
            $badge_class = 'bg-secondary';
            if ($data['status'] === 'dibayar') $badge_class = 'bg-success';
            elseif ($data['status'] === 'menunggu konfirmasi') $badge_class = 'bg-warning text-dark';
            elseif ($data['status'] === 'gagal') $badge_class = 'bg-danger';
          ?>
          <span class="badge <?= $badge_class ?>"><?= ucfirst($data['status']) ?></span>
        </td>
        <td>
          <?= $data['bukti_pembayaran'] && $data['bukti_pembayaran'] != 'Tidak ada' ? '<a href="../uploads/'.$data['bukti_pembayaran'].'" target="_blank">Lihat</a>' : 'Tidak ada'; ?>
        </td>
        <td>
          <a href="admin-verifikasi-update.php?id=<?= $data['id_pembayaran'] ?>" class="btn btn-sm btn-primary">Update</a>
          <a href="admin-verifikasi-detail.php?id=<?= $data['id_pembayaran'] ?>" class="btn btn-sm btn-info">Detail</a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
