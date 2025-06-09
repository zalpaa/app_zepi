<?php
include "koneksi.php";
session_start();

// Cek login user
if (!isset($_SESSION['id_users'])) {
    echo "<script>alert('Silakan login dulu'); window.location.href='login.php';</script>";
    exit;
}

$id_pemesanan = $_GET['id_pemesanan'];

// Ambil detail pesanan
$sql = "SELECT p.*, pr.nama, pr.foto FROM pemesanan p 
        JOIN produk pr ON p.id_produk = pr.id_produk 
        WHERE p.id_pemesanan = '$id_pemesanan'";
$query = mysqli_query($koneksi, $sql);
$pemesanan = mysqli_fetch_assoc($query);

if (!$pemesanan) {
    echo "Pesanan tidak ditemukan.";
    exit;
}

// Ambil data metode pembayaran
$metode_query = mysqli_query($koneksi, "SELECT * FROM metode_pembayaran");
$metode_pembayaran = [];
while($row = mysqli_fetch_assoc($metode_query)) {
    $metode_pembayaran[] = $row;
}

// Proses form pembayaran
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_metode_pembayaran = $_POST['id_metode_pembayaran'];
    $status_pemesanan = 'pending';
    $status_pembayaran = 'menunggu konfirmasi';

    // Upload bukti pembayaran
    $bukti_name = $_FILES['bukti']['name'];
    $bukti_tmp = $_FILES['bukti']['tmp_name'];
    $bukti_ext = pathinfo($bukti_name, PATHINFO_EXTENSION);
    $bukti_new = 'bukti_' . time() . '.' . $bukti_ext;

    move_uploaded_file($bukti_tmp, '../uploads/' . $bukti_new);

    // Update status di pemesanan
    $update = mysqli_query($koneksi, "UPDATE pemesanan SET status='$status_pemesanan' WHERE id_pemesanan='$id_pemesanan'");

    // Masukkan ke tabel pembayaran
    $insert_bayar = mysqli_query($koneksi, "INSERT INTO pembayaran (id_pemesanan, id_metode_pembayaran, bukti_pembayaran, status) VALUES ('$id_pemesanan', '$id_metode_pembayaran', '$bukti_new', '$status_pembayaran')");

    if ($update && $insert_bayar) {
        echo "<script>alert('Pembayaran berhasil. Silakan tunggu konfirmasi.'); window.location.href='riwayat_pesanan.php';</script>";
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
    <title>Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container-card {
            max-width: 600px;
            margin: 0 50px;
            padding: 25px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .container-card h1 {
            text-align: center;
            margin-bottom: 25px;
        }
        .produk {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .produk img {
            width: 100px;
            border-radius: 8px;
            margin-right: 15px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        select, input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .no-akun {
            margin-top: 5px;
            font-size: 0.9em;
            color: #555;
            display: none;
        }
    </style>
</head>
<body>
     <?php
        include ('./header.php');
    ?>
    <div class="pt-28 flex justify-center">
    <div class="container-card">
        <h1>Pembayaran</h1>

        <div class="produk">
            <img src="../uploads/<?= $pemesanan['foto'] ?>" alt="<?= $pemesanan['nama'] ?>">
            <div>
                <h3><?= $pemesanan['nama'] ?></h3>
                <p>Jumlah: <?= $pemesanan['jumlah_produk'] ?></p>
                <p>Total Bayar: Rp <?= number_format($pemesanan['total_bayar'], 0, ',', '.') ?></p>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="id_metode_pembayaran">Pilih Metode Pembayaran:</label>
                <select name="id_metode_pembayaran" id="id_metode_pembayaran" required onchange="tampilkanNoAkun()">
                    <option value="">--Pilih--</option>
                    <?php foreach($metode_pembayaran as $metode): ?>
                        <option value="<?= $metode['id_metode_pembayaran'] ?>" data-noakun="<?= $metode['no_akun'] ?>">
                            <?= strtoupper($metode['provider']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="no-akun" id="no_akun"></div>
            </div>
            
            <div class="form-group">
                <label for="bukti">Upload Bukti Pembayaran:</label>
                <input type="file" name="bukti" id="bukti" accept="image/*" required>
            </div>

            <button type="submit">Konfirmasi Pembayaran</button>
        </form>
    </div>
</div>

    <script>
        function tampilkanNoAkun() {
            const select = document.getElementById('id_metode_pembayaran');
            const selectedOption = select.options[select.selectedIndex];
            const noAkun = selectedOption.getAttribute('data-noakun');
            const noAkunDiv = document.getElementById('no_akun');

            if(noAkun){
                noAkunDiv.style.display = 'block';
                noAkunDiv.innerHTML = "No. Akun: " + noAkun;
            } else {
                noAkunDiv.style.display = 'none';
                noAkunDiv.innerHTML = "";
            }
        }
    </script>
</body>
</html>
