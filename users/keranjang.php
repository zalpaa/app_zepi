<?php
session_start();
include "koneksi.php";

$id_users = $_SESSION['id_users'] ?? 1;

$sql = "SELECT k.*, p.nama, p.harga, p.foto FROM keranjang k 
        JOIN produk p ON k.id_produk = p.id_produk
        WHERE k.id_users='$id_users'";
$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
        }

        .container-card {
            max-width: 900px;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h2, h3 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        table th {
            background-color: #f3f4f6;
        }

        table img {
            width: 60px;
        }

        input[type="text"], textarea, select {
            width: 100%;
            padding: 10px;
            margin: 6px 0 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button, .btn {
            background-color: #10b981;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover, .btn:hover {
            background-color: #059669;
        }

        .jumlah-btn {
            padding: 4px 10px;
            font-size: 14px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #2563eb;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .jumlah-container-card {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>
<body>

<?php include('header.php'); ?>

<div class="mx-auto pt-20 flex justify-center">
    <div class="container-card">
    <h2>Keranjang Belanja</h2>
    <table>
        <tr>
            <th>Produk</th>
            <th>Foto</th>
            <th>Ukuran</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Subtotal</th>
            <th>Aksi</th>
        </tr>

        <?php 
        $total = 0;
        while($row = mysqli_fetch_assoc($result)) :
            $subtotal = $row['harga'] * $row['jumlah_produk'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?= $row['nama'] ?></td>
            <td><img src="../uploads/<?= $row['foto'] ?>" alt="<?= $row['nama'] ?>"></td>
            <td><?= $row['ukuran'] ?></td>
            <td>
                <div class="jumlah-container-card">
                    <form method="POST" action="update_jumlah.php" style="display:inline;">
                        <input type="hidden" name="id_keranjang" value="<?= $row['id_keranjang'] ?>">
                        <input type="hidden" name="aksi" value="kurang">
                        <button type="submit" class="jumlah-btn">-</button>
                    </form>
                    <?= $row['jumlah_produk'] ?>
                    <form method="POST" action="update_jumlah.php" style="display:inline;">
                        <input type="hidden" name="id_keranjang" value="<?= $row['id_keranjang'] ?>">
                        <input type="hidden" name="aksi" value="tambah">
                        <button type="submit" class="jumlah-btn">+</button>
                    </form>
                </div>
            </td>
            <td>Rp <?= number_format($row['harga']) ?></td>
            <td>Rp <?= number_format($subtotal) ?></td>
            <td><a href="hapus_keranjang.php?id=<?= $row['id_keranjang'] ?>" class="btn">Hapus</a></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <p style="text-align:right; font-weight: bold; margin-top:10px;">Total: Rp <?= number_format($total) ?></p>

    <h3>Form Checkout</h3>
    <form method="POST" action="checkout_keranjang.php">
        <label>Nama Lengkap:</label>
        <input type="text" name="nama_lengkap" required>

        <label>Alamat Lengkap:</label>
        <textarea name="alamat" required></textarea>

        <label>No. HP:</label>
        <input type="text" name="no_hp" required>

        <label>Catatan:</label>
        <textarea name="catatan"></textarea>

        <label>Pilih Kurir:</label>
        <select name="id_jasa_kurir" required>
            <option value="">-- Pilih Kurir --</option>
            <option value="1">JNE</option>
            <option value="2">J&T</option>
            <option value="3">Sicepat</option>
        </select>

        <button type="submit">Checkout Semua Produk</button>
    </form>
</div>
</div>

</body>
</html>
