<?php
include "koneksi.php";

$id_pembayaran = $_GET['id'] ?? null;

if (!$id_pembayaran) {
    echo "ID tidak valid.";
    exit;
}

// Ambil data pembayaran
$query = "SELECT * FROM pembayaran WHERE id_pembayaran = $id_pembayaran";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];

    // Update status pembayaran
    $update = "UPDATE pembayaran SET status = '$status' WHERE id_pembayaran = $id_pembayaran";
    mysqli_query($koneksi, $update);

    echo "<script>alert('Status berhasil diperbarui');window.location.href='admin-verifikasi.php';</script>";
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
        <a href="admin-verifikasi.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
