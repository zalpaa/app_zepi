<?php
include "koneksi.php";

$id_pembayaran = $_GET['id'] ?? null;

if (!$id_pembayaran) {
    echo "ID tidak valid.";
    exit;
}

// Ambil data pembayaran dan pemesanan
$query = "SELECT pembayaran.*, pemesanan.id_pemesanan 
          FROM pembayaran 
          JOIN pemesanan ON pembayaran.id_pemesanan = pemesanan.id_pemesanan 
          WHERE pembayaran.id_pembayaran = $id_pembayaran";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status_pembayaran = $_POST['status'];
    $id_pemesanan = $data['id_pemesanan'];

    // Tentukan status pesanan sesuai status pembayaran
    if ($status_pembayaran === 'dibayar') {
        $status_pesanan = 'dikemas';
    } elseif ($status_pembayaran === 'gagal') {
        $status_pesanan = 'dibatalkan';
    } else {
        $status_pesanan = 'pending'; // fallback default
    }

    // Update status pembayaran
    $update_pembayaran = mysqli_query($koneksi, "UPDATE pembayaran SET status = '$status_pembayaran' WHERE id_pembayaran = $id_pembayaran");

    // Update status pemesanan juga
    $update_pesanan = mysqli_query($koneksi, "UPDATE pemesanan SET status = '$status_pesanan' WHERE id_pemesanan = $id_pemesanan");

    if ($update_pembayaran && $update_pesanan) {
        echo "<script>alert('Status berhasil diperbarui');window.location.href='admin-dashboard.php?page=verifikasi';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui status.');history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Update Status Pembayaran</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Status Pembayaran</label>
            <select name="status" class="form-select" required>
                <option value="menunggu konfirmasi" <?= $data['status'] === 'menunggu konfirmasi' ? 'selected' : '' ?>>Menunggu Konfirmasi</option>
                <option value="dibayar" <?= $data['status'] === 'dibayar' ? 'selected' : '' ?>>Dibayar</option>
                <option value="gagal" <?= $data['status'] === 'gagal' ? 'selected' : '' ?>>Gagal</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="admin-dashboard.php?page=verifikasi" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
