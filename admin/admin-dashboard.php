<?php
session_start();
include "koneksi.php";

// Cek apakah admin sudah login
if (!isset($_SESSION['id'])) {
    header("Location: login.php?pesan=logindulu");
    exit;
}

$page = $_GET['page'] ?? 'pesanan';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            display: flex;
            flex-direction: column;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
        }
        .sidebar a:hover, .sidebar .active {
            background-color: #495057;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .logout-link {
            margin-top: auto;
            padding: 12px 20px;
            background-color: #dc3545;
            text-align: center;
            color: white;
        }
        .logout-link:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="p-3">Admin Dashboard</h4>
    <a href="?page=produk" class="<?= $page == 'produk' ? 'active' : '' ?>"><i class="fa fa-box"></i> Daftar Produk</a>
    <a href="?page=verifikasi" class="<?= $page == 'verifikasi' ? 'active' : '' ?>"><i class="fa fa-check-circle"></i> Verifikasi Pembayaran</a>
    <a href="?page=pesanan" class="<?= $page == 'pesanan' ? 'active' : '' ?>"><i class="fa fa-shopping-cart"></i> Kelola Pesanan</a>
    <a href="logout.php" class="logout-link"><i class="fa fa-sign-out-alt"></i> Logout</a>
</div>

<!-- Content -->
<div class="content">
    <?php
    if ($page == 'produk') {
        include "produk.php";
    } elseif ($page == 'verifikasi') {
        include "verifikasi.php";
    } else {
        $query = "SELECT ps.*, u.nama AS nama_user FROM pemesanan ps
                  JOIN users u ON ps.id_users = u.id_users
                  ORDER BY ps.id_pemesanan DESC";
        $result = mysqli_query($koneksi, $query);

        echo '<h3 class="mb-4">Daftar Pesanan</h3>
              <table class="table table-bordered table-striped">
                <thead class="table-dark">
                  <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Alamat</th>
                    <th>Catatan</th>
                    <th>Kurir</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>';

        while ($row = mysqli_fetch_assoc($result)) {
            $status = $row['status'];
            $badge = match ($status) {
                'dibayar' => 'success',
                'menunggu konfirmasi', 'pending' => 'secondary',
                'dikirim' => 'primary',
                'dikemas' => 'warning',
                'gagal' => 'danger',
                default => 'dark',
            };

            echo '<tr>
                    <td>#' . htmlspecialchars($row['id_pemesanan']) . '</td>
                    <td>' . htmlspecialchars($row['nama_lengkap']) . '</td>
                    <td>' . htmlspecialchars($row['no_hp']) . '</td>
                    <td>' . htmlspecialchars($row['alamat']) . '</td>
                    <td>' . htmlspecialchars($row['catatan']) . '</td>
                    <td>' . (isset($row['kurir']) ? htmlspecialchars($row['kurir']) : '-') . '</td>
                    <td>' . htmlspecialchars($row['tanggal_pemesanan']) . '</td>
                    <td>Rp ' . number_format($row['total_bayar'], 0, ',', '.') . '</td>
                    <td><span class="badge bg-' . $badge . '">' . ucfirst(htmlspecialchars($status)) . '</span></td>
                    <td><a href="ubah-status-pesanan.php?id=' . $row['id_pemesanan'] . '" class="btn btn-sm btn-primary">Ubah Status</a></td>
                  </tr>';
        }

        echo '</tbody></table>';
    }
    ?>
</div>

</body>
</html>
