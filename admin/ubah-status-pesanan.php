<?php
session_start(); // Tambahkan ini
include "koneksi.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID tidak ditemukan."; exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    mysqli_query($koneksi, "UPDATE pemesanan SET status='$status' WHERE id_pemesanan=$id");

    // Flash message
    $_SESSION['flash'] = "Status pesanan berhasil diperbarui.";

    // Redirect ke halaman pesanan
    header("Location: admin-dashboard.php?page=pesanan");
    exit;
}


$query = mysqli_query($koneksi, "SELECT * FROM pemesanan WHERE id_pemesanan=$id");
$data = mysqli_fetch_assoc($query);
?>

<form method="POST">
    <label>Status Pesanan</label>
    <select name="status" class="form-select">
        <option value="pending" <?= $data['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="dikemas" <?= $data['status'] == 'dikemas' ? 'selected' : '' ?>>Dikemas</option>
        <option value="diterima" <?= $data['status'] == 'diterima' ? 'selected' : '' ?>>Diterima</option>
        <option value="selesai" <?= $data['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
        <option value="dibatalkan" <?= $data['status'] == 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
    </select>
    <button class="btn btn-success mt-2" type="submit">Simpan</button>
</form>
