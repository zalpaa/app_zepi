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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">

<?php include "header.php" ?>

<div class="pt-28 flex justify-center">
    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-xl">
        <h1 class="text-2xl font-semibold text-center text-gray-800 mb-6">Pembayaran</h1>

        <div class="flex items-center gap-4 mb-6">
            <img src="../uploads/<?= $pemesanan['foto'] ?>" alt="<?= $pemesanan['nama'] ?>" class="w-24 h-24 object-cover rounded">
            <div>
                <h3 class="text-lg font-semibold text-gray-800"><?= $pemesanan['nama'] ?></h3>
                <p class="text-sm text-gray-600">Jumlah: <?= $pemesanan['jumlah_produk'] ?></p>
                <p class="text-sm text-gray-600">Total Bayar: <span class="text-green-600 font-semibold">Rp <?= number_format($pemesanan['total_bayar'], 0, ',', '.') ?></span></p>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data" class="space-y-5">
            <div>
                <label for="id_metode_pembayaran" class="block text-sm font-medium text-gray-700 mb-1">Pilih Metode Pembayaran:</label>
                <select name="id_metode_pembayaran" id="id_metode_pembayaran" required onchange="tampilkanNoAkun()" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">-- Pilih --</option>
                    <?php foreach($metode_pembayaran as $metode): ?>
                        <option value="<?= $metode['id_metode_pembayaran'] ?>" data-noakun="<?= $metode['no_akun'] ?>">
                            <?= strtoupper($metode['provider']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="mt-1 text-sm text-gray-600 hidden" id="no_akun"></div>
            </div>

            <div>
                <label for="bukti" class="block text-sm font-medium text-gray-700 mb-1">Upload Bukti Pembayaran:</label>
                <input type="file" name="bukti" id="bukti" accept="image/*" required class="block w-full border px-3 py-2 rounded">
            </div>

            <button type="submit" class="w-full px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">Konfirmasi Pembayaran</button>
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
