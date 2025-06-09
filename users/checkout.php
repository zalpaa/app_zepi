<?php
include "koneksi.php";
session_start();

// Cek login user
if (!isset($_SESSION['id_users'])) {
    echo "<script>alert('Silakan login dulu'); window.location.href='login.php';</script>";
    exit;
}

$id_users = $_SESSION['id_users'];
$id_produk = $_GET['id_produk'];
$ukuran = isset($_GET['ukuran']) ? $_GET['ukuran'] : ''; // Ambil ukuran dari URL jika ada

// Cek apakah ada di keranjang
$keranjang = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_users='$id_users' AND id_produk='$id_produk' LIMIT 1");
$data_keranjang = mysqli_fetch_assoc($keranjang);

if (!$data_keranjang) {
    // Kalau tidak ada, tambahkan dulu
    $tanggal = date("Y-m-d");
    mysqli_query($koneksi, "INSERT INTO keranjang (id_users, id_produk, jumlah_produk, ukuran) VALUES ('$id_users', '$id_produk', 1, '$ukuran')");
    $id_keranjang = mysqli_insert_id($koneksi);
} else {
    $id_keranjang = $data_keranjang['id_keranjang'];
}

// Ambil data produk
$produk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'"));

// Proses checkout form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jumlah_produk = $_POST['jumlah_produk'];
    $ukuran = $_POST['ukuran'];
    $catatan = $_POST['catatan'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $tanggal_pemesanan = date("Y-m-d H:i:s");
    $id_jasa_kurir = $_POST['id_jasa_kurir'];
    $diskon = 0;
    $harga = $_POST['harga'];
    $total_harga = $harga * $jumlah_produk;
    $total_bayar = $total_harga - $diskon;

    $sql = "INSERT INTO pemesanan (id_users, id_produk, id_keranjang, tanggal_pemesanan, jumlah_produk, total_harga, diskon, total_bayar, ukuran, catatan, status, id_jasa_kurir, nama_lengkap, alamat, no_hp) 
            VALUES ('$id_users', '$id_produk', '$id_keranjang', '$tanggal_pemesanan', '$jumlah_produk', '$total_harga', '$diskon', '$total_bayar', '$ukuran', '$catatan', 'pending', '$id_jasa_kurir', '$nama_lengkap', '$alamat', '$no_hp')";

    if (mysqli_query($koneksi, $sql)) {
        $id_pemesanan = mysqli_insert_id($koneksi);
        echo '<script>alert("Pesanan berhasil!"); window.location.href="pembayaran.php?id_pemesanan=' . $id_pemesanan . '";</script>';
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout Produk</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .checkout-container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin: 15px 0 5px;
        }

        input[type="text"], input[type="number"], textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        .product-info {
            margin-bottom: 20px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <?php
        include ('./header.php');
    ?>

<div class="checkout-container">
    <h1>Checkout Produk</h1>

    <div class="product-info">
        <p><strong>Nama Produk:</strong> <?= $produk['nama'] ?></p>
        <p><strong>Harga:</strong> Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>
    </div>

    <form method="POST">
        <input type="hidden" name="harga" value="<?= $produk['harga'] ?>">

        <label>Jumlah:</label>
        <input type="number" name="jumlah_produk" value="1" min="1" required>

        <label>Ukuran:</label>
        <select name="ukuran" required>
            <option value="">-- Pilih Ukuran --</option>
            <?php
                $ukuran_options = ['M', 'L', 'XL', 'XXL'];
                foreach ($ukuran_options as $u) {
                    $selected = ($ukuran == $u) ? 'selected' : '';
                    echo "<option value='$u' $selected>$u</option>";
                }
            ?>
        </select>

        <label>Catatan:</label>
        <textarea name="catatan" rows="3"></textarea>

        <label>Nama Lengkap:</label>
        <input type="text" name="nama_lengkap" required>

        <label>Alamat Lengkap:</label>
        <textarea name="alamat" required></textarea>

        <label>No. HP:</label>
        <input type="text" name="no_hp" required>

        <label>Pilih Kurir:</label>
        <select name="id_jasa_kurir" required>
            <option value="">-- Pilih Kurir --</option>
            <option value="1">JNE</option>
            <option value="2">J&T</option>
            <option value="3">Sicepat</option>
        </select>

        <button type="submit">Proses Checkout</button>
    </form>
</div>

</body>
</html>
