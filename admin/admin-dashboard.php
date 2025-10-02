<?php
session_start();
include "koneksi.php";

// Cek apakah admin sudah login
if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php?pesan=logindulu");
    exit;
}

$page = $_GET['page'] ?? 'pesanan';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
            --dark-color: #2c3e50;
            --light-dark: #34495e;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --info-color: #3498db;
            --light-bg: #f8f9fa;
            --white: #ffffff;
            --border-color: #e3e6f0;
            --text-dark: #2c3e50;
            --text-muted: #6c757d;
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 15px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 30px rgba(0,0,0,0.15);
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light-bg);
            display: flex;
            min-height: 100vh;
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, 
                rgba(240, 147, 251, 0.1) 0%, 
                rgba(102, 126, 234, 0.1) 50%, 
                rgba(118, 75, 162, 0.1) 100%);
            pointer-events: none;
        }

        .sidebar-header {
            position: relative;
            padding: 30px 25px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .sidebar-header h4 {
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
            gap: 12px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .sidebar-header .admin-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 15px;
            border-radius: 25px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .sidebar-nav {
            position: relative;
            flex: 1;
            padding: 20px 0;
            overflow-y: auto;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .sidebar-nav a {
            position: relative;
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            padding: 16px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 4px solid transparent;
            margin: 3px 0;
            overflow: hidden;
        }

        .sidebar-nav a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: width 0.3s ease;
            z-index: -1;
        }

        .sidebar-nav a:hover::before {
            width: 100%;
        }

        .sidebar-nav a:hover {
            color: white;
            border-left-color: var(--accent-color);
            padding-left: 35px;
            background: rgba(255, 255, 255, 0.05);
            box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.1);
        }

        .sidebar-nav a.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-left-color: var(--accent-color);
            font-weight: 600;
            box-shadow: 
                inset 0 0 20px rgba(255, 255, 255, 0.1),
                0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .sidebar-nav a.active::before {
            width: 100%;
        }

        .sidebar-nav a i {
            width: 22px;
            text-align: center;
            font-size: 1.1rem;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        .logout-section {
            position: relative;
            margin-top: auto;
            padding: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(0, 0, 0, 0.1);
        }

        .logout-link {
            background: linear-gradient(135deg, var(--danger-color), #c0392b);
            color: white;
            text-decoration: none;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 
                0 6px 20px rgba(231, 76, 60, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            border: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .logout-link:hover {
            background: linear-gradient(135deg, #c0392b, #a93226);
            transform: translateY(-3px);
            box-shadow: 
                0 10px 30px rgba(231, 76, 60, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            color: white;
        }

        .logout-link:active {
            transform: translateY(-1px);
        }

        /* Content Area */
        .content {
            flex: 1;
            margin-left: var(--sidebar-width);
            background: var(--light-bg);
            min-height: 100vh;
        }

        .content-header {
            background: var(--white);
            padding: 25px 35px;
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
        }

        .content-header h3 {
            margin: 0;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .content-header h3 i {
            color: var(--primary-color);
            font-size: 1.6rem;
        }

        .content-body {
            padding: 35px;
        }

        /* Table Container */
        .table-wrapper {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            margin-top: 0;
        }

        /* Table Styles */
        .table {
            margin: 0;
            font-size: 0.95rem;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            font-weight: 600;
            border: none;
            padding: 20px 15px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .table thead th:first-child {
            padding-left: 25px;
        }

        .table thead th:last-child {
            padding-right: 25px;
        }

        .table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .table tbody td:first-child {
            padding-left: 25px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .table tbody td:last-child {
            padding-right: 25px;
        }

        .table tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .table tbody tr:hover {
            background: linear-gradient(90deg, 
                rgba(102, 126, 234, 0.05) 0%, 
                rgba(240, 147, 251, 0.03) 100%);
            transform: translateX(5px);
            box-shadow: 
                0 4px 15px rgba(102, 126, 234, 0.1),
                inset 4px 0 0 var(--primary-color);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badge Styles */
        .badge {
            padding: 8px 16px;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 25px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, var(--success-color), #2ecc71) !important;
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
            border-color: rgba(39, 174, 96, 0.3);
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, var(--warning-color), #f1c40f) !important;
            color: white;
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);
            border-color: rgba(243, 156, 18, 0.3);
        }

        .badge.bg-primary {
            background: linear-gradient(135deg, var(--info-color), #5dade2) !important;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
            border-color: rgba(52, 152, 219, 0.3);
        }

        .badge.bg-danger {
            background: linear-gradient(135deg, var(--danger-color), #ec7063) !important;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
            border-color: rgba(231, 76, 60, 0.3);
        }

        .badge.bg-secondary {
            background: linear-gradient(135deg, var(--text-muted), #95a5a6) !important;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
            border-color: rgba(108, 117, 125, 0.3);
        }

        .badge.bg-dark {
            background: linear-gradient(135deg, var(--dark-color), var(--light-dark)) !important;
            box-shadow: 0 4px 15px rgba(44, 62, 80, 0.3);
            border-color: rgba(44, 62, 80, 0.3);
        }

        /* Button Styles */
        .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 12px 24px;
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.3s ease, height 0.3s ease;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
            border: 2px solid transparent;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.8rem;
        }

        /* Mobile Toggle */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }

        .mobile-toggle:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-lg);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 100%;
                max-width: 320px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }

            .content-header {
                padding: 20px;
            }

            .content-header h3 {
                font-size: 1.5rem;
            }

            .content-body {
                padding: 20px;
            }

            .mobile-toggle {
                display: block;
            }

            .table-wrapper {
                overflow-x: auto;
                border-radius: 15px;
            }

            .table {
                min-width: 800px;
            }

            .sidebar-header {
                padding: 25px 20px;
            }

            .sidebar-nav a {
                padding: 14px 20px;
            }

            .logout-section {
                padding: 20px;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-body > * {
            animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Loading States */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Utility Classes */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .shadow-custom {
            box-shadow: var(--shadow-md);
        }

        /* Scrollbar Styling */
        .content::-webkit-scrollbar {
            width: 8px;
        }

        .content::-webkit-scrollbar-track {
            background: var(--light-bg);
        }

        .content::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 10px;
        }

        .content::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        }
    </style>
</head>
<body>

<button class="mobile-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h4>
            <i class="fas fa-tachometer-alt"></i>
            Admin Dashboard
        </h4>
        <div class="admin-badge">Control Panel</div>
    </div>
    
    <nav class="sidebar-nav">
        <a href="?page=produk" class="<?= $page == 'produk' ? 'active' : '' ?>">
            <i class="fas fa-box"></i>
            <span>Daftar Produk</span>
        </a>
        <a href="?page=verifikasi" class="<?= $page == 'verifikasi' ? 'active' : '' ?>">
            <i class="fas fa-check-circle"></i>
            <span>Verifikasi Pembayaran</span>
        </a>
        <a href="?page=pesanan" class="<?= $page == 'pesanan' ? 'active' : '' ?>">
            <i class="fas fa-shopping-cart"></i>
            <span>Kelola Pesanan</span>
        </a>
    </nav>

    <div class="logout-section">
        <a href="logout.php" class="logout-link">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

<!-- Content -->
<div class="content">
    <div class="content-header">
        <h3>
            <i class="fas fa-<?= $page == 'produk' ? 'box' : ($page == 'verifikasi' ? 'check-circle' : 'shopping-cart') ?>"></i>
            <?php
            $titles = [
                'produk' => 'Daftar Produk',
                'verifikasi' => 'Verifikasi Pembayaran',
                'pesanan' => 'Kelola Pesanan'
            ];
            echo $titles[$page] ?? 'Dashboard';
            ?>
        </h3>
    </div>

    <div class="content-body">
        <?php
        if ($page == 'produk') {
            include "produk.php";
        } elseif ($page == 'verifikasi') {
            include "verifikasi.php";
        } else {
            $query = "SELECT ps.*, u.nama AS nama_user FROM pemesanan ps
                      LEFT JOIN users u ON ps.id_users = u.id_users
                      ORDER BY ps.id_pemesanan DESC";
            $result = mysqli_query($koneksi, $query);

            echo '<div class="table-wrapper">
                    <table class="table">
                      <thead>
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
                $status = $row['status'] ?? 'pending';
                $badge_map = [
                    'dibayar' => 'success',
                    'menunggu konfirmasi' => 'secondary',
                    'pending' => 'secondary',
                    'dikirim' => 'primary',
                    'dikemas' => 'warning',
                    'gagal' => 'danger'
                ];
                $badge = $badge_map[$status] ?? 'dark';

                $alamat = strlen($row['alamat']) > 50 ? substr($row['alamat'], 0, 50) . '...' : $row['alamat'];
                $catatan = $row['catatan'] ? (strlen($row['catatan']) > 30 ? substr($row['catatan'], 0, 30) . '...' : $row['catatan']) : '-';

                echo '<tr>
                        <td>#' . htmlspecialchars($row['id_pemesanan']) . '</td>
                        <td><strong>' . htmlspecialchars($row['nama_lengkap']) . '</strong></td>
                        <td>' . htmlspecialchars($row['no_hp']) . '</td>
                        <td><span title="' . htmlspecialchars($row['alamat']) . '">' . htmlspecialchars($alamat) . '</span></td>
                        <td><span title="' . htmlspecialchars($row['catatan'] ?? '') . '">' . htmlspecialchars($catatan) . '</span></td>
                        <td>' . (isset($row['kurir']) && $row['kurir'] ? '<strong>' . htmlspecialchars($row['kurir']) . '</strong>' : '<em style="color: #6c757d;">Belum dipilih</em>') . '</td>
                        <td>' . date('d/m/Y H:i', strtotime($row['tanggal_pemesanan'])) . '</td>
                        <td><strong>Rp ' . number_format($row['total_bayar'], 0, ',', '.') . '</strong></td>
                        <td><span class="badge bg-' . $badge . '">' . ucfirst(htmlspecialchars($status)) . '</span></td>
                        <td><a href="ubah-status-pesanan.php?id=' . $row['id_pemesanan'] . '" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Ubah Status
                        </a></td>
                      </tr>';
            }

            echo '</tbody></table></div>';
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.querySelector('.mobile-toggle');
        
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });

    // Auto-hide sidebar on window resize
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebar');
        if (window.innerWidth > 768) {
            sidebar.classList.remove('active');
        }
    });

    // Add loading effect to buttons
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function() {
            if (!this.classList.contains('loading')) {
                this.classList.add('loading');
                setTimeout(() => {
                    this.classList.remove('loading');
                }, 1500);
            }
        });
    });

    // Enhanced table interactions
    document.querySelectorAll('.table tbody tr').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(8px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>

</body>
</html>