<?php
session_start();
include "koneksi.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID tidak ditemukan."; exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    mysqli_query($koneksi, "UPDATE pemesanan SET status='$status' WHERE id_pemesanan=$id");

    $_SESSION['flash'] = "Status pesanan berhasil diperbarui.";
    header("Location: admin-dashboard.php?page=pesanan");
    exit;
}

$query = mysqli_query($koneksi, "SELECT * FROM pemesanan WHERE id_pemesanan=$id");
$data = mysqli_fetch_assoc($query);
?>

<!-- Styling mulai di sini -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <h4 class="mb-4 text-center text-primary">Ubah Status Pesanan</h4>

            <?php if (isset($_SESSION['flash'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold">Status Pesanan</label>
                    <select name="status" id="status" class="form-select">
                        <option value="pending" <?= $data['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="dikemas" <?= $data['status'] == 'dikemas' ? 'selected' : '' ?>>Dikemas</option>
                        <option value="dikirim" <?= $data['status'] == 'dikirim' ? 'selected' : '' ?>>Dikirim</option>
                        <option value="diterima" <?= $data['status'] == 'diterima' ? 'selected' : '' ?>>Diterima</option>
                        <option value="selesai" <?= $data['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="dibatalkan" <?= $data['status'] == 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                    </select>
                </div>

                <div class="d-grid">
                    <button class="btn btn-success rounded-pill" type="submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script Bootstrap (jika diperlukan untuk dismiss alert) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>