<?php
session_start();

if (!isset($_SESSION['id_users'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

$id_users = $_SESSION['id_users'];

$query = mysqli_query($koneksi, "SELECT nama, username FROM users WHERE id_users = '$id_users'");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Pengguna</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #243B55, #141E30);
            color: #333;
        }
        .container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 220px;
            background: #f4f4f4;
            padding: 20px;
        }
        .sidebar h3 {
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 8px 12px;
            border-radius: 5px;
        }
        .sidebar ul li a:hover {
            background-color: #ddd;
        }
        .home-btn {
            display: block;
            background-color: #ff4d4d;
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 20px;
        }
        .home-btn:hover {
            background-color: #e64444;
        }
        .content {
            flex: 1;
            padding: 40px;
            color: white;
        }
        .profile-box {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            max-width: 600px;
            color: #333;
        }
        .profile-box h3 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .profile-box p {
            margin: 10px 0;
        }
        .label {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="sidebar">
    <h3>Personal Detail</h3>
        <ul>
            <li><a href="produk.php">🏠 Home</a></li>
            <li><a href="keranjang.php">🛒 Keranjang</a></li>
            <!-- <li><a href="riwayat_pesanan.php">📦 Pesanan</a></li> -->
            <li><a href="riwayat_pesanan.php">📜 Riwayat Pesanan</a></li>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="profile-box">
            <h3>Personal Detail</h3>
            <p><span class="label">Nama:</span> <?= htmlspecialchars($user['nama']) ?></p>
            <p><span class="label">Username:</span> <?= htmlspecialchars($user['username']) ?></p>
        </div>
    </div>
</div>

</body>
</html>

